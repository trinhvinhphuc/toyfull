<?php
/**
 * Notice control.
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Notice control.
 */
class Notice extends Field {
	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$content = str_replace( '{{PERMALINK}}', get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ), $this->args['content'] );
		?>
			<div class="xts-notice xts-<?php echo esc_attr( $this->args['style'] ); ?>">
				<?php echo $content; // phpcs:ignore ?>
			</div>
		<?php
	}
}


