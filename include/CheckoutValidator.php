<?php

class CheckoutValidator extends WC_Checkout
{

    public function test()
    {
        $data = $this->get_posted_data();
        $errors = new WP_Error();
        $this->validate_checkout($data, $errors);

        /**
         * @see \WooCommerce\PayPalCommerce\Button\Validation\CheckoutFormValidator
         */
        $messages = array_merge(
            $errors->get_error_messages(),
            array_map(
                function ( array $notice ): string {
                    return $notice['notice'];
                },
                wc_get_notices( 'error' )
            )
        );

        if ( wc_notice_count( 'error' ) > 0 ) {
            wc_clear_notices();
        }

        if ($messages) {
            $exception = new ValidationException("Checkout validation failed");
            $exception->setMessages($messages);
            throw $exception;
        }
    }

}