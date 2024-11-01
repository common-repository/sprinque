<?php

// Payment Hooks
add_filter( 'woocommerce_payment_gateways', 'wpm_srinque_add_to_gateways', 99 );
add_action( 'plugins_loaded', 'sprinque_initialize_payment_class', 99 );

// Ajax Functions
add_action( 'wp_ajax_sprinque_search_business_api', 'sprinque_search_business_api', 99 );
add_action( 'wp_ajax_nopriv_sprinque_search_business_api', 'sprinque_search_business_api', 99 );
add_action( 'wp_ajax_sprinque_authorize_company_order', 'sprinque_authorize_company_order', 99 );
add_action( 'wp_ajax_nopriv_sprinque_authorize_company_order', 'sprinque_authorize_company_order', 99 );
add_action( 'wp_ajax_sprinque_get_buyer_details', 'sprinque_get_buyer_details', 99 );
add_action( 'wp_ajax_nopriv_sprinque_get_buyer_details', 'sprinque_get_buyer_details', 99 );
add_action( 'wp_ajax_sprinque_mark_for_review_and_wait', 'sprinque_mark_for_review_and_wait', 99 );
add_action( 'wp_ajax_nopriv_sprinque_mark_for_review_and_wait', 'sprinque_mark_for_review_and_wait', 99 );

add_action( 'wp_ajax_sprinque_get_buyer_info', 'sprinque_get_buyer_info', 99 );
add_action( 'wp_ajax_nopriv_sprinque_get_buyer_info', 'sprinque_get_buyer_info', 99 );

// Probably we duplicate OTP actions here
add_action( 'wp_ajax_sprinque_verify_otp_code', 'sprinque_verify_otp_code', 99 );
add_action( 'wp_ajax_nopriv_sprinque_verify_otp_code', 'sprinque_verify_otp_code', 99 );
add_action( 'wp_ajax_sprinque_send_otp_verification', 'sprinque_send_otp_verification', 99 );
add_action( 'wp_ajax_nopriv_sprinque_send_otp_verification', 'sprinque_send_otp_verification', 99 );

add_action( 'wp_ajax_sprinque_register_buyer', 'sprinque_register_buyer_api', 99 );
add_action( 'wp_ajax_nopriv_sprinque_register_buyer', 'sprinque_register_buyer_api', 99 );

add_action( 'wp_ajax_sprinque_get_countries_api', 'sprinque_get_countries_api', 99 );
add_action( 'wp_ajax_nopriv_sprinque_get_countries_api', 'sprinque_get_countries_api', 99 );

// Validate the checkout form
add_action( 'wp_ajax_sprinque_validate_checkout', 'sprinque_validate_checkout' );
add_action( 'wp_ajax_nopriv_sprinque_validate_checkout', 'sprinque_validate_checkout' );

// Visual Hooks
add_action( 'woocommerce_after_checkout_form', 'srinque_pay_modal_form', 99 );

add_filter('woocommerce_generate_radio_html', 'sprinque_generate_radio_html');

/**
 * Get Buyer Info
 */
function sprinque_get_buyer_info() {
	$SrinquePay = new WPM_SrinquePay;
	$SrinquePay->sprinque_get_buyer_info();
}

/**
 * Verify OTP Code
 */
function sprinque_verify_otp_code() {
	$SrinquePay = new WPM_SrinquePay;
	$SrinquePay->sprinque_verify_otp_code();
}

/**
 * Register Buyer on Sprinque
 */
function sprinque_send_otp_verification() {
	$SrinquePay = new WPM_SrinquePay;
	$SrinquePay->sprinque_send_otp_verification();
}

/**
 * Register Buyer on Sprinque
 */
function sprinque_register_buyer_api() {
	$SrinquePay = new WPM_SrinquePay;
	$SrinquePay->sprinque_register_buyer_api();
}

/**
 * Find Business details by Country Code and Name
 */
function sprinque_search_business_api() {
	$SrinquePay = new WPM_SrinquePay;
	$SrinquePay->sprinque_search_business_api();
}

/**
 * Find Business details by Country Code and Name
 */
function sprinque_authorize_company_order() {
	$SrinquePay = new WPM_SrinquePay;
	$SrinquePay->sprinque_authorize_company_order();
}

/**
 * Get buyer details
 */
function sprinque_get_buyer_details() {
	$SrinquePay = new WPM_SrinquePay;
	$SrinquePay->sprinque_get_buyer_details();
}

function sprinque_mark_for_review_and_wait() {
	$SprinquePay = new WPM_SrinquePay;
	$SprinquePay->sprinque_mark_for_review_and_wait();
}

/**
 * Add Credits Payment Method
 */
function wpm_srinque_add_to_gateways( $gateways ) {
	$gateways[] = 'WPM_SrinquePay';

	return $gateways;
}

/**
 * Get countries list and their attributes
 */
function sprinque_get_countries_api() {
	$SrinquePay = new WPM_SrinquePay;
	$SrinquePay->sprinque_get_countries_api();
}

/**
 * Get available countries list
 */
function sprinque_get_available_countries() {
	$SrinquePay = new WPM_SrinquePay;

    return $SrinquePay->sprinque_get_available_countries();
}

function sprinque_validate_checkout() {
    $sprinquePay = new WPM_SrinquePay;
    $sprinquePay->validate_checkout();
}

function srinque_pay_modal_form() {
	$SrinquePay = new WPM_SrinquePay;

	return $SrinquePay->srinque_pay_modal_form();
}

function sprinque_generate_radio_html() {
    $sprinquePay = new WPM_SrinquePay;

    return $sprinquePay->generate_radio_html();
}

/**
 * Initialize payment Class
 */
function sprinque_initialize_payment_class() {
	class WPM_SrinquePay extends WC_Payment_Gateway {

		protected $last_api_response = null;

		/**
		 * Constructor for the gateway.
		 */
		public function __construct() {

			$this->id                 = 'wpm_srinque_pay';
			$this->icon               = PLUGIN_SRINQUE_PATH.'/assets/img/logo_' . $this->get_option('icon', 'light') . '.svg';
			$this->has_fields         = false;
			$this->method_title       =  __( 'Pay by Invoice', 'sprinque' );
			$this->method_description = __( 'Buy now and pay later for businesses', 'sprinque' );

			// Load the settings.
			$this->init_form_fields();
			$this->init_settings();

            // Format description
            $description = $this->get_option('description', 'Buy now and pay later for businesses');
            $description = __( $description, 'sprinque' );

            // Format title
            $title = $this->get_option('title', 'Pay by Invoice');
            $title = __( $title, 'sprinque' );

            // Define user set variables
			$this->title        = $title;
			$this->description  = $description;
			$this->instructions = __( 'Order finished with Pay by Invoice', 'sprinque' );
			$this->testmode     = 'yes' === $this->get_option( 'testmode' );
			$this->api_key      = $this->get_option( 'api_key' );

			// Actions
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		}

        public function validate_checkout()
        {
            include_once 'ValidationException.php';
            include_once 'CheckoutValidator.php';

            $wc = new CheckoutValidator();
            try {
                $wc->test();
                wp_send_json_success();
                die();
            } catch (ValidationException $e) {
                wp_send_json_error([
                    'messages' => $e->getMessages()
                ]);
            }
        }

		/**
		 * Add Modal Form for API Ordering
		 */
		public function srinque_pay_modal_form() {
			// Get list of countries
			$countries = countries();
			$seller_data = $this->get_seller_data();

			// Get current user country
			$user_country      = WC()->cart->get_customer()->get_billing_country();
			$user_company      = WC()->cart->get_customer()->get_billing_company();
			$billing_address_1 = WC()->cart->get_customer()->get_billing_address();
			$billing_address_2 = WC()->cart->get_customer()->get_billing_address_2();
			$billing_city      = WC()->cart->get_customer()->get_billing_city();
			$billing_postcode  = WC()->cart->get_customer()->get_billing_postcode();

			include( PLUGIN_SRINQUE_DIR . '/templates/frontend/srinque_pay_modal_form.php' );
		}

		/**
		 * Get List Sprinque companies
		 */
		public function sprinque_search_business_api() {
			if (! isset( $_POST['country_code'] ) || ! isset( $_POST['company_name'] ) ) {
				return false;
			}

			$company_name = sanitize_text_field( $_POST['company_name'] );
			$search_by = sanitize_text_field( $_POST['search_by'] );

			if ($search_by === 'name') {
				$search_by = 'NAME';
			} else {
				$search_by = 'VAT_ID';
			}

			// Prepare Data to Send
			$data = [
				'country_code'  => sanitize_text_field( $_POST['country_code'] ),
				'search_term' => stripslashes($company_name),
				'search_type' => $search_by
			];

			// Get Data from API
			$companies_list    = $this->srinque_api( $data, 'POST', '/search/business' );
			$companies_details = [];

			if ( isset( $companies_list['businesses'] ) && ! empty( $companies_list['businesses'] ) ) {
				foreach ( $companies_list['businesses'] as $item => $business ) {

					$companies_details[] = $business;

					if ( $item >= 9 ) {
						break;
					}
				}
			}

			ob_start();
			include( PLUGIN_SRINQUE_DIR . '/templates/ajax/founded_companies.php' );
			$result = ob_get_clean();

			wp_send_json( [
				'status'  => 'true',
				'html'    => $result,
				'details' => $companies_details
			] );
		}

		/**
		 * Register new buyer on Sprinque
		 */
		public function sprinque_register_buyer_api() {
				
			if (! isset( $_POST['business_name'] ) ) {
				return false;
			}

            // Dont start a sessions unless we are going to do things with the business name.
            if ( ! session_id() ) {
                session_start();
			}

			// Get the user's IP address
			$ip = $this->get_ip_address();

			// Prepare Data to Send
			$merchant_buyer_id = time();
			$email = sanitize_text_field( $_POST['email'] );
			$email = strtolower($email);
			$billing_email = sanitize_text_field( $_POST['billing_email'] );
			$billing_email = strtolower($billing_email);
			$phone_number = sanitize_text_field($_POST['phone']);
			$phone_number = str_replace([' ', '/', '-'], '', $phone_number);
			$phone = $phone_number;
			$country = sanitize_text_field( $_POST['country_code'] );
			$business_name = sanitize_text_field( $_POST['business_name'] );
			$metadata = $_POST['metadata'] ?? [];

			if( ! empty( $email ) ) {
				if( ! is_email( $email ) ) {
					wp_send_json( [
						'status'   => 'false',
						'message'  => __( "Enter a valid email address.", 'sprinque' ),
						'response' => [
							"error_code" => "invalid-field",
							"errors" => [
								"email" => [
									__( "Enter a valid email address.", 'sprinque' )
								]
							]
						]
					] );
				}
			}
			if( ! empty( $billing_email ) ){
				if( ! is_email( $billing_email ) ) {
					wp_send_json( [
						'status'   => 'false',
						'message'  => __( "Enter a valid Billing or Accounts Payable email address.", 'sprinque' ),
						'response' => [
							"error_code" => "invalid-field",
							"errors" => [
								"email" => [
									__( "Enter a valid Billing or Accounts Payable email address.", 'sprinque' )
								]
							]
						]
					] );
				}
			}
			

			$lang = $this->get_current_language();

            $countries = $this->sprinque_get_available_countries();
            $country_object = null;
            foreach ($countries as $item) {
                if ($item['code'] === $country) {
                    $country_object = $item;
                    break;
                }
            }

			// Prepare Data
			$data              = [
				'merchant_buyer_id'   => time(),
				'business_name'       => stripslashes($business_name),
				'phone' => $phone_number,
				'email' => $billing_email,
				'address'             => [
					'address_line1' => sanitize_text_field( $_POST['address_line1'] ),
					'address_line2' => sanitize_text_field( $_POST['address_line2'] ),
					'city'          => sanitize_text_field( $_POST['city'] ),
					'zip_code'      => sanitize_text_field( $_POST['zip_code'] ),
					'country_code'  => $country
				],
				'buyer_users'         => [
					0 => [
						'first_name' => sanitize_text_field( $_POST['first_name'] ),
						'last_name'  => sanitize_text_field( $_POST['last_name'] ),
						'email'      => $email,
						'phone' => $phone_number,
						'role'       => 'MEMBER'
					]
				],
				'metadata' => [
					'IPv4' => !strpos($ip, ':') !== false ? $ip : '',
					'IPv6' => strpos($ip, ':') !== false ? $ip : ''
				]
			];

			if( ! empty( $metadata ) ) {
				$data['metadata'] = array_merge($data['metadata'], $metadata);
			}

            if (!empty($_POST['initial_shipping_address_line1'])) {
                $data = array_merge($data, [
                    'initial_shipping_address' => [
                        'address_line1' => sanitize_text_field( $_POST['initial_shipping_address_line1'] ),
                        'address_line2' => sanitize_text_field( $_POST['initial_shipping_address_line2'] ),
                        'city'          => sanitize_text_field( $_POST['initial_shipping_city'] ),
                        'zip_code'      => sanitize_text_field( $_POST['initial_shipping_zip_code'] ),
                        'country_code'  => sanitize_text_field( $_POST['initial_shipping_country_code'] )
                    ]
                ]);
            }

            if ($country_object !== null && (!empty($_POST['registration_number']) || $country_object['is_registration_number_required'])) {
                $data = array_merge($data, [
                    'registration_number' => sanitize_text_field( $_POST['registration_number'] ),
                ]);
            }

			if ( WC()->cart ) {
				$total = WC()->cart->get_total('edit');
				$currency = get_woocommerce_currency();
				
				$data = array_merge($data, [
                    'initial_order_amount' => round( $total, 2),
					'initial_order_currency' => sanitize_text_field( $currency )
                ]);
			}

			if ($lang !== null) {
				$language_attribute = ['language' => $lang];

				$data = array_merge($data, $language_attribute);
				$data['buyer_users'][0] = array_merge($data['buyer_users'][0], $language_attribute);
			}

            if ( !empty( $_POST['credit_bureau_id'] ) ) {
                $data['credit_bureau_id'] = sanitize_text_field( $_POST['credit_bureau_id'] );
            }

			$buyer = $this->srinque_api( $data, 'POST', '/buyers/' );

			// Check if Buyer is registered and not blocked
			if (
                isset( $buyer['buyer_id'] ) && isset( $buyer['status'] ) &&
                ( $buyer['status'] === 'ACTIVE' || $buyer['status'] === 'UNDER_REVIEW' )
            ) {
				if ( is_user_logged_in() ) {
					$current_user_id = get_current_user_id();
					update_user_meta( $current_user_id, 'merchant_buyer_id', $merchant_buyer_id );
					update_user_meta( $current_user_id, 'buyer_id', $buyer['buyer_id'] );
				}

				// Save Buyer ID to Session
				$_SESSION['merchant_buyer_id'] = $merchant_buyer_id;
				$_SESSION['buyer_id']          = sanitize_text_field($buyer['buyer_id']);

				$otp_validated = 'false';
				if(isset($buyer['buyer_users'])) {
					foreach($buyer['buyer_users'] as $user) {
						if($user['email'] == $email && $user['email_otp_validated'] == true) {
							$otp_validated = 'true';
						}
					}
				}

				wp_send_json( [
					'status'        => 'true',
					'otp_validated' => $otp_validated,
					'result'        => $buyer
				] );
			} elseif ( isset( $buyer['error_code'] ) ) {
				$message = '';
				if ( $buyer['error_code'] == 'duplicate-business' ) {
					$message = __( 'Registration number is already used', 'sprinque' );
				} elseif ( isset( $buyer['errors'] ) ) {
					$message = [];
					foreach ( $buyer['errors'] as $name => $error ) {
						if ( $name != 'buyer_users' ) {
							foreach ( $error as $text ) {
								$message[] = $text;
							}
						}
					}
					$message = implode( ', ', $message );
				}

				wp_send_json( [
					'status'   => 'false',
					'message'  => $message,
					'response' => $buyer
				] );
			} else if (
                isset( $buyer['status'] ) &&
                $buyer['status'] === 'BLOCKED' ||
                $buyer['status'] === 'REJECTED' ||
                $buyer['status'] === 'INACTIVE'
            ) {
                // See the error classes /templates/frontend/srinque_pay_modal_form.php:109
                $error = [
                    'REJECTED' => 'AuthCreditRejectedError',
                    'BLOCKED' => 'AuthBuyerBlockedError',
                    'INACTIVE' => 'AuthBuyerInactiveError',
                ];

                wp_send_json( [
                    'status'   => 'false',
                    'message'  => $error[$buyer['status']],
                    'response' => $buyer
                ], 403 );
            }
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

		/**
		 * Authorize order from Company on Sprinque
		 */
		public function sprinque_authorize_company_order() {
			if ( ! session_id() ) {
				session_start();
			}
			// Create ID for future created order
			$_SESSION['order_id'] = time().$this->id;

			// Get Buyer ID from Logged user
			$buyer_id = 0;
			if ( is_user_logged_in() ) {
				$buyer_id = get_user_meta( get_current_user_id(), 'buyer_id', true );
			} elseif ( isset( $_SESSION['buyer_id'] ) ) {
				$buyer_id = sanitize_text_field($_SESSION['buyer_id']);
			}

            $buyer = $this->srinque_api( [], 'GET', "/buyers/{$buyer_id}" );

			// Get the user's IP address
			$ip = $this->get_ip_address();

            // Prepare Data to Send
			$email = sanitize_text_field($_POST['email']);
			$email = strtolower($email);

            $metadata = $_POST['metadata'] ?? [];

			$data = [
				'merchant_order_id' => sanitize_text_field($_SESSION['order_id']),
				'order_amount'      => WC()->cart->total,
                'order_currency'    => get_woocommerce_currency(),
				'shipping_address'  => [
					'address_line1' => sanitize_text_field( $_POST['address_line1'] ),
					'city'          => sanitize_text_field( $_POST['city'] ),
					'zip_code'      => sanitize_text_field( $_POST['zip_code'] ),
					'country_code'  => sanitize_text_field( $_POST['country_code'] )
				],
				'issued_by' => $email,
				'metadata' => [
					'IPv4' => !strpos($ip, ':') !== false ? $ip : '',
					'IPv6' => strpos($ip, ':') !== false ? $ip : '',
                    'business_name' => $buyer['business_name']
				]
			];

			if (isset($_POST['payment_terms']) && $_POST['payment_terms'] !== null) {
				$payment_term = sanitize_text_field($_POST['payment_terms']);
				$data['payment_terms'] = $payment_term;
                $payment_term_lower = strtolower($payment_term);

                $payment_terms = wp_cache_get('sprinque_available_payment_terms');
                if ( !$payment_terms ) {
                    $payment_terms = [];
                }
                $fee = $payment_terms[$payment_term_lower] ?? 0.0;

                if ($fee > 0.0) {
                    $fee /= 100.0;
                    $data['order_amount'] *= 1.0 + $fee;
					$data['order_amount'] = round($data['order_amount'], 2);
                }
			}

            $data['metadata'] = array_merge($metadata, $data['metadata']);

			// Get Data from API
			$result = $this->srinque_api( $data, 'POST', "/transactions/authorize/{$buyer_id}" );

			if ( isset( $result['error_code'] ) ) {
				// Collect errors
				$message = [];
				if ( isset( $result['errors'] ) ) {
					foreach ( $result['errors'] as $name => $error ) {
						if ( $name != 'buyer_users' ) {
							foreach ( $error as $text ) {
								$message[] = $text;
							}
						}
					}
					$message = implode( ', ', $message );
				}

				// Prepare Data to Create Order
				$_SESSION['review_order'] = sanitize_text_field($buyer_id);
                $_SESSION['metadata'] = $metadata;
				unset( $_SESSION['transaction_id'] );
				unset( $_SESSION['net_term'] );

				wp_send_json( [
					'status'  => 'false',
					'result'  => $result,
					'message' => $message
				] );
			} else {
				// Prepare Data to Create Order
				$_SESSION['transaction_id'] = sanitize_text_field($result['transaction_id']);
				$_SESSION['net_term'] = sanitize_text_field($result['payment_terms']);
				unset( $_SESSION['review_order'] );

				$buyer = $this->srinque_api( [], 'GET', "/buyers/{$buyer_id}" );
				$days = isset($buyer['credit_qualification']['payment_terms']) ? str_replace('NET', '', $buyer['credit_qualification']['payment_terms']) : 30;

				wp_send_json( [
					'status'  => 'true',
					'days'    => $days,
					'result'  => $result,
					'message' => sprintf(__("You have been approved for a payment term of %s days by Sprinque!", "sprinque"), $days)
				] );
			}
		}

		public function sprinque_get_buyer_details()
		{
			if ( ! session_id() ) {
				session_start();
			}

			// Get Buyer ID from Logged user
			$buyer_id = 0;
			if ( is_user_logged_in() ) {
				$buyer_id = get_user_meta( get_current_user_id(), 'buyer_id', true );
			} elseif ( isset( $_SESSION['buyer_id'] ) ) {
				$buyer_id = sanitize_text_field($_SESSION['buyer_id']);
			}

			$buyer = $this->srinque_api( [], 'GET', "/buyers/{$buyer_id}" );
			$days = isset($buyer['credit_qualification']['payment_terms']) ? str_replace('NET', '', $buyer['credit_qualification']['payment_terms']) : 30;
			$eligible_payment_terms = $buyer['credit_qualification']['eligible_payment_terms'];

			$credit_decision = $buyer['credit_qualification']['credit_decision'];
			$status = in_array($credit_decision, [ 'APPROVED' ]);

			wp_send_json( [
				'status'  => $status,
				'days'    => $days,
				'credit_decision' => $credit_decision ?? 'MANUAL_REVIEW',
				'eligible_payment_terms' => $eligible_payment_terms,
				'total'   => WC()->cart->get_total('float'),
				'message' => sprintf(__("You have been approved for a payment term of %s days by Sprinque!", "sprinque"), $days)
			] );
		}

		public function sprinque_mark_for_review_and_wait()
		{
			if ( ! session_id() ) {
				session_start();
			}
			// Create ID for future created order
			$_SESSION['order_id'] = time().$this->id;
            $metadata = $_POST['metadata'] ?? [];

			// Get Buyer ID from Logged user
			$buyer_id = 0;
			if ( is_user_logged_in() ) {
				$buyer_id = get_user_meta( get_current_user_id(), 'buyer_id', true );
			} elseif ( isset( $_SESSION['buyer_id'] ) ) {
				$buyer_id = sanitize_text_field($_SESSION['buyer_id']);
			}

			// Prepare Data to Create Order
			$_SESSION['review_order'] = sanitize_text_field($buyer_id);
            $_SESSION['metadata'] = $metadata;
			unset( $_SESSION['transaction_id'] );
			unset( $_SESSION['net_term'] );

			wp_send_json([
				'status' => true
			]);
		}

		/**
		 * Send OTP Verification code to Buyer
		 */
		public function sprinque_send_otp_verification() {
			if (! isset( $_POST['email'] ) ) {
				return false;
			}

			// Prepare Data to Send
			$email = sanitize_text_field($_POST['email']);
			$email = strtolower($email);

			$data = [
				'email'             => $email,
				'merchant_buyer_id' => sanitize_text_field( $_POST['merchant_buyer_id'] )
			];

			// Get Data from API
			$result = $this->srinque_api( $data, 'POST', "/business/buyer/email/otp" );

			wp_send_json( [
				'status' => 'true',
				'result' => $result
			] );
		}

		/**
		 * Get Buyer info
		 */
		public function sprinque_get_buyer_info() {
			if ( ! session_id() ) {
				session_start();
			}
			$buyer_id = 0;
			if ( is_user_logged_in() ) {
				$buyer_id = get_user_meta( get_current_user_id(), 'buyer_id', true );
			} elseif ( isset( $_SESSION['buyer_id'] ) ) {
				$buyer_id = sanitize_text_field($_SESSION['buyer_id']);
			}

			// Get Data from API
			$result = $this->srinque_api( [], 'GET', "/buyers/{$buyer_id}" );

			if ( isset( $result['error_code'] ) ) {
				$message = '';
				if ( $result['errors']['SprinqueError'] == 'Failed to get buyer details' ) {
					$my_account_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
					$message        = __( "Not found Buyer ID. Please <a class='login-buyer-url' href='{$my_account_url}'>Log In</a>, or <span class='register-company-tab'>Register New Buyer</span>", 'sprinque' );
				}
				wp_send_json( [
					'status'   => 'false',
					'message'  => $message,
					'response' => $result
				] );
			} else {
				wp_send_json( [
					'status' => 'true',
					'result' => $result
				] );
			}
		}

		/**
		 * Verify OTP Code
		 */
		public function sprinque_verify_otp_code() {
			if (! isset( $_POST['send_code'] ) || ! isset( $_POST['merchant_buyer_id'] ) ) {
				return false;
			}

			// Prepare Data to Send
			$email = sanitize_text_field($_POST['email']);
			$email = strtolower($email);

			$data = [
				'email'             => $email,
				'merchant_buyer_id' => sanitize_text_field( $_POST['merchant_buyer_id'] ),
				'otp'               => sanitize_text_field( $_POST['send_code'] )
			];

			// Get Data from API
			$result = $this->srinque_api( $data, 'POST', "/business/buyer/email/otp/verify" );

			wp_send_json( [
				'status' => $result['email_otp_validated'] == true ? 'true' : 'false',
			] );
		}

		public function sprinque_get_countries_api()
		{
			// Get Countries from API
			$result = $this->srinque_api( [], 'GET', "/countries/" );

			wp_send_json($result);
		}

		public function sprinque_get_available_countries()
		{
            $countries = get_option('sprinque_available_countries', false);
            if (!$countries) {
                do_action('sprinque_update_cache');
                $countries = get_option('sprinque_available_countries', []);
            }

            return $countries;
		}

		/**
		 * Send request to API
		 */
		public function srinque_api( $data, $method, $route ) {
			if ( $this->testmode ) {
				$api_url = 'https://api-sandbox.sprinque.com/api/v1';
			} else {
				$api_url = 'https://api.sprinque.com/api/v1';
			}

			$args = [
				'method'  => $method,
				"timeout" => 100,
				'headers' => [
					"Content-type" => "application/json",
					"Accept"       => "application/json",
					"X-API-KEY-ID" => $this->api_key
				]
			];

			if($method == 'POST') {
				$args['body'] = json_encode( $data );
			}

			$response = wp_remote_post( $api_url . $route,  $args);
			$this->last_api_response = $response;

			return json_decode( $response['body'], true );
		}

		/**
		 * @return int|null
		 */
		public function get_last_api_response_code()
		{
			if ($this->last_api_response === null) {
				return null;
			}

			if (
				array_key_exists('response', $this->last_api_response)
				&& array_key_exists('code', $this->last_api_response['response'])
			) {
				return $this->last_api_response['response']['code'];
			}

			return null;
		}

		/**
		 * Initialize Gateway Settings Form Fields
		 */
		public function init_form_fields() {
			$this->form_fields = apply_filters( 'wpm_srinque_pay_form_fields', array(
				'enabled'      => array(
					'title'   => __( 'Enable/Disable', 'sprinque' ),
					'type'    => 'checkbox',
					'label'   => __( 'Enable Pay by Invoice', 'sprinque' ),
					'default' => 'yes'
				),
				'testmode'     => array(
					'title'       => 'Test mode',
					'label'       => 'Enable Test Mode',
					'type'        => 'checkbox',
					'description' => 'Place the payment gateway in test mode using test API keys.',
					'default'     => 'yes',
					'desc_tip'    => true,
				),
				'api_key'      => array(
					'title'       => 'API Key',
					'type'        => 'text',
					'description' => 'Find it in your Profile at the Sprinque. Overview > My Account > API Keys and URLs',
					'default'     => '',
					'desc_tip'    => true,
				),
				'title'     => array(
					'title'       => 'Title',
					'type'        => 'text',
					'description' => 'Payment method description that the customer will see on your checkout.',
					'default'     => 'Pay Sprinque',
					'desc_tip'    => true,
				),
				'description'     => array(
					'title'       => 'Description',
					'type'        => 'text',
					'description' => 'Payment method description that the customer will see on your checkout under payment method name.',
					'default'     => '',
					'desc_tip'    => true,
				),
				'pay_in_x_days'      => array(
					'title'       => 'Pay in X days',
					'type'        => 'text',
					'description' => 'Net terms for "What is Sprinque" modal in the checkout page',
					'default'     => '7-90',
					'desc_tip'    => true,
				),
                'logo'            => array(
                    'type'        => 'radio',
                    'title'       => 'Logo variant',
                    'options'     => array(
                        'light'  => "Light",
                        'dark'   => "Dark",
                    ),
                    'default'     => 'light',
                    'required'    => true,
                )
			) );
		}

		/**
		 * Process the payment and return the result
		 */
		public function process_payment( $order_id ) {
			if ( ! session_id() ) {
				session_start();
			}
			$order = wc_get_order( $order_id );

			if ( isset( $_SESSION['net_term'] ) ) {
				$order->update_meta_data( 'net_term', sanitize_text_field( $_SESSION['net_term'] ) );
			}

			if ( isset( $_SESSION['surcharge_fee'] ) ) {
				$order->update_meta_data( 'buyer_fee_percentage', sanitize_text_field( $_SESSION['surcharge_fee'] ) );
			}

			// Set Correct Status and Update Order Meta
			if ( isset( $_SESSION['review_order'] ) ) {
				$order->update_meta_data( 'review_order', sanitize_text_field( $_SESSION['review_order'] ) );
				// Save the user's IP address
				$order->update_meta_data( 'ip_address', $this->get_ip_address() );
                $order->update_meta_data( 'fingerprint', base64_encode(json_encode($_SESSION['metadata'])) );

				$order->update_status( 'awaiting-review', __( 'Pay by Invoice - Business only', 'sprinque' ) );
			} elseif ( isset( $_SESSION['transaction_id'] ) ) {
				$order->update_meta_data( 'transaction_id', sanitize_text_field( $_SESSION['transaction_id'] ) );
				$order->update_meta_data( 'merchant_order_id', sanitize_text_field( $_SESSION['order_id'] ) );

				$order->update_status( 'processing', __( 'Pay by Invoice - Business only', 'sprinque' ) );
			}

			$order->save();


			unset($_SESSION['net_term']);
			unset($_SESSION['surcharge_fee']);

			// Reduce stock levels
			$order->reduce_order_stock();

			// Remove cart
			WC()->cart->empty_cart();

			// Return thankyou redirect
			return array(
				'result'   => 'success',
				'redirect' => $this->get_return_url( $order )
			);
		}

		/**
		* Find and return the current user's IP address
		*
		* @return string
		*/
		public function get_ip_address()
		{
			if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
				// check ip from share internet
				$ip = sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
			} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
				// to check ip is pass from proxy
				$ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
			} else {
				$ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
			}

			if (strpos($ip, ',') !== false) {
				$ip = explode(',', $ip);
				$ip = array_shift($ip);
			}

			return $ip;
		}

		public function get_current_language()
		{
			$locale = get_locale();
			$locale = str_replace('-', '_', $locale);

			if (strpos($locale, '_BE') === false) {
				return null;
			}

			switch ($locale) {
				case 'nl_BE': return 'nl';
				case 'fr_BE': return 'fr';
				default: return 'nl';
			}
		}

		/**
		 * Validate email address.
		 *
		 * @return bool
		 */
		public function validate_fields() 
		{
			if ( strpos( $_POST['billing_email'], '@t-online.de' ) !== false ) {
				wc_add_notice( 'blocked-t-online', 'error' );
				return false;
			}else if ( strpos( $_POST['billing_email'], '@gmail.com' ) !== false ) {
				wc_add_notice( 'business-email-verification', 'notice' );
				return false;
			}
			return true;
		}

        public function generate_radio_html( $key, $data )
        {
            $field_key = $this->get_field_key( $key );
            $defaults  = array(
                'title'             => '',
                'disabled'          => false,
                'class'             => '',
                'css'               => '',
                'placeholder'       => '',
                'type'              => 'text',
                'desc_tip'          => false,
                'description'       => '',
                'custom_attributes' => array(),
                'options'           => array(),
            );

            $data = wp_parse_args( $data, $defaults );
            $value = $this->get_option( $key );

            ob_start();
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?> <?php echo $this->get_tooltip_html( $data ); // WPCS: XSS ok. ?></label>
                </th>
                <td class="forminp">
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php echo wp_kses_post( $data['title'] ); ?></span></legend>
                        <?php foreach ( (array) $data['options'] as $option_key => $option_value ) : ?>
                        <div>
                            <label for="<?php echo esc_attr( $field_key ); ?>-<?php echo esc_attr( $option_key ); ?>">
                                <input type="radio" name="<?php echo esc_attr( $field_key ); ?>" value="<?php echo esc_attr( $option_key ); ?>" <?php if ($value === $option_key) echo 'checked="checked"'; ?> id="<?php echo esc_attr( $field_key ); ?>-<?php echo esc_attr( $option_key ); ?>" />
                                <span><?php echo esc_html( $option_value ); ?></span>
                            </label>
                        </div>
                        <?php endforeach; ?>
                        <?php echo $this->get_description_html( $data ); // WPCS: XSS ok. ?>
                    </fieldset>
                </td>
            </tr>
            <?php

            return ob_get_clean();
        }

	}
}
