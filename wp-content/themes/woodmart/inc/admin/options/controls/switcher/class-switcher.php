<?php
/**
 * Switcher form control "on/off".
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Switcher field control.
 */
class Switcher extends Field {

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$on_text  = isset( $this->args['on-text'] ) ? $this->args['on-text'] : esc_html__( 'On', 'woodmart' );
		$off_text = isset( $this->args['off-text'] ) ? $this->args['off-text'] : esc_html__( 'Off', 'woodmart' );

		$val = $this->get_field_value();

		if ( empty( $val ) ) {
			$val = 0;
		}

		?>
			<div class="xts-switcher-btns">
				<div class="xts-switcher-btn xts-switcher-on<?php echo esc_attr( ( $this->_is_activated() ) ? ' xts-switcher-active' : '' ); ?>">
					<?php echo esc_html( $on_text ); ?>
				</div>
				<div class="xts-switcher-btn xts-switcher-off<?php echo esc_attr( ( ! $this->_is_activated() ) ? ' xts-switcher-active' : '' ); ?>">
					<?php echo esc_html( $off_text ); ?>
				</div>
			</div>
			<input type="hidden" name="<?php echo esc_attr( $this->get_input_name() ); ?>" value="<?php echo esc_attr( $val ); ?>"/>
		<?php
	}

	/**
	 * Check if the value corresponds to "on" state.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	private function _is_activated() { // phpcs:ignore
		return '1' == $this->get_field_value() || 'yes' == $this->get_field_value();
	}
}
