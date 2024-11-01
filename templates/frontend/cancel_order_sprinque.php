<button class="woocommerce-button" id="cancel-order-sprinque" data-order-id="<?php echo esc_attr($order->get_id()); ?>"><?php _e( "Cancel Order", 'sprinque' ); ?></button>

<div class="modal-form" id="wpm-modal-form">
	<div class="modal-form__overlay" data-wpm-close="#wpm-modal-form"></div>
	<div class="modal-form-inner">
		<a href="#" data-wpm-close="#wpm-modal-form" class="modal-form-inner__close"></a>
		<div class="wpm-modal-form-tabs">
			<div class="wpm-modal-form-tab wpm-modal-form-tab_active" id="select-your-business">

				<div class="confirm_cancelation">
					<div class="wpm-modal-form-tab__title"><?php _e( "Confirm cancelation", 'sprinque' ); ?></div>
					<div class="wpm-buttons-row wpm-buttons-row_mt">
						<div class="wpm-button-col">
							<button type="button" class="wpm-btn wpm-btn_block wpm-btn_primary" id="cancel_order"><?php _e( "Cancel order", 'sprinque' ); ?></button>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>