<?php
/**
 * Free shipping progress bar.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Shipping_Progress_Bar;

use XTS\Options;
use XTS\Singleton;

/**
 * Free shipping progress bar.
 */
class Main extends Singleton {
	/**
	 * Constructor.
	 */
	public function init() {
		$this->add_options();
		$this->output_shipping_progress_bar();
	}

	/**
	 * Add options in theme settings.
	 */
	public function add_options() {
		Options::add_section(
			array(
				'id'       => 'shipping_progress_bar',
				'parent'   => 'shop_section',
				'name'     => esc_html__( 'Free shipping bar', 'woodmart' ),
				'priority' => 80,
			)
		);

		Options::add_field(
			array(
				'id'          => 'shipping_progress_bar_enabled',
				'name'        => esc_html__( 'Free shipping bar', 'woodmart' ),
				'description' => esc_html__( 'Display a free shipping progress bar on the website.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'shipping_progress_bar',
				'default'     => '0',
				'priority'    => 10,
			)
		);

		Options::add_field(
			array(
				'id'          => 'shipping_progress_bar_amount',
				'name'        => esc_html__( 'Goal amount', 'woodmart' ),
				'description' => esc_html__( 'Amount to reach 100% defined in your currency absolute value. For example: 300', 'woodmart' ),
				'type'        => 'text_input',
				'section'     => 'shipping_progress_bar',
				'default'     => '100',
				'priority'    => 20,
			)
		);

		Options::add_field(
			array(
				'id'       => 'shipping_progress_bar_location_card_page',
				'name'     => esc_html__( 'Cart page', 'woodmart' ),
				'type'     => 'switcher',
				'section'  => 'shipping_progress_bar',
				'group'    => esc_html__( 'Locations', 'woodmart' ),
				'default'  => '1',
				'priority' => 30,
				'class'    => 'xts-col-6',
			)
		);

		Options::add_field(
			array(
				'id'       => 'shipping_progress_bar_location_mini_cart',
				'name'     => esc_html__( 'Mini cart', 'woodmart' ),
				'type'     => 'switcher',
				'section'  => 'shipping_progress_bar',
				'group'    => esc_html__( 'Locations', 'woodmart' ),
				'default'  => '1',
				'priority' => 40,
				'class'    => 'xts-col-6',
			)
		);

		Options::add_field(
			array(
				'id'       => 'shipping_progress_bar_location_checkout',
				'name'     => esc_html__( 'Checkout page', 'woodmart' ),
				'type'     => 'switcher',
				'section'  => 'shipping_progress_bar',
				'group'    => esc_html__( 'Locations', 'woodmart' ),
				'default'  => '0',
				'priority' => 50,
				'class'    => 'xts-col-6',
			)
		);

		Options::add_field(
			array(
				'id'       => 'shipping_progress_bar_location_single_product',
				'name'     => esc_html__( 'Single product', 'woodmart' ),
				'type'     => 'switcher',
				'section'  => 'shipping_progress_bar',
				'group'    => esc_html__( 'Locations', 'woodmart' ),
				'default'  => '0',
				'priority' => 60,
				'class'    => 'xts-col-6',
			)
		);

		Options::add_field(
			array(
				'id'          => 'shipping_progress_bar_message_initial',
				'name'        => esc_html__( 'Initial Message', 'woodmart' ),
				'description' => esc_html__( 'Message to show before reaching the goal. Use shortcode [remainder] to display the amount left to reach the minimum.', 'woodmart' ),
				'type'        => 'textarea',
				'wysiwyg'     => true,
				'section'     => 'shipping_progress_bar',
				'group'       => esc_html__( 'Message', 'woodmart' ),
				'default'     => '<p>Add [remainder] to cart and get free shipping!</p>',
				'priority'    => 70,
			)
		);

		Options::add_field(
			array(
				'id'          => 'shipping_progress_bar_message_success',
				'name'        => esc_html__( 'Success message', 'woodmart' ),
				'description' => esc_html__( 'Message to show after reaching 100%.', 'woodmart' ),
				'type'        => 'textarea',
				'wysiwyg'     => true,
				'section'     => 'shipping_progress_bar',
				'group'       => esc_html__( 'Message', 'woodmart' ),
				'default'     => '<p>Your order qualifies for free shipping!</p>',
				'priority'    => 80,
			)
		);
	}

	/**
	 * Output shipping progress bar.
	 */
	public function output_shipping_progress_bar() {
		if ( ! woodmart_get_opt( 'shipping_progress_bar_enabled' ) ) {
			return;
		}

		if ( woodmart_get_opt( 'shipping_progress_bar_location_card_page' ) ) {
			add_action( 'woocommerce_before_cart_table', array( $this, 'render_shipping_progress_bar' ) );
		}

		if ( woodmart_get_opt( 'shipping_progress_bar_location_mini_cart' ) ) {
			add_action( 'woocommerce_widget_shopping_cart_before_buttons', array( $this, 'render_shipping_progress_bar' ) );
		}

		if ( woodmart_get_opt( 'shipping_progress_bar_location_single_product' ) ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'render_shipping_progress_bar' ), 29 );
		}

		if ( woodmart_get_opt( 'shipping_progress_bar_location_checkout' ) ) {
			add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'render_shipping_progress_bar' ) );
		}

		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'get_shipping_progress_bar_fragment' ), 40 );
	}

	/**
	 * Add shipping progress bar fragment.
	 *
	 * @param array $array Fragments.
	 *
	 * @return array
	 */
	public function get_shipping_progress_bar_fragment( $array ) {
		ob_start();

		$this->render_shipping_progress_bar();

		$content = ob_get_clean();

		if ( apply_filters( 'woodmart_update_fragments_fix', true ) ) {
			$array['div.wd-free-progress-bar_wd'] = $content;
		} else {
			$array['div.wd-free-progress-bar'] = $content;
		}

		return $array;
	}

	/**
	 * Render free shipping progress bar.
	 */
	public function render_shipping_progress_bar() {
		if ( ! woodmart_get_opt( 'shipping_progress_bar_enabled' ) ) {
			return;
		}

		$total           = WC()->cart->get_displayed_subtotal();
		$wrapper_classes = '';
		$limit           = woodmart_get_opt( 'shipping_progress_bar_amount' );
		$percent         = 100;

		if ( 0 === (int) $total ) {
			$wrapper_classes .= ' wd-progress-hide';
		}

		if ( $total < $limit ) {
			$percent = floor( ( $total / $limit ) * 100 );
			$message = str_replace( '[remainder]', wc_price( $limit - $total ), woodmart_get_opt( 'shipping_progress_bar_message_initial' ) );
		} else {
			$message = woodmart_get_opt( 'shipping_progress_bar_message_success' );
		}

		woodmart_enqueue_inline_style( 'woo-opt-free-progress-bar' );
		woodmart_enqueue_inline_style( 'woo-mod-progress-bar' );

		?>
		<div class="wd-progress-bar wd-free-progress-bar<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="progress-msg">
				<?php echo wp_kses( $message, 'post' ); ?>
			</div>
			<div class="progress-area">
				<div class="progress-bar" style="width: <?php echo esc_attr( $percent ); ?>%"></div>
			</div>
		</div>
		<?php
	}
}

Main::get_instance();
