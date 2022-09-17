<?php
/**
 * Form template.
 *
 * @package Woodmart
 *
 * @var array $layout_types Layout types.
 * @var Admin $admin        Admin instance.
 */

use XTS\Modules\Layouts\Admin;

$layout_default_name = 'New layout';
$current_tab         = isset( $_GET['wd_layout_type_tab'] ) ? $_GET['wd_layout_type_tab'] : 'all';  // phpcs:ignore

if ( 'single_product' === $current_tab ) {
	$layout_default_name = 'Single product layout';
} elseif ( 'shop_archive' === $current_tab ) {
	$layout_default_name = 'Product archive layout';
} elseif ( 'cart' === $current_tab ) {
	$layout_default_name = 'Cart layout';
} elseif ( 'checkout' === $current_tab ) {
	$layout_default_name = 'Checkout layout';
}

if ( 'checkout' === $current_tab ) {
	unset( $layout_types['cart'] );
	unset( $layout_types['shop_archive'] );
	unset( $layout_types['single_product'] );
}

$wrapper_classes = ' xts-layout-type-' . $current_tab;
?>
<form>
	<div class="xts-layout-fields<?php echo esc_attr( $wrapper_classes ); ?>">
		<div class="xts-layout-field xts-layout-type-select">
			<div>
				<label for="wd_layout_type">
					<?php esc_html_e( 'Layout type', 'woodmart' ); ?>
				</label>
			</div>
			<select class="xts-layout-type" id="wd_layout_type" name="wd_layout_type" required>
				<option value="">
					<?php esc_html_e( 'Select...', 'woodmart' ); ?>
				</option>
				<?php foreach ( $layout_types as $key => $label ) : ?>
					<?php
					$current_tab = isset( $_GET['wd_layout_type_tab'] ) ? $_GET['wd_layout_type_tab'] : ''; // phpcs:ignore

					if ( 'checkout' === $current_tab ) {
						$current_tab = 'checkout_form';
					}
					?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $current_tab, $key ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="xts-layout-field">
			<div>
				<label for="wd_layout_name">
					<?php esc_html_e( 'Layout name', 'woodmart' ); ?>
				</label>
			</div>
			<input class="xts-layout-name" id="wd_layout_name" name="wd_layout_name" type="text" placeholder="<?php esc_html_e( 'Enter layout name', 'woodmart' ); ?>" required value="<?php echo esc_attr( $layout_default_name ); ?>">
		</div>
	</div>

	<div class="xts-layout-conditions">
		<h4 class="xts-layout-conditions-title">
            <?php esc_html_e( 'Conditions', 'woodmart' ); ?>
		</h4>

		<a href="javascript:void(0);" class="xts-layout-condition-add xts-hidden xts-inline-btn xts-color-primary dashicons-plus-alt">
			<?php esc_html_e( 'Add condition', 'woodmart' ); ?>
		</a>
	</div>

	<?php $admin->get_predefined_layouts(); ?>
	<div class="xts-popup-actions xts-layout-submit-wrap">
		<button class="xts-disabled xts-layout-submit xts-btn xts-color-primary" type="submit">
			<?php esc_html_e( 'Create layout', 'woodmart' ); ?>
		</button>
	</div>
</form>
