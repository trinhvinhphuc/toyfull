<?php
/**
 * The template for displaying all xts templates.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

$layout_type           = get_post_meta( get_the_ID(), 'wd_layout_type', true );
$checkout_form_id      = Main::get_instance()->get_layout_id( 'checkout_form' );
$checkout_content_id   = Main::get_instance()->get_layout_id( 'checkout_content' );
$checkout_form_post    = get_post( $checkout_form_id );
$checkout_content_post = get_post( $checkout_content_id );
?>

<?php get_header(); ?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<?php if ( 'checkout_content' === $layout_type ) : ?>
	<div class="woocommerce-checkout">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>

		<?php if ( $checkout_form_id ) : ?>
			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
				<?php if ( woodmart_is_elementor_installed() && Elementor\Plugin::$instance->documents->get( $checkout_form_post->ID )->is_built_with_elementor() ) : ?>
					<?php echo woodmart_elementor_get_content_css( $checkout_form_post->ID ); // phpcs:ignore ?>
					<?php echo woodmart_elementor_get_content( $checkout_form_post->ID ); // phpcs:ignore ?>
				<?php else : ?>
					<?php
					$shortcodes_custom_css = get_post_meta( $checkout_form_post->ID, '_wpb_shortcodes_custom_css', true );
					$woodmart_shortcodes_custom_css = get_post_meta( $checkout_form_post->ID, 'woodmart_shortcodes_custom_css', true );

					$content = '<style data-type="vc_shortcodes-custom-css">';
					if ( ! empty( $shortcodes_custom_css ) ) {
						$content .= $shortcodes_custom_css;
					}

					if ( ! empty( $woodmart_shortcodes_custom_css ) ) {
						$content .= $woodmart_shortcodes_custom_css;
					}
					$content .= '</style>';

					$content .= apply_filters( 'the_content', $checkout_form_post->post_content );

					echo $content;
					?>
				<?php endif; ?>
			</form>
		<?php endif; ?>
	</div>
<?php elseif ( 'checkout_form' === $layout_type ) : ?>
	<div class="woocommerce-checkout">
		<?php if ( $checkout_content_id ) : ?>
			<?php if ( woodmart_is_elementor_installed() && Elementor\Plugin::$instance->documents->get( $checkout_content_post->ID )->is_built_with_elementor() ) : ?>
				<?php echo woodmart_elementor_get_content_css( $checkout_content_post->ID ); // phpcs:ignore ?>
				<?php echo woodmart_elementor_get_content( $checkout_content_post->ID ); // phpcs:ignore ?>
			<?php else : ?>
				<?php
				$shortcodes_custom_css = get_post_meta( $checkout_content_post->ID, '_wpb_shortcodes_custom_css', true );
				$woodmart_shortcodes_custom_css = get_post_meta( $checkout_content_post->ID, 'woodmart_shortcodes_custom_css', true );

				$content = '<style data-type="vc_shortcodes-custom-css">';
				if ( ! empty( $shortcodes_custom_css ) ) {
					$content .= $shortcodes_custom_css;
				}

				if ( ! empty( $woodmart_shortcodes_custom_css ) ) {
					$content .= $woodmart_shortcodes_custom_css;
				}
				$content .= '</style>';

				$content .= apply_filters( 'the_content', $checkout_content_post->post_content );

				echo $content;
				?>
			<?php endif; ?>
		<?php endif; ?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</form>
	</div>
<?php elseif ( 'single_product' === $layout_type ) : ?>
	<div <?php wc_product_class(); ?>>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	</div>
<?php else : ?>
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
<?php endif; ?>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>
