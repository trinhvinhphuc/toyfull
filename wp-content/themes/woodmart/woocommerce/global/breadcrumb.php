<?php
/**
 * Shop breadcrumb
 *
 * @author WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 * @see woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$delimiter = '';

if ( ! empty( $breadcrumb ) ) {
	$count = count( $breadcrumb );
	$class = '';
	$i     = 0;

	echo wp_kses_post( $wrap_before );

	foreach ( $breadcrumb as $key => $crumb ) {
		$i++;

		if ( $i === $count - 1 ) {
			$class = ' breadcrumb-link-last';
		}

		echo wp_kses_post( $before );

		if ( ! empty( $crumb[1] ) && count( $breadcrumb ) !== $key + 1 ) :
			?>
				<a href="<?php echo esc_url( $crumb[1] ); ?>" class="breadcrumb-link<?php echo esc_attr( $class ); ?>">
					<?php echo esc_html( $crumb[0] ); ?>
				</a>
			<?php
		else :
			?>
				<span class="breadcrumb-last">
					<?php echo esc_html( $crumb[0] ); ?>
				</span>
			<?php
		endif;

		echo wp_kses_post( $after );

		if ( count( $breadcrumb ) !== $key + 1 ) {
			echo wp_kses_post( $delimiter );
		}
	}

	echo wp_kses_post( $wrap_after );
}
