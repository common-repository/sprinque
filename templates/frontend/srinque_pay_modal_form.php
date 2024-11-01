<div id="wpm-modal-form-wrapper">
    <div class="modal-form" id="wpm-modal-form">
        <div class="modal-form__overlay" data-wpm-close="#wpm-modal-form"></div>
        <div class="modal-form-inner">
            <a href="#" data-wpm-close="#wpm-modal-form" class="modal-form-inner__close"></a>
            <div class="wpm-modal-form-tabs">
                <div class="wpm-modal-form-tab wpm-modal-form-tab_active" id="select-your-business">
                    <div class="search_already_added_company">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Please select your business", 'sprinque' ); ?></div>

                        <p class="wpm-modal-form-tab__dsc">
                            <?php _e( 'To approve a payment term for you we need your company information to run a credit assessment', 'sprinque' ); ?>
                        </p>

                        <div class="field-group">
                            <label><?php _e( "Country", 'sprinque' ); ?>*</label><select id="select_country_pay" data-wpm-placeholder="<?php _e( "Select a country", 'sprinque' ); ?>">
                                <?php
                                foreach($countries as $code => $country) { ?>
                                    <option value="<?php echo esc_attr($code); ?>" <?php if(isset($user_country) && $user_country == $code) { echo esc_attr('selected'); }?>><?php echo esc_attr($country); ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <div class="field-group">
                            <label id="company-name-label"><?php _e( "Company Name", 'sprinque' ); ?>*</label>
                            <div class="search-company-by" id="search-by">
                                <label><input type="radio" name="search_by" value="name" data-placeholder="<?php _e( "Company Name", 'sprinque' ); ?>" checked /><span class="input-placeholder"></span> <?php _e('Company Name', 'sprinque') ?></label>
                                <label><input type="radio" name="search_by" value="vat" data-placeholder="<?php _e( "Company VAT ID", 'sprinque' ) ?>" /><span class="input-placeholder"></span><?php _e('VAT ID', 'sprinque') ?></label>
                            </div>
                            <input type="text" id="company_name_pay" placeholder="<?php _e( "Company Name", 'sprinque' ); ?>" value="<?php if(isset($user_company)) { echo esc_attr($user_company); } ?>">
                        </div>
                        <div class="search-company-result"></div>
                        <div class="error-confirm-order" style="display: none;"><?php _e( "Not all required fields are filled", 'sprinque' ); ?></div>
                        <div class="field-group">
                            <label><?php _e( "Registration number", 'sprinque' ); ?><span class="registration-number-required">*</span></label><input type="text" id="reg_number_pay" placeholder="<?php _e( "Registration number", 'sprinque' ); ?>"><div class="field-warning" id="reg_number_warning">Some text here</div>
                        </div>
                        <div class="field-group"><label><?php _e( "Billing or Accounts Payable email", 'sprinque' ); ?></label><input type="text" id="billing_or_accounts_payable_email" /></div>

                        <p class="policy-description"></p>

                        <label class="checkbox" for="sprinque_agree_policy">
                            <input type="checkbox" id="sprinque_agree_policy" />
                            <span class="placeholder"></span>
                            <span class="label policy-checkbox-label">I have read and agreed to Sprinque B.V.‘s privacy statement.</span>
                        </label>

                        <button class="wpm-btn wpm-btn_primary wpm-btn_mt wpm-btn_block" type="button" id="confirm-company-order" disabled><?php _e( "Confirm", 'sprinque' ); ?></button>
                    </div>

                    <div class="register_new_business" style="display: none">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Business address", 'sprinque' ); ?></div>
                        <div class="field-group">
                            <label><?php _e( "Address", 'sprinque' ); ?>*</label>
                            <input type="text" id="address_company_pay" class="required-input" value="<?php if(isset($billing_address_1)) { echo esc_attr($billing_address_1); } ?>">
                        </div>
                        <div class="field-group">
                            <label><?php _e( "Apartment, suite, etc (optional)", 'sprinque' ); ?></label>
                            <input type="text" id="apartment_company_pay" value="<?php if(isset($billing_address_2)) { echo esc_attr($billing_address_2); } ?>">
                        </div>
                        <div class="field-group">
                            <label><?php _e( "City", 'sprinque' ); ?>*</label>
                            <input type="text" id="city_company_pay" class="required-input" value="<?php if(isset($billing_city)) { echo esc_attr($billing_city); } ?>">
                        </div>
                        <div class="field-group">
                            <label><?php _e( "Postal code", 'sprinque' ); ?>*</label>
                            <input type="text" id="zip_company_pay" class="required-input" value="<?php if(isset($billing_postcode)) { echo esc_attr($billing_postcode); } ?>">
                        </div>
                        <div class="error-register-fields" style="display: none">
                            <?php
                            // Here we're showing error
                            if (!isset($billing_address_1, $billing_address_2, $billing_city, $billing_postcode)) {
                                _e( "Not all fields filled on Billing or Modal", 'sprinque' );
                            }
                            ?>
                        </div>
                        <div class="pagination-btns">
                            <button type="button" class="wpm-btn wpm-btn_outline-primary white_btn_pay to_select_companies"><?php _e( "Previous step", 'sprinque' ); ?></button>
                            <button type="button" class="wpm-btn wpm-btn_primary blue_btn_pay" disabled id="register_buyer_company"><?php _e( "Confirm", 'sprinque' ); ?></button>
                        </div>
                    </div>

                    <div class="verify_your_email" style="display: none;">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Verify your email", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__dsc">
                            <?php _e( "To make sure it's really you we have sent a code to", 'sprinque' ); ?> <span id="email-otp-send"></span>
                        </div>
                        <div id="wpm-otp" class="wpm-confirm-code-wrap">
                            <input type="text" onkeyup="jmp(this);" id="confirm-code-1" maxlength="1" size="1">
                            <input type="text" onkeyup="jmp(this);" id="confirm-code-2" maxlength="1" size="1">
                            <input type="text" onkeyup="jmp(this);" id="confirm-code-3" maxlength="1" size="1">
                            <input type="text" onkeyup="jmp(this);" id="confirm-code-4" maxlength="1" size="1">
                            <input type="text" onkeyup="jmp(this);" id="confirm-code-5" maxlength="1" size="1">

                        </div>

                        <div class="pagination-btns-wrap">
                            <button type="button" class="wpm-btn wpm-btn_outline-primary white_btn_pay to_select_companies"><?php _e( "Prev", 'sprinque' ); ?></button>
                            <button class="wpm-btn wpm-btn_primary wpm-btn_mt wpm-btn_mb wpm-btn_block" type="button" id="confirm-email-code" disabled><?php _e( "Next", 'sprinque' ); ?></button>
                        </div>
                        <div class="otp-error-code" style="display: none;"><?php _e( "Wrong code number", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__dsc">
                            <?php _e( "If you have not received the code, please check your spam folder or", 'sprinque' ); ?> <a href="#" id="resend-code-otp" class="wpm-modal-form-tab__resend"><?php _e( "Resend Code", 'sprinque' ); ?> <span id="resend-timer-otp" class="wpm-modal-form-tab__resend-notice"><?php _e( "(in :sec seconds)", 'sprinque' ); ?></span></a>
                        </div>
                    </div>
                    <div class="verifying_your_account" style="display: none;">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img class="modal-form__logo-image" src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                            <img class="modal-form__error-icon" src="<?php echo PLUGIN_SRINQUE_PATH . '/assets/img/modal_error_icon.svg' ?>" alt="Error" style="display: none; height: 64px; width: 64px;">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title verify-error-title"><?php _e( "We are verifying your account", 'sprinque' ); ?></div>
                        <div class="wpm-loader wpm-loader_my1"></div>
                        <div class="cant-complete-autorization" style="display: none;">
                            <div class="verify-error"></div>
                            <div class="pagination-btns" style="display: none;">
                                <button type="button" class="wpm-btn wpm-btn_outline-primary white_btn_pay to_select_companies"><?php _e( "Go Back", 'sprinque' ); ?></button>
                                <a class="wpm-btn wpm-btn_outline-primary white_btn_pay choose_another_payment_method" data-wpm-close="#wpm-modal-form"><?php _e( "Choose another payment method", 'sprinque' ); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="select_payment_term" style="display: none;">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Congratulations!", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__dsc wpm-modal-form-tab__dsc_terms" style="display: none;">
                            <?php _e( "You've been approved to pay with net terms. Select the payment term that best suits your company", 'sprinque' ); ?>
                        </div>
                        <div class="wpm-modal-form-tab__dsc wpm-modal-form-tab__dsc_terms_and_instalments" style="display: none;">
                            <?php _e( "You have been approved to pay with net terms or instalments. Choose the option that best suits your business", 'sprinque' ); ?>
                        </div>
                        <div class="wpm-modal-form-tab__terms" id="wpm-terms">
                            <div class="wpm-modal-form-tab__subtitle"><?php _e( "Net terms", 'sprinque' ); ?></div>
                            <div class="wpm-modal-form-tab__description"><?php _e( "Pay the total order amount anytime within the due date.", 'sprinque' ); ?></div>
                                
                        </div>
                        <div class="wpm-modal-form-tab__instalments" id="wpm-terms-and-instalments" style="display: none;">
                            <div class="wpm-modal-form-tab__instalment">
                                <div class="wpm-modal-form-tab__subtitle"><?php _e( "Instalments", 'sprinque' ); ?></div>
                                <div class="wpm-modal-form-tab__description"><?php _e( "Pay in 3 equal instalments, after 30, 60, and 90 days. Exact due dates will be determined upon receipt of your order.", 'sprinque' ); ?></div>
                                <div class="wpm-instalments-options">
                                </div>
                            </div>
                        </div>
                        <div class="wpm-terms-row total">
                            <div class="label"><?php _e("Total amount", 'sprinque'); ?></div>
                            <div class="value"><?= get_woocommerce_currency_symbol(); ?>00.00</div>
                        </div>
                        <button class="wpm-btn wpm-btn_primary wpm-btn_mt wpm-btn_block confirm-order-term" disabled><?php _e( "Confirm order", 'sprinque' ); ?></button>
                    </div>

                    <div class="purchase_approved" style="display: none;">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Purchase approved", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__dsc">
                            <div>
                                <?php _e( "Your account has been created and you’ve been approved for a payment term of", 'sprinque' ); ?>
                            </div>
                            <div class="approved-days">
                                <span id="days-review"></span> <?php _e( "days", 'sprinque' ); ?>
                            </div>
                        </div>
                        <a class="wpm-btn wpm-btn_primary wpm-btn_mt-2 wpm-btn_block approve-place-order"><?php _e( "Confirm order", 'sprinque' ); ?></a>
                    </div>

                    <div class="purchase_under_review" style="display: none;">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Purchase under review", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__dsc"><?php _e( "This may take upto 24 hours for approval. Your Order is not confirmed until a decision is made. <br>We will notify you by email once the review is complete.", 'sprinque' ); ?></div>
                        <a class="wpm-btn wpm-btn_primary wpm-btn_mt-2 wpm-btn_mb wpm-btn_block continue-with-review"><?php _e( "Continue and wait", 'sprinque' ); ?></a><a class="wpm-btn wpm-btn_outline-primary wpm-btn_mt wpm-btn_block choose_another_payment_method" data-wpm-close="#wpm-modal-form"><?php _e( "Choose another payment method", 'sprinque' ); ?></a>
                    </div>

                    <div class="placing_your_order" style="display: none;">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Placing your order", 'sprinque' ); ?></div>
                        <div class="wpm-loader wpm-loader_my1"></div>
                    </div>

                    <div class="sprinque_email_validation_error" style="display: none;">
                        <div class="wpm-modal-form-tab__error"></div>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Required: business email for payment terms verification", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__dsc"><?php _e( "We've detected that you've provided a \"t-online.de\" email. Unfortunately, Sprinque's verification emails are blocked by t-online, preventing us from verifying your Business. We kindly suggest switching to a business email and reinitiating the process.", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__powered"><?php _e( "Powered by", 'sprinque' ); ?><img src="<?php echo PLUGIN_SRINQUE_PATH; ?>/assets/img/logo.svg" alt="sprinque logo"></div>
                    </div>
                    <div class="sprinque_email_validation_notice" style="display: none;">
                        <div class="wpm-modal-form-tab__notice"></div>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Consider business email for quicker verification", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__dsc"><?php _e( "We've detected that you've entered a personal email address. As these accounts usually require manual verification taking approximately <b>1 business day</b>, we recommend switching to a business email for a quicker process.", 'sprinque' ); ?></div>
                        <a class="wpm-btn wpm-btn_outline-primary wpm-btn_mt wpm-btn_block choose_another_payment_method" data-wpm-proceed=".search_already_added_company"><?php _e( "Proceed with current email", 'sprinque' ); ?></a>
                        <div class="wpm-modal-form-tab__powered"><?php _e( "Powered by", 'sprinque' ); ?><img src="<?php echo PLUGIN_SRINQUE_PATH; ?>/assets/img/logo.svg" alt="sprinque logo"></div>
                    </div>

                    <div class="finalizing-order" style="display: none;">
                        <?php if( isset( $seller_data[ 'logo' ] ) && ! empty( $seller_data[ 'logo' ] ) ): ?>
                        <div class="modal-form__logo">
                            <img src="<?php echo $seller_data[ 'logo' ] ?>" alt="<?php echo $seller_data[ 'trade_name' ] ?? ''; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="wpm-modal-form-tab__title"><?php _e( "Don't miss out on your purchase", 'sprinque' ); ?></div>
                        <div class="wpm-modal-form-tab__dsc"><?php _e('You\'re almost there! Please don\'t close or refresh the page, you will be automatically redirected to your order confirmation page. It will only take a moment, thanks for your patience!', 'sprinque'); ?></div>
                        <div class="wpm-loader wpm-loader_my1"></div>
                    </div>
                </div>
            </div>
            <div class="powered-by"><div><?php _e( 'Powered by' ,'sprinque' ); ?> <img class="sprinque-powered-img" src="https://d2f2ha363kdzm.cloudfront.net/sprinque-logo-dark-blue.png" alt="sprinque"></div><div>v.<?php echo PLUGIN_SRINQUE_VERSION; ?></div></div>
        </div>
    </div>
</div>

<script>
function jmp(e){
    var max = ~~e.getAttribute('maxlength');
    if(max && e.value.length >= max){
        do{
            e = e.nextSibling;
        }
        while(e && !(/text/.test(e.type)));
        if(e && /text/.test(e.type)){
            e.focus();
        }
    }
}
</script>
