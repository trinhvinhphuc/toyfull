<?php
/**
 * Checkout builder.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

/**
 * Shop archive builder class.
 */
class Checkout extends Layout_Type {
	/**
	 * Before template content.
	 */
	public function before_template_content() {
		get_header();
		$content_class = woodmart_get_content_class();
		?>
		<div class="site-content <?php echo esc_attr( $content_class ); ?>" role="main">
		<?php
	}

	/**
	 * After template content.
	 */
	public function after_template_content() {
		?>
		</div>
		<?php
		get_footer();
	}

	/**
	 * Check.
	 *
	 * @param  array  $condition  Condition.
	 * @param  string  $type  Layout type.
	 */
	public function check( $condition, $type = '' ) {
		$is_active = false;

		if ( 'checkout_form' === $type ) {
			switch ( $condition['condition_type'] ) {
				case 'checkout_form':
					$is_active = ( is_checkout() && ! is_order_received_page() && ! is_wc_endpoint_url( 'order-pay' ) ) || ( is_singular( 'woodmart_layout' ) && Main::is_layout_type( 'checkout_content' ) );
					break;
			}
		} elseif ( 'checkout_content' === $type ) {
			switch ( $condition['condition_type'] ) {
				case 'checkout_content':
					$is_active = ( is_checkout() && ! is_order_received_page() && ! is_wc_endpoint_url( 'order-pay' ) ) || ( is_singular( 'woodmart_layout' ) && Main::is_layout_type( 'checkout_form' ) );
					break;
			}
		}

		return $is_active;
	}

	/**
	 * Override templates.
	 *
	 * @param  string  $template  Template.
	 *
	 * @return bool|string
	 */
	public function override_template( $template ) {
		if ( woodmart_woocommerce_installed() && is_checkout() && ! is_order_received_page() && ! is_wc_endpoint_url( 'order-pay' ) && ( Main::get_instance()->has_custom_layout( 'checkout_content' ) || Main::get_instance()->has_custom_layout( 'checkout_form' ) ) ) {
			$this->display_template();

			return false;
		}

		return $template;
	}

	/**
	 * Display custom template on the shop page.
	 */
	private function display_template() {
		$this->before_template_content();
		?>

		<?php if ( Main::get_instance()->has_custom_layout( 'checkout_content' ) ) : ?>
			<?php $this->template_content( 'checkout_content' ); ?>
		<?php else : ?>
			<?php woocommerce_checkout_coupon_form(); ?>
			<?php woocommerce_checkout_login_form(); ?>
		<?php endif; ?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
			<?php $this->template_content( 'checkout_form' ); ?>
		</form>

		<?php
		$this->after_template_content();
	}
}

Checkout::get_instance();
