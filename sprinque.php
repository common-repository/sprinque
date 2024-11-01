<?php
/*
Plugin Name: Sprinque
Plugin URI: https://sprinque.com/
Description: Sprinque for WordPress is a plugin that allows you to offer your business buyers net payment terms (15, 30, 60, 90 days) and thereby grow conversion and retention.
Author: Sprinque
Version: 1.14.1
Text Domain: sprinque
Domain Path: /languages
*/

define( 'PLUGIN_SRINQUE_VERSION', '1.14.1' );
define( 'PLUGIN_SRINQUE_DIR', __DIR__ );
define( 'PLUGIN_SRINQUE_PATH', plugins_url( '', __FILE__ ) );

// Map locales
add_filter('plugin_locale', 'sprinque_map_locales', 10, 2);
if (!function_exists('sprinque_map_locales')) {
    function sprinque_map_locales($locale, $domain) {
        if ($domain !== 'sprinque') {
            return $locale;
        }

        switch ($locale) {
            case 'de':
            case 'de_AT':
            case 'de_CH':
            case 'de_CH_informal':
            case 'de_DE_formal':
            case 'de-DE': return 'de_DE';
            case 'fr':
            case 'fr-FR':
            case 'fr_FR':
            case 'fr_BE':
            case 'fr_CA': return 'fr_FR';
            case 'es_AR':
            case 'es_CL':
            case 'es_CR':
            case 'es_EC':
            case 'es_ES':
            case 'es_GT':
            case 'es_MX':
            case 'es_PE':
            case 'es_PR':
            case 'es_UY':
            case 'es_VE':
            case 'es_CO': return 'es_ES';
            case 'nl_BE':
            case 'nl_NL':
            case 'nl_NL_formal':
            case 'nl': return 'nl_NL';
            case 'it': return 'it_IT';
            case 'pl': return 'pl_PL';
            default: return $locale;
        }
    }
}

require_once( 'include/helper_functions.php' );
require_once( 'include/payment_method.php' );


class SprinqueInitialize {

    /**
     * How many tries should we try before sending the report
     */
    protected const MAX_ATTEMPTS = 3;

    /**
     * Email report recipient
     */
    protected const API_ERROR_REPORT_RECIPIENT = 'plugins@sprinque.com';

    public const INSTALMENTS = [ 'PAY_IN_3', 'PAY_IN_6','PAY_IN_9','PAY_IN_12' ];

    public $first_response = false;

    public function __construct() {
        // Include Styles and Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'include_scripts_and_styles' ], 99 );

        // WooCommerce Hooks
        add_action( 'init', [ $this, 'register_review_order_status' ], 99 );
        add_action( 'init', [ $this, 'loading_text_domains' ], 99 );
        add_filter( 'wc_order_statuses', [ $this, 'add_review_to_order_statuses' ], 99 );

        $settings = get_option( 'woocommerce_wpm_srinque_pay_settings', true ) ?? '';

        if( ! empty( $settings ) && ! empty( $settings['api_key'] ) ) {
            $this->get_payment_terms();
            add_filter( 'woocommerce_available_payment_gateways', [ $this, 'show_sprinque_pay_by_country' ] );
        }

        // WebHook functions
        add_action( 'init', [ $this, 'get_webhook_response' ], 99 );

        // Orders and cart
        add_action( 'woocommerce_order_status_completed', [ $this, 'send_capture_authorized_order' ], 10, 99 );
        add_action( 'woocommerce_order_status_shipping', [ $this, 'send_capture_authorized_order' ], 10, 99 );
        add_action( 'woocommerce_order_refunded', [ $this, 'send_refund_captured_order' ], 10, 1 );
        add_action( 'woocommerce_update_order', [ $this, 'send_refund_voided_order' ], 10, 1 );
        add_action( 'woocommerce_cart_calculate_fees', [ $this, 'calculate_fees' ] );

        // Initialize RestAPI
        add_action('rest_api_init', [$this, 'initialize_rest_api_init'], 99);

        // Handle HTTP requests
        add_filter( 'http_response', [ $this, 'handle_http_response' ], 99, 3 );
        add_filter( 'http_request_args', [ $this, 'append_retry_counter' ], 99, 2 );
        add_filter( 'sprinque_retry_capture_request', [ $this, 'retry_capture_request' ], 10, 2 );
    }

    /**
     * Add Rest Routes for API
     */
    public function initialize_rest_api_init()
    {
        register_rest_route('sprinque/v1', '/seller/payment-collection-account', array(
            'methods' => 'GET',
            'callback' => [$this, 'seller_payment_account'],
            'permission_callback' => [$this, 'permissions_check'],
        ));

        register_rest_route('sprinque/v1', '/seller/payment-collection-accounts', array(
            'methods' => 'GET',
            'callback' => [$this, 'seller_payment_accounts'],
            'permission_callback' => [$this, 'permissions_check'],
        ));
    }

    /**
     * Check permissions for REST access
     */
    public function permissions_check(WP_REST_Request $request) {
        return true;
    }

    /**
     * Add Rest Routes for API
     */
    public function seller_payment_account(WP_REST_Request $request)
    {
        // Get Data from Request
        $data = $request->get_params();

        return $this->srinque_api( '', 'GET', "/seller/payment-collection-account" );
    }

    public function seller_payment_accounts(WP_REST_Request $request)
    {
        // Get Data from Request
        $data = $request->get_params();

        return $this->srinque_api( '', 'GET', "/seller/payment-collection-accounts" );
    }

    /**
     * Delete not needed params from the url
     */
    protected function remove_query_arg( $url, $key )
    {
        $url = htmlspecialchars_decode($url);
        $parsed_url = parse_url($url);
        $query = array();

        if(isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $query);
            unset($query[$key]); // remove the unwanted parameter
        }

        $new_query_string = http_build_query($query);
        $new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];
        if($new_query_string) {
            $new_url .= '?' . $new_query_string;
        }
        if(isset($parsed_url['fragment'])) {
            $new_url .= '#' . $parsed_url['fragment'];
        }

        return $new_url;
    }

    /**
     * Get PDF invoice urle
     */
    public function get_pdf_invoice( $order )
    {
        $pdf_url = '';

        if ( empty( $order ) ) {
            return $pdf_url;
        }

        if( class_exists( 'WPO_WCPDF' ) ) {
            $pdf_url = WPO_WCPDF()->endpoint->get_document_link( $order, 'invoice', array(
                'order_key' => $order->get_order_key(),
            ) );
        }
        else {
            $pdf_url = add_query_arg( array(
                'action'        => 'generate_wpo_wcpdf',
                'document_type' => 'invoice',
                'order_ids'     => $order->get_id(),
                'order_key'     => $order->get_order_key(),
            ), admin_url( 'admin-ajax.php' ) );

        }

        $pdf_url = $this->remove_query_arg( $pdf_url, 'access_key' );

        return $pdf_url;
    }

    /**
     * @param WC_Order $order
     * @param string $type
     * @return string
     */
    public function upload_pdf_invoice(WC_Order $order, string $type = 'invoice' )
    {
        $website_name = get_bloginfo( 'name' );
        $website_name = preg_replace('/[^A-Za-z0-9\-]/', '', $website_name);

        $filename = $website_name . '-' . $order->get_id() . '-' . $type . '.pdf';
        $pdf_url = $this->get_pdf_invoice($order);
        $pdf_content = file_get_contents($pdf_url);

        $result = $this->sprinque_upload_file($pdf_content, $filename, strlen($pdf_content));

        if (array_key_exists('file_id', $result)) {
            return $result['file_id'];
        }

        throw new \Exception("The invoice file could not be loaded");
    }

    public function sprinque_upload_file( $file, string $filename, $size )
    {
        $boundary = wp_generate_password( 24 );
        $headers = [
            'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
            'Content-Disposition' => 'form-data; name="file"; filename="' . basename($filename) . '"',
        ];

        $body = '--' . $boundary;
        $body .= "\r\n";
        $body .= 'Content-Disposition: form-data; name="file"; filename="' . basename( $filename ) . '"' . "\r\n";
        $body .= 'Content-Type: application/pdf' . "\r\n";
        $body .= "\r\n";
        $body .= $file;
        $body .= "\r\n";
        $body .= '--' . $boundary . '--';

        return $this->sprinque_send_http_request('/upload_file', 'POST', $body, $headers);
    }

    /**
     * Send Refund order after Refund on Edit Order
     */
    public function send_refund_captured_order($order_id)
    {
        // Prepare order data
        $order          = wc_get_order( $order_id );
        $order_refunds  = $order->get_refunds();
        $transaction_id = $order->get_meta( 'transaction_id', true ) ?? false;

        $settings = get_option( 'woocommerce_wpm_srinque_pay_settings', true );

        // Loop through the order refunds array
        $refunded = 0;
        $total_refund = 0;
        if(!empty($order_refunds)) {
            foreach( $order_refunds as $item => $refund ) {
                if($item == 0) {
                    $refunded = $refund->amount;
                }
                $total_refund += $refund->amount;
            }
        }

        // If transaction isset
        if( in_array($order->get_status(), ['shipping', 'completed', 'refunded'])
            && $transaction_id && $refunded > 0
            && $order->get_meta( 'is_order_captured', true ) == 'true' ) {

            // Create PDF Link for Invoice
            $pdf_invoice_file_id = $this->upload_pdf_invoice( $order, 'refund' );

            $data = [
                'merchant_credit_note_id' => time(),
                'file_id'                 => $pdf_invoice_file_id,
                'credit_note_amount'      => $refunded,
                'credit_note_currency'    => $order->get_currency(),
                'date'                    => date( 'Y-m-d' )
            ];

            $response = $this->srinque_api( $data, 'POST', "/transactions/refund/{$transaction_id}" );
            $this->first_response = true;
        } elseif (in_array($order->get_status(), ['processing', 'awaiting-review', 'refunded']) && $transaction_id && $total_refund == $order->get_total()) {
            $data = [
                'metadata' => []
            ];
            $response = $this->srinque_api( $data, 'POST', "/transactions/void/{$transaction_id}" );
            $this->first_response = true;
        }

        if(isset($response['errors'])) {
            echo '<pre>';
            print_r($response);
            echo '</pre>';
            die;
        }
    }

    /**
     * Send Refund or Void to canceled order after Update on Edit Order
     */
    public function send_refund_voided_order($order_id)
    {
        if ( ! isset($_POST['order_status'] ) || $_POST['order_status'] != 'wc-cancelled') {
            return false;
        }
        if ($this->first_response == true) {
            return false;
        }

        // Prepare order data
        $order          = wc_get_order( $order_id );
        $order_refunds  = $order->get_refunds();
        $transaction_id = $order->get_meta( 'transaction_id', true ) ?? false;

        $settings = get_option( 'woocommerce_wpm_srinque_pay_settings', true );

        // Which type of decline Order is use
        if( in_array($order->get_status(), ['shipping', 'completed'])
            && $transaction_id && $order->get_meta( 'is_order_captured', true ) == 'true' ) {

            // Create PDF Link for Invoice
            $pdf_file_id = $this->upload_pdf_invoice( $order, 'refund' );

            $data = [
                'merchant_credit_note_id' => $order_id,
                'file_id'                 => $pdf_file_id,
                'credit_note_amount'      => $order->get_total(),
                'date'                    => date( 'Y-m-d' )
            ];
            $response = $this->srinque_api( $data, 'POST', "/transactions/refund/{$transaction_id}" );
        } elseif (in_array($order->get_status(), ['processing']) && $transaction_id ) {
            $data = [
                'metadata' => []
            ];
            $response = $this->srinque_api( $data, 'POST', "/transactions/void/{$transaction_id}" );
        }
    }

    public function check_if_fee_added( $fees = array(), $fee_name = '' ) {

        if( ! empty( $fees ) && is_array( $fees ) ) {
            foreach ( $fees as $fee ) {
                if( isset( $fee->name ) && $fee->name === $fee_name ) {
                    return true;
                }
                if( method_exists( $fee, 'get_name' ) && $fee->get_name() === $fee_name ) {
                    return true;
                }
            }
        }
        return false;
    }

    public function calculate_fees()
    {
        global $woocommerce;

        if ( is_admin() && ! defined( 'DOING_AJAX' ) )
            return;

        if ( ! session_id() ) {
            session_start();
        }

        if ( !isset( $_SESSION['net_term'] ) ) {
            return;
        }


        $fees = $woocommerce->cart->get_fees();
        $net_term = $_SESSION['net_term'];

        if( ! in_array( $net_term, $this::INSTALMENTS ) ) {
            $net_term = strtolower($net_term);

            $days = substr($net_term, 3);
            $fee_name = __( sprintf('Surcharge payment term %d days', $days), 'sprinque' );
        }else{
            $net_term = strtolower($net_term);

            $days = substr($net_term, 7);
            $fee_name = __( sprintf('Surcharge pay in %d instalments', $days), 'sprinque' );
        }

        if ( $this->check_if_fee_added( $fees, $fee_name ) ) {
            return;
        }

        $payment_terms = $this->get_payment_terms();
        $percentage = $payment_terms[$net_term] ?? 0.0;
        $_SESSION['surcharge_fee'] = $percentage;
        $percentage /= 100;

        if ($percentage > 0) {
            $surcharge = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $percentage;
            $woocommerce->cart->add_fee( $fee_name, $surcharge, true, '' );
        }
    }

    /**
     * Remove SprinquePay if country is not Netherlands
     */
    public function show_sprinque_pay_by_country( $gateways ) {
        if (is_admin()) {
            return $gateways;
        }

        if (!is_null(WC()->customer)) {
            $country = WC()->customer->get_billing_country();
            $available_countries = array_column(sprinque_get_available_countries(), 'code');

            if ( !in_array($country, $available_countries) && isset( $gateways['wpm_srinque_pay']) ) {
                unset( $gateways['wpm_srinque_pay'] );
            }
        }

        return $gateways;
    }

    /**
     * Finish Capture Order after change status to Completed
     */
    public function send_capture_authorized_order( $order_id ) {
        $order = wc_get_order( $order_id );

        $transaction_id = $order->get_meta( 'transaction_id', true ) ?? false;

        // Loop through the order refunds array
        $order_refunds = $order->get_refunds();
        $total_refund = 0;

        if(!empty($order_refunds)) {
            foreach( $order_refunds as $refund ){
                $total_refund += $refund->amount;
            }
        }

        if ( !$transaction_id || $order->get_meta( 'is_order_captured', true ) == 'true' || $total_refund == $order->get_total()) {
            return ;
        }

        $order_id_from_sequential_plugin = $order->get_order_number();

        $settings = get_option( 'woocommerce_wpm_srinque_pay_settings', true );

        // Create PDF Link for Invoice
        $invoice_file_id = $this->upload_pdf_invoice( $order );

        $customer_ip = $order->get_meta( '_customer_ip_address', true ) ?? '';

        // Prepare Data to Send
        $data = [
            'merchant_order_id' => $order_id_from_sequential_plugin ?: $order_id,
            'invoice'  => [
                'merchant_invoice_id' => $this->get_invoice_number($order),
                'file_id'             => $invoice_file_id,
                'amount'              => round( ( $order->get_total() - $total_refund ), 2),
                'currency'            => $order->get_currency(),
                'date'                => date( 'Y-m-d' )
            ],
            'shipment' => [
                'address' => [
                    'address_line1' => $order->get_billing_address_1(),
                    'city'          => $order->get_billing_city(),
                    'zip_code'      => $order->get_billing_postcode(),
                    'country_code'  => $order->get_billing_country()
                ]
            ],
            'metadata' => [
                'IPv4' => strpos($customer_ip, ':') !== false ? "" : $customer_ip,
                'IPv6' => strpos($customer_ip, ':') !== false ? $customer_ip : "",
            ]
        ];

        // Get Data from API
        $response = $this->srinque_api( $data, 'POST', "/transactions/capture/{$transaction_id}" );
        $this->first_response = true;

        if(isset($response['errors'])) {
            echo '<pre>';
            print_r($response);
            echo '</pre>';
            die;
        } else {
            // Mark order as Captured
            if( isset( $order ) && ! empty( $order ) ){
                $order->update_meta_data( 'is_order_captured', 'true' );
                $order->save();
            }
        }
    }

    /**
     * Get Response from Sprinque WebHook
     */
    public function get_webhook_response() {

        $webhook = file_get_contents( "php://input" );
        $webhook = json_decode( $webhook, true );

        if(! empty( $webhook ) ) {
            $logs_sprinque = unserialize(get_option('logs_sprinque', true));
            if(is_array($logs_sprinque)) {
                $logs_sprinque[] = $webhook;
            } else {
                $logs_sprinque = [];
                $logs_sprinque[] = $webhook;
            }
            update_option('logs_sprinque', serialize($logs_sprinque));
        }

        $webhook_response = [
            'orders' => []
        ];

        if (!empty( $webhook ) && isset( $webhook['buyer_id'] ) && isset( $webhook['credit_qualification'] ) ) {

            $webhook_response['webhook_buyer_id'] = $webhook['buyer_id'];
            $webhook_response['webhook_credit_qualification'] = $webhook['credit_qualification'];
            $should_notify = false;

            // Get orders which waiting for approve
            $orders = wc_get_orders( array(
                'limit'      => - 1,
                'orderby'    => 'date',
                'order'      => 'DESC',
                'status'     => [ 'awaiting-review' ],
                'meta_key'      => 'review_order',
                'meta_value'    => $webhook['buyer_id'],
                'meta_compare'  => '='
            ) );

            if ($webhook['credit_qualification']['credit_decision'] === 'REJECTED') {
                /** @var WC_Order $order */
                foreach ($orders as $order) {
                    $order->update_status('failed');
                }

                die();
            }

            $settings = get_option( 'woocommerce_wpm_srinque_pay_settings', true );

            // Change order Status
            foreach ( $orders as $order ) {

                $webhook_order = [
                    'id' => $order->get_id(),
                    'order_number' => $order->get_order_number(),
                    'status' => $order->get_status(),
                    'buyer_id' => $order->get_meta( 'review_order', true ) ?? ''
                ];

                try {
                    if ( $webhook['credit_qualification']['credit_decision'] == 'APPROVED' OR $webhook['credit_qualification']['credit_decision'] == 'REJECTED' ) {
                        $order = wc_get_order( $order->ID );
                        $order_id_from_sequential_plugin = $order->get_order_number();

                        // Get saved user's IP address
                        $ip_address = $order->get_meta( 'ip_address', true ) ?? '';

                        // Calculate order total
                        $payment_term = sanitize_text_field( $webhook['credit_qualification']['payment_terms'] );
                        $payment_terms = $this->get_payment_terms();
                        $total = $order->get_total();
                        $fee = $payment_terms[ strtolower($payment_term) ];
                        $fee_percents = floatval($fee) / 100;
                        $calculated_fee = $total * $fee_percents;
                        $total += $calculated_fee;
                        $total = round($total, 2);

                        // Get buyer
                        $buyer = $this->srinque_api( [], 'GET', "/buyers/{$webhook['buyer_id']}" );

                        // Prepare Data to Send
                        $data = [
                            'merchant_order_id' =>  ( $order_id_from_sequential_plugin ?: $order->get_id() ) . '_wh',
                            'order_amount'      => $total,
                            'order_currency'    => $order->get_currency(),
                            'payment_terms' 	=> $payment_term,
                            'shipping_address'  => [
                                'address_line1' => $order->get_billing_address_1(),
                                'city'          => $order->get_billing_city(),
                                'zip_code'      => $order->get_billing_postcode(),
                                'country_code'  => $order->get_billing_country()
                            ],
                            'issued_by' => strtolower($order->get_billing_email()),
                            'metadata' => [
                                'IPv4' => !strpos($ip_address, ':') !== false ? $ip_address : '',
                                'IPv6' => strpos($ip_address, ':') !== false ? $ip_address : '',
                                'business_name' => $buyer['business_name']
                            ]
                        ];

                        /// Get saved metadata
                        $metadata = $order->get_meta('fingerprint');
                        $metadata = base64_decode($metadata);
                        $metadata = json_decode($metadata, true);

                        $data['metadata'] = array_merge($metadata, $data['metadata']);

                        // Get Data from API
                        $result = $this->srinque_api( $data, 'POST', "/transactions/authorize/{$webhook['buyer_id']}" );

                        // Save API Result to Order
                        if ($webhook['credit_qualification']['credit_decision'] == 'APPROVED') {
                            $status = 'processing';
                        }
                        elseif ($webhook['credit_qualification']['credit_decision'] == 'REJECTED') {
                            $status = 'failed';
                            $order = new WC_Order( $order->ID );
                            $order->update_status($status);
                            $order->save();
                        }

                        if (isset($result['transaction_id'])) {

                            $webhook_order['transaction_id'] = $result['transaction_id'];

                            $order = new WC_Order( $order->ID );

                            $order->update_meta_data( 'transaction_id', $result['transaction_id'] );
                            $order->update_meta_data( 'merchant_order_id', $order->ID );

                            $order->update_meta_data( 'net_term', $payment_term );
                            $order->update_meta_data( 'buyer_fee_percentage', $fee );
                            $order->delete_meta_data('fingerprint');

                            $order->save();

                            $order->update_status($status);

                            $order->save();

                            $is_vat_exempt = ( 'yes' === $order->get_meta( 'is_vat_exempt' ) );

                            // Add fee if needed
                            if ($fee_percents > 0.0) {
                                $fees = $order->get_fees();
                                if( ! in_array( $payment_term, $this::INSTALMENTS ) ){
                                    $days = substr($payment_term, 3);

                                    $fee_name = __( sprintf('Surcharge payment term %d days', $days), 'sprinque' );
                                }else{
                                    $days = substr($payment_term, 7);
                                    $fee_name = __( sprintf('Surcharge pay in %d instalments', $days), 'sprinque' );
                                }

                                if ( ! $this->check_if_fee_added( $fees, $fee_name ) ) {
                                    $fee = new stdClass();
                                    $fee->name = $fee_name;
                                    $fee->amount = $calculated_fee;
                                    $fee->tax_status = $is_vat_exempt ? 'none' : 'taxable';
                                    $fee->total = $calculated_fee;

                                    $fee->tax = 0; // Set initial tax amount to 0
                                    $fee->taxable = !$is_vat_exempt; // True if not VAT exempt
                                    $fee->tax_data = array( 'total' => array(), 'subtotal' => array() ); // Empty arrays to be filled by WC

                                    $order->add_fee($fee);
                                    $order->calculate_totals();
                                }
                            }

                            // Save the order
                            $order->save();
                        } else {
                            $webhook_order['transaction_id'] = null;
                            $webhook_order['transaction_result'] = $result;
                            $should_notify = true;
                        }

                        $webhook_order['updated_status'] = $order->get_status();
                    }
                } catch (Exception $exception) {
                    $webhook_order['exception'] = [
                        'message' => $exception->getMessage(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'trace' => $exception->getTrace()
                    ];
                    $should_notify = true;
                }

                $webhook_response['orders'][] = $webhook_order;
            }

            if ($should_notify) {
                // Prepare variables
                $subject = 'Webhook failed';
                $headers = array('Content-Type: text/html; charset=UTF-8');

                // Format email content
                $emailContent = '<pre>' . json_encode($webhook_response, JSON_PRETTY_PRINT) . '</pre>';

                // Send notification
                wp_mail(self::API_ERROR_REPORT_RECIPIENT, $subject, $emailContent, $headers);
            }

            header('content-type: application/json');
            echo json_encode($webhook_response);
            die();
        }
    }

    /**
     * Send request to API
     */
    public function srinque_api( $data, $method, $route ) {
        $post_data = null;

        if($data != '' && $data != NULL && $method == 'POST') {
            $post_data = json_encode( $data );
        }

        return $this->sprinque_send_http_request($route, $method, $post_data, []);
    }

    /**
     * Loads the plugin textdomains
     * @return void
     */
    public function loading_text_domains() {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            $locale = isset($_POST['locale']) ? $_POST['locale'] : 'en_US';
            add_filter('determine_locale', function() use ($locale) { return $locale; });
        }
        load_plugin_textdomain( 'sprinque', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Register new Order Status
     */
    public function register_review_order_status() {
        register_post_status( 'wc-awaiting-review', array(
            'label'                     => __( 'Awaiting Review', 'sprinque' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Awaiting Review (%s)', 'Awaiting Review (%s)' )
        ) );
        register_post_status( 'wc-shipping', array(
            'label'                     => 'Shipping',
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Shipping', 'Shipping' )
        ) );
    }

    /**
     * Add Select new Order Status
     */
    public function add_review_to_order_statuses( $order_statuses ) {
        $new_order_statuses = [];
        // add new order status after processing
        foreach ( $order_statuses as $key => $status ) {
            $new_order_statuses[ $key ] = $status;
            if ( 'wc-processing' === $key ) {
                $new_order_statuses['wc-awaiting-review'] = __( 'Awaiting Review', 'sprinque' );
                $new_order_statuses['wc-shipping'] = __( 'Shipping', 'sprinque' );
            }
        }

        return $new_order_statuses;
    }

    /**
     * Include Scripts And Styles on FrontEnd
     */
    public function include_scripts_and_styles() {
        if ( is_checkout() ) {
            // Register styles
            wp_enqueue_style( 'wpm_srinque_pay', PLUGIN_SRINQUE_PATH . '/assets/css/frontend.css', false, PLUGIN_SRINQUE_VERSION, 'all' );

            // Register scripts
            $settings = get_option( 'woocommerce_wpm_srinque_pay_settings', true );

            wp_enqueue_script( 'wpm_srinque_tools', 'https://unpkg.com/b2b-sprinque-tools/dist/index.umd.min.js', array( ), PLUGIN_SRINQUE_VERSION, 'all' );
            wp_enqueue_script( 'wpm_what_is_srinque', 'https://unpkg.com/@sprinque/what-is-sprinque/dist/index.umd.min.js', array( ), PLUGIN_SRINQUE_VERSION, 'all' );
            wp_enqueue_script( 'wpm_srinque_pay', PLUGIN_SRINQUE_PATH . '/assets/js/frontend.js', array( 'jquery', 'wpm_srinque_tools', 'wpm_what_is_srinque' ), PLUGIN_SRINQUE_VERSION, 'all' );

            // Format description
            $description = $settings['description'] ?? '';
            $description = empty($description) ? 'Buy now and pay later for businesses' : $description;

            // Seller
            $seller = $this->get_seller_data();

            wp_localize_script( 'wpm_srinque_pay', 'admin', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'ajax_nonce' ),
                'method_title' => __( !empty($settings['title']) ? $settings['title'] : 'Pay by Invoice', 'sprinque' ).'<img src="'.PLUGIN_SRINQUE_PATH.'/assets/img/logo_' . ( !empty($settings['logo']) ? $settings['logo'] : 'light' ) . '.svg'.'">',
                'method_description' => __( $description, 'sprinque' ),
                'method_description_addition' => '. <a id="what-is-sprinque">' . __( 'That is how it works.', 'sprinque' ) . '</a>',
                'not_found_companies' => __( "Company not found", 'sprinque' ).'<span id="register-company-tab">'.__( "Click here", 'sprinque' ).'</span>'.__( "to use it anyway", 'sprinque' ),
                'not_found_companies_2' => __( "Company not found", 'sprinque' ).'<span id="register-company-tab-2">'.__( "Click here", 'sprinque' ).'</span>'.__( "to use it anyway", 'sprinque' ),
                'cant_find_business' => __( "Can't find the business you are looking for?", 'sprinque' ),
                'add_manually_business' => __( "Add buyer manually", 'sprinque' ),
                'fields_not_filled' => __( "Not all required fields are filled", 'sprinque' ),
                'loading' => __( "Loading...", 'sprinque' ),
                'place_order' => __( "Place order", 'sprinque' ),
                'days' => __('days', 'sprinque'),
                'payment_terms' => $this->get_payment_terms(),
                'currency_symbol' => get_woocommerce_currency_symbol(),
                'net_term_format' => __( "Net %s days", 'sprinque' ),
                'email_validation_error' => 'blocked-t-online',
                'email_validation_notice' => 'business-email-verification',
                'free' => __( "Free", 'sprinque' ),
                'pay_in_instalments_format' => __( "Pay in %s instalments", 'sprinque' ),
                'pay_in_instalments_circle' => __( "%s days", 'sprinque' ),
                'pay_in_x_days'   => !empty($settings['pay_in_x_days']) ? $settings['pay_in_x_days'] : '7-90',
                'enable_user_tracking' => $seller['enable_user_tracking'] ?? false,
                'locale' => get_locale()
            ) );
        }
    }

    public function get_payment_terms()
    {
        $payment_terms = get_option('sprinque_available_payment_terms', false);

        if (!$payment_terms) {
            do_action('sprinque_update_cache');
            $payment_terms = get_option('sprinque_available_payment_terms', false);
        }

        return $payment_terms;
    }

    public function update_payment_terms()
    {
        $payment_terms = $this->srinque_api([], 'GET', "/seller/pricing");

        if ( is_wp_error( $payment_terms ) ) {
            return [];
        }

        $payment_terms = $payment_terms['buyer_pricing_fee_percent'];
        if (!is_array($payment_terms)) {
            return [];
        }

        update_option('sprinque_available_payment_terms', $payment_terms);
    }

    public function update_countries()
    {
        $countries = $this->srinque_api([], 'GET', "/countries/");
        if (!is_array($countries)) {
            return [];
        }

        $countries = array_filter( $countries, function ($country) {
            return array_key_exists('status', $country) && $country['status'] === 'ACTIVE';
        });

        update_option('sprinque_available_countries', $countries);
    }

    /**
     * Get Seller Data
     */
    public function get_seller_data()
    {
        $seller = get_option('sprinque_seller', false);
        if (!$seller) {
            do_action('sprinque_update_cache');
            $seller = get_option('sprinque_seller', false);
        }

        return $seller;
    }

    public function update_seller()
    {
        $seller = $this->srinque_api( '', 'GET', "/seller" );
        update_option('sprinque_seller', $seller);
    }

    public function handle_http_response($response, $parsed_args, $url)
    {
        // Format API endpoint
        $settings = get_option( 'woocommerce_wpm_srinque_pay_settings', true );

        if ($settings['testmode'] == 'yes') {
            $api_url = 'https://api-sandbox.sprinque.com/api/v1';
        } else {
            $api_url = 'https://api.sprinque.com/api/v1';
        }
        // Filter response and ignore all requests except requests to Sprinque API
        if (strpos($url, $api_url) !== 0) {
            return $response;
        }

        // Get response status
        $status = $response['response']['code'];

        // Filter by status - ignore reporting for all requests with status 2xx and 3xx
        if ($status < 400) {
            return $response;
        }

        // If all attempts have been made
        if ($parsed_args['attempt'] > self::MAX_ATTEMPTS) {
            // Request failed several times
            // Send E-Mail to tech team

            // Prepare variables
            $body = json_decode($parsed_args['body']);
            $endpoint = str_replace($api_url, '', $url);
            $sitename = get_bloginfo('name');
            $subject = $endpoint . ' call failed for ' . $sitename;

            // Format email content
            $emailContent = json_encode($body, JSON_PRETTY_PRINT);
            $emailContent .= PHP_EOL;
            $emailContent .= PHP_EOL;
            $emailContent .= $response['body'];

            // Send report
            wp_mail(self::API_ERROR_REPORT_RECIPIENT, $subject, $emailContent);

            // Return response
            return $response;
        }

        if ( isset($parsed_args['should_ignore_retry'], $parsed_args['attempt']) && $parsed_args['should_ignore_retry'] && $parsed_args['attempt'] > 1) {
            // Schedule retry for 5 minutes
            wp_schedule_single_event( time() + (60 * 5), 'sprinque_retry_capture_request', array(
                'parsed_args' => $parsed_args,
                'url' => $url
            ) );
            return $response;
        } else {
            // Send request again
            return wp_remote_post( $url, $parsed_args);
        }
    }

    public function retry_capture_request($parsed_args, $url)
    {
        return wp_remote_post( $url, $parsed_args);
    }

    public function append_retry_counter($parsed_args, $url)
    {
        // Set initial attempt if needed
        if (!array_key_exists('attempt', $parsed_args)) {
            $parsed_args['attempt'] = 1;
        } else {
            // Increment attempts
            $parsed_args['attempt']++;
        }

        return $parsed_args;
    }

    /**
     * @param string $route
     * @param string $method
     * @param $data
     * @param array $headers
     * @return mixed|WP_Error|null
     */
    protected function sprinque_send_http_request($route, $method, $data = null, $headers = []) {
        $settings = get_option( 'woocommerce_wpm_srinque_pay_settings', true );

        if ($settings['testmode'] == 'yes') {
            $api_url = 'https://api-sandbox.sprinque.com/api/v1';
        } else {
            $api_url = 'https://api.sprinque.com/api/v1';
        }

        $post_data = [
            'method'  => $method,
            'timeout' => 100,
            'headers' => [
                "Content-type" => "application/json",
                "Accept"       => "application/json",
                "X-API-KEY-ID" => $settings['api_key']
            ],
        ];

        $post_data['headers'] = array_merge($post_data['headers'], $headers ?? []);

        if ($data !== null) {
            $post_data['body'] = $data;
        }

        if (strpos($route, "/transactions/capture") === 0) {
            // Mark request as capture
            $post_data['is_capture'] = true;
        } else {
            $post_data['is_capture'] = false;
        }

        $response = wp_remote_post( $api_url . $route, $post_data);

        if ( is_wp_error( $response ) ) {
            return new WP_Error( 'api_request_failed', 'API request failed. Please try again later.' );
        }

        // Check for a valid response and return it
        if ( is_array( $response ) && isset( $response['body'] ) ) {
            return json_decode( $response['body'], true );
        }

        // If the response is not valid, you can return a custom error or handle it as needed
        return new WP_Error( 'invalid_response', 'Invalid API response. Please check your settings.');
    }

    public function update_cache()
    {
        $this->update_payment_terms();
        $this->update_countries();
        $this->update_seller();
    }

    protected function get_invoice_number($order)
    {
        $invoice_number = $order->get_meta('_wcpdf_invoice_number');
        $invoice_number = strlen($invoice_number) > 0 ? $invoice_number : null;

        if ($invoice_number) {
            return $invoice_number;
        }

        $order_id_from_sequential_plugin = $order->get_order_number();

        if ($order_id_from_sequential_plugin) {
            return $order_id_from_sequential_plugin;
        }

        return $order->get_id();
    }

}

$sprinqueInitialize = new SprinqueInitialize();

add_filter( 'woocommerce_gateway_title', 'change_sprinque_payment_method_description',10, 2);

function change_sprinque_payment_method_description( $title, $id ){
    if( $id === 'wpm_srinque_pay' && is_admin() ){
        $title = __( 'Pay by invoice with Sprinque', 'sprinque' );
    }
    return $title;
}
add_filter( 'woocommerce_gateway_method_title', 'change_sprinque_payment_gateway_title',10, 2);

function change_sprinque_payment_gateway_title( $method_title, $payment_gateway ){
    if( $payment_gateway->id === 'wpm_srinque_pay' && is_admin() ){
        $method_title = __( 'Sprinque', 'sprinque' );
    }
    return $method_title;
}


// Save data to cache
add_action( 'wp', 'sprinque_schedule_update_cache' );

function sprinque_schedule_update_cache() {
    if (!wp_next_scheduled('sprinque_update_cache')) {
        wp_schedule_event(strtotime('midnight'), 'daily', 'sprinque_update_cache');
    }
}

add_action( 'sprinque_update_cache', [ $sprinqueInitialize, 'update_cache' ] );
