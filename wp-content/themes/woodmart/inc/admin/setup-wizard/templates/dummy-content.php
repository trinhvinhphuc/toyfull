<?php
/**
 * Dummy content template.
 *
 * @package woodmart
 */

use XTS\Import\Remove;
use XTS\Import\Import;

$wrapper_classes = '';

if ( Import::get_instance()->is_imported( 'base' ) && Remove::get_instance()->has_data_to_remove() ) {
	$wrapper_classes .= ' imported-base';
}
?>

<div class="xts-wizard-content-inner xts-wizard-dummy<?php echo esc_attr( $wrapper_classes ); ?>">
	<h3>
		<?php esc_html_e( 'Dummy content', 'woodmart' ); ?>
	</h3>

	<?php Import::get_instance()->interface(); ?>

	<p class="xts-wizard-note">
		<?php
		echo wp_kses(
			'You can import any of the demo versions that will include a home page, a few products, posts, projects, images and menus. You will be able to switch to any demo at any time or just skip this step for now.',
			woodmart_get_allowed_html()
		);
		?>
	</p>
</div>

<div class="xts-wizard-footer">
	<?php $this->get_prev_button( 'plugins' ); ?>
	<div>
		<?php $this->get_next_button( 'done' ); ?>
		<?php $this->get_skip_button( 'done' ); ?>
	</div>
</div>


<div class="xts-wizard-content-inner xts-wizard-done">
	<div class="xts-wizard-logo">
		<img src="<?php echo esc_url( $this->get_image_url( 'logo.svg' ) ); ?>" alt="logo">
	</div>

	<h3>
		<?php esc_html_e( 'Everything is ready!', 'woodmart' ); ?>
	</h3>

	<p>
		<?php
		esc_html_e(
			'Congratulations! You have successfully installed our theme. Now you can start creating your amazing website with a help of our theme. It provides you with a full control on your website layout style.',
			'woodmart'
		);
		?>
	</p>

	<div class="xts-wizard-buttons">
		<a class="xts-btn xts-color-alt" href="<?php echo esc_url( get_home_url() ); ?>">
			<?php esc_html_e( 'View home page', 'woodmart' ); ?>
		</a>

		<a class="xts-inline-btn" href="<?php echo esc_url( wc_admin_url( '&path=/setup-wizard' ) ); ?>">
			<?php esc_html_e( 'WooCommerce setup', 'woodmart' ); ?>
		</a>

		<a class="xts-inline-btn" href="<?php echo esc_url( admin_url( 'admin.php?page=xtemos_options' ) ); ?>">
			<?php esc_html_e( 'Theme settings', 'woodmart' ); ?>
		</a>

		<a class="xts-inline-btn" href="<?php echo esc_url( admin_url( 'admin.php?page=woodmart_dashboard&tab=builder' ) ); ?>">
			<?php esc_html_e( 'Header builder', 'woodmart' ); ?>
		</a>
	</div>
</div>