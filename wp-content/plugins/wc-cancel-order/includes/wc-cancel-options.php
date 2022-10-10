<?php
defined( 'ABSPATH' ) || exit;
$settings = WC_Cancel_Order_Init()->get_settings();
$statuses = WC_Cancel_Order_Init()->wc_cancel_get_order_statuses();
?>
<div class="wc-cancel-pro-main">
    <a class="rate-link" target="_blank" href="https://wordpress.org/support/plugin/wc-cancel-order/reviews/#new-post">Rate Wc Cancel Order</a>
    <a class="pro-link" target="_blank" href="https://wpexpertshub.com/plugins/wc-cancel-order-pro/">Get Pro Version</a>
    <div class="wc-cancel-pro-in">
        <div class="wcc-pro-row">
            <label><?php echo __('Request cancellation','wc-cancel-order'); ?></label>
            <div class="wc-cancel-input">
                <select name="wc-cancel[req-status][]" class="wc-enhanced-select wc-cancel-req-status-select" multiple="multiple">
		            <?php
		            if(is_array($statuses) && !empty($statuses)){
			            foreach($statuses as $status_key=>$status_label){
				            $selected = isset($settings['req-status']) && is_array($settings['req-status']) && in_array($status_key,$settings['req-status']) ? 'selected' : '';
				            echo '<option value="'.$status_key.'" '.$selected.'>'.$status_label.'</option>';
			            }
		            }
		            ?>
                </select>
            </div>
            <p class="description"><?php echo __('Customers will be able to send only cancellation request with selected order status.','wc-cancel-order'); ?></p>
        </div>
        <div class="wcc-pro-row">
            <label><?php echo __('Cancellation reason','wc-cancel-order'); ?></label>
            <div class="wc-cancel-input">
                <input type="checkbox" name="wc-cancel[text-required]" value="1" <?php echo isset($settings['text-required']) && $settings['text-required']=='1' ? 'checked' : ''; ?>>
                <p class="description-in"><?php echo __('Make cancellation reason input required.','wc-cancel-order'); ?></p>
            </div>
        </div>
        <div class="wcc-pro-row">
            <label><?php echo __('Customer note','wc-cancel-order'); ?></label>
            <div class="wc-cancel-input">
                <textarea name="wc-cancel[confirm-note]"><?php echo isset($settings['confirm-note']) ? $settings['confirm-note'] : ''; ?></textarea>
            </div>
            <p class="description"><?php echo __('Customer note will appear in cancellation request popup (HTML Tags allowed).','wc-cancel-order'); ?></p>
        </div>
        <div class="wcc-pro-row">
            <label><?php echo __('Allow guest cancellation','wc-cancel-order'); ?></label>
            <div class="wc-cancel-input">
                <input type="checkbox" name="wc-cancel[guest-cancel]" value="1" <?php echo isset($settings['guest-cancel']) && $settings['guest-cancel']=='1' ? 'checked' : ''; ?>>
                <p class="description-in"><?php echo __('Guest users will be able to cancel their order using the link sent in their order email.','wc-cancel-order'); ?></p>
            </div>
        </div>
    </div>
</div>