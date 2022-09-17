<?php
/**
 * Cart builder.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

/**
 * Shop archive builder class.
 */
class Cart extends Layout_Type {
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

		switch ( $condition['condition_type'] ) {
			case 'cart':
				$is_active = is_cart() && ! WC()->cart->is_empty();
				break;
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
		if ( woodmart_woocommerce_installed() && is_cart() && Main::get_instance()->has_custom_layout( 'cart' ) ) {
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
		<div class="woocommerce">
			<?php $this->template_content( 'cart' ); ?>
		</div>
		<?php
		$this->after_template_content();
	}
}

Cart::get_instance();
