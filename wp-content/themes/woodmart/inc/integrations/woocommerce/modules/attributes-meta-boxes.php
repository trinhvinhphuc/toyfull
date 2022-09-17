<?php
/**
 * Add meta boxes to attributes interface for woocommerce.
 *
 * @package Woodmart.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_wc_attribute_update' ) ) {
	/**
	 * This function save woocommerce attribute data after push 'update' button.
	 *
	 * @param mixed $attribute_id .
	 * @param mixed $attribute .
	 * @param mixed $old_attribute_name .
	 */
	function woodmart_wc_attribute_update( $attribute_id, $attribute, $old_attribute_name ) {
		$attribute_swatch_size = isset( $_POST['attribute_swatch_size'] ) ? $_POST['attribute_swatch_size'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_size', sanitize_text_field( $attribute_swatch_size ) );

		$attribute_show_on_product = isset( $_POST['attribute_show_on_product'] ) ? $_POST['attribute_show_on_product'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_show_on_product', sanitize_text_field( $attribute_show_on_product ) );

		$attribute_thumbnail = isset( $_POST['product_attr_thumbnail_id'] ) ? $_POST['product_attr_thumbnail_id'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_thumbnail', sanitize_text_field( $attribute_thumbnail ) );
	}

	add_action( 'woocommerce_attribute_updated', 'woodmart_wc_attribute_update', 20, 3 );
}

if ( ! function_exists( 'woodmart_wc_attribute_add' ) ) {
	/**
	 * This function save woocommerce attribute data after push 'Add attribute' button.
	 *
	 * @param mixed $attribute_id .
	 * @param mixed $attribute .
	 */
	function woodmart_wc_attribute_add( $attribute_id, $attribute ) {
		$attribute_swatch_size = isset( $_POST['attribute_swatch_size'] ) ? $_POST['attribute_swatch_size'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_size', sanitize_text_field( $attribute_swatch_size ) );

		$attribute_show_on_product = isset( $_POST['attribute_show_on_product'] ) ? $_POST['attribute_show_on_product'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_show_on_product', sanitize_text_field( $attribute_show_on_product ) );

		$attribute_thumbnail = isset( $_POST['product_attr_thumbnail_id'] ) ? $_POST['product_attr_thumbnail_id'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_thumbnail', sanitize_text_field( $attribute_thumbnail ) );
	}

	add_action( 'woocommerce_attribute_added', 'woodmart_wc_attribute_add', 20, 2 );
}

if ( ! function_exists( 'woodmart_wc_get_attribute_term' ) ) {

	/**
	 * Get attribute term.
	 *
	 * @param mixed $attribute_name .
	 * @param mixed $term .
	 * @return false|mixed|void
	 */
	function woodmart_wc_get_attribute_term( $attribute_name, $term ) {
		return get_option( 'woodmart_' . $attribute_name . '_' . $term );
	}
}

if ( ! function_exists( 'woodmart_render_product_attrs_admin_options' ) ) {
	/**
	 * Add product attribute labels options
	 *
	 * @since 1.0.0
	 */
	function woodmart_render_product_attrs_admin_options() {
		wp_enqueue_media();
		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );

		$swatch_size_list = array(
			'default' => esc_html__( 'Default', 'woodmart' ),
			'large'   => esc_html__( 'Large', 'woodmart' ),
			'xlarge'  => esc_html__( 'Extra large', 'woodmart' ),
		);
		$swatch_size      = 'default';
		$show_on_product  = '';
		$thumb_id         = '';

		if ( isset( $_GET['edit'] ) && ! empty( $_GET['edit'] ) ) { // phpcs:ignore
			$attribute_id   = sanitize_text_field( wp_unslash( $_GET['edit'] ) ); // phpcs:ignore
			$taxonomy_ids   = wc_get_attribute_taxonomy_ids();
			$attribute_name = 'pa_' . array_search( $attribute_id, $taxonomy_ids, false ); // phpcs:ignore

			$swatch_size     = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_size' );
			$show_on_product = woodmart_wc_get_attribute_term( $attribute_name, 'show_on_product' );
			$thumb_id        = woodmart_wc_get_attribute_term( $attribute_name, 'thumbnail' );
		}
		?>
		<div class="xts-options xts-metaboxes">
			<div class="xts-fields-tabs">
				<div class="xts-sections">
					<div class="xts-fields-section xts-active-section" data-id="general">
						<div class="xts-fields-wrapper">
							<div class="xts-field xts-settings-field">
								<div class="xts-option-title">
									<label>
										<span>
											<?php esc_html_e( 'Attributes swatch size', 'woodmart' ); ?>
										</span>
									</label>
									<p class="xts-field-description">
										<?php esc_html_e( 'If you will set color or images swatches for terms of this attribute.', 'woodmart' ); ?>
									</p>
								</div>
								<div class="xts-option-control">
									<div class="xts-upload-btns">
										<select name="attribute_swatch_size" id="attribute_swatch_size">
											<?php foreach ( $swatch_size_list as $value => $label ) : ?>
												<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $swatch_size ); ?>>
													<?php echo esc_html( $label ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="xts-field xts-settings-field">
								<div class="xts-option-title">
									<label>
										<span>
											<?php esc_html_e( 'Show attribute label on products', 'woodmart' ); ?>
										</span>
									</label>
									<p class="xts-field-description">
										<?php esc_html_e( 'Enable this if you want to show this attribute label on products in your store.', 'woodmart' ); ?>
									</p>
								</div>
								<div class="xts-option-control">
									<div class="xts-upload-btns">
										<input name="attribute_show_on_product" id="attribute_show_on_product" type="checkbox" <?php checked( $show_on_product, 'on' ); ?>>
									</div>
								</div>
							</div>
							<div class="xts-field xts-settings-field xts-upload-control">
								<div class="xts-option-title">
									<label>
										<span>
											<?php esc_html_e( 'Attribute image', 'woocommerce' ); ?>
										</span>
									</label>
									<p class="xts-field-description">
										<?php esc_html_e( 'Upload an image', 'woodmart' ); ?>
									</p>
								</div>
								<div class="xts-option-control">
									<div class="xts-upload-preview">
										<?php if ( ! empty( $thumb_id ) ) : ?>
											<img src="<?php echo esc_attr( wp_get_attachment_image_url( $thumb_id ) ); ?>" alt="">
										<?php endif; ?>
									</div>
									<div class="xts-upload-btns">
										<button class="xts-btn xts-upload-btn">
											<?php esc_html_e( 'Upload', 'woodmart' ); ?>
										</button>
										<button class="xts-btn xts-color-warning xts-remove-upload-btn<?php echo ( isset( $thumb_id ) && ! empty( $thumb_id ) ) ? ' xts-active' : ''; ?>">
											<?php esc_html_e( 'Remove', 'woodmart' ); ?>
										</button>

										<input id="product_attr_thumbnail_id" type="hidden" class="xts-upload-input-id" name="product_attr_thumbnail_id" value="<?php echo esc_attr( $thumb_id ); ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	add_action( 'woocommerce_after_edit_attribute_fields', 'woodmart_render_product_attrs_admin_options' );
	add_action( 'woocommerce_after_add_attribute_fields', 'woodmart_render_product_attrs_admin_options' );
}
