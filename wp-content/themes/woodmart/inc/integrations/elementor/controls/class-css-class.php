<?php
/**
 * Elementor CSS_Class controls
 *
 * @package xts
 */

namespace XTS\Elementor\Controls;

use Elementor\Base_Data_Control;

/**
 * Elementor wd_CSS_Class control.
 *
 * @since 1.0.0
 */
class CSS_Class extends Base_Data_Control {

	/**
	 * Get wd_CSS_Class control type.
	 *
	 * Retrieve the control type, in this case `wd_CSS_Class`.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'wd_css_class';
	}

	/**
	 * Get wd_CSS_Class control default settings.
	 *
	 * Retrieve the default settings of the wd_CSS_Class control. Used to return the
	 * default settings while initializing the wd_CSS_Class control.
	 *
	 * @since  1.8.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return array(
			'options' => array(),
		);
	}

	/**
	 * Render wd_CSS_Class control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<input type="hidden" id="<?php echo esc_attr( $control_uid ); ?>" data-setting="{{ data.name }}">
		</div>
		<?php
	}
}
