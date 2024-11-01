<?php if (empty($companies_details)) : ?>
    <div class="company-not-found-placeholder" id="register-company-tab">
        <div class="placeholder-title"><?php _e("No results, add business manually", 'sprinque'); ?></div>
        <div class="placeholder-text">
            <?php _e("We couldn't locate your business in public records, but you can manually register your business.", 'sprinque'); ?>
        </div>
    </div>
<?php else : ?>

    <!-- Setting class="notranslate" prevents Google translation -->
    <div class="founded-companies notranslate">
        <div class="company-item-404 company-not-found-placeholder" id="register-company-tab-2">
            <div class="placeholder-title"><?php _e("Select your business", 'sprinque'); ?></div>
            <div class="placeholder-text">
                <?php _e("If your business isn't listed in this dropdown, you can manually input your business details and proceed.", 'sprinque'); ?>
            </div>
        </div>
        <?php foreach ($companies_details as $business) : ?>
            <div class="company-item" data-company-name="<?php echo esc_html($business['business_name']); ?>" data-reg-number="<?php echo esc_html($business['registration_number']); ?>" data-credit-bureau-id="<?php echo esc_html($business['credit_bureau_id']); ?>">
                <div class="business-name"><?php echo esc_html($business['business_name']); ?></div>
                <div class="business-reg-number"><?php echo esc_html($business['registration_number']); ?></div>
                <div class="business-address">
                    <span id="sprinque_address_line1"><?php if (isset($business['address']['address_line_1']) && !empty($business['address']['address_line_1'])) : ?><?php echo esc_html("{$business['address']['address_line_1']}") ?>,<?php endif; ?></span>
                    <span id="sprinque_zip_code"><?php if (isset($business['address']['zipcode']) && !empty($business['address']['zipcode'])) : ?><?php echo esc_html($business['address']['zipcode']); ?><?php endif; ?></span>
                    <span id="sprinque_city"><?php if (isset($business['address']['city']) && !empty($business['address']['city'])) : ?><?php echo esc_html($business['address']['city']); ?>,<?php endif; ?></span>
                    <span id="sprinque_country"><?php if (isset($business['address']['country']) && !empty($business['address']['country'])) : ?><?php echo esc_html($business['address']['country']); ?><?php endif; ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>