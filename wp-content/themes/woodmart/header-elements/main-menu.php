<?php
$extra_class = '';
$menu_style  = ( $params['menu_style'] ) ? $params['menu_style'] : 'default';
$location    = 'main-menu';
$classes     = 'text-' . $params['menu_align'];
$icon_type   = $params['icon_type'];

if ( $icon_type == 'custom' ) {
	$extra_class .= ' wd-tools-custom-icon';
}

if ( 'bordered' === $params['menu_style'] ) {
	$classes .= ' wd-full-height';
}

$menu_classes = ' wd-style-' . $menu_style;
if ( isset( $params['items_gap'] ) ) {
	$menu_classes .= ' wd-gap-' . $params['items_gap'];
}

$classes     .= woodmart_get_old_classes( ' navigation-style-' . $menu_style );
$extra_class .= woodmart_get_old_classes( ' full-screen-burger-icon woodmart-burger-icon' );

if ( $params['full_screen'] ) {
	woodmart_enqueue_inline_style( 'header-fullscreen-menu' );
	?>
		<div class="wd-tools-element wd-header-fs-nav<?php echo esc_attr( $extra_class ); ?>">
			<a href="#" rel="nofollow noopener">
				<span class="wd-tools-icon<?php echo woodmart_get_old_classes( ' woodmart-burger' ); ?>">
					<?php if ( $icon_type == 'custom' ) : ?>
						<?php echo whb_get_custom_icon( $params['custom_icon'] ); ?>
					<?php endif; ?>
				</span>

				<span class="wd-tools-text"><?php esc_html_e( 'Menu', 'woodmart' ); ?></span>
			</a>
		</div>
	<?php
	return;
}
?>
<div class="wd-header-nav wd-header-main-nav <?php echo esc_attr( $classes ); ?>" role="navigation">
	<?php
	$args = array(
		'container'  => '',
		'menu_class' => 'menu wd-nav wd-nav-main' . $menu_classes,
		'walker'     => new WOODMART_Mega_Menu_Walker(),
	);

	if ( empty( $params['menu_id'] ) ) {
		$args['theme_location'] = $location;
	}

	if ( ! empty( $params['menu_id'] ) ) {
		$args['menu'] = $params['menu_id'];
	}

	if ( has_nav_menu( $location ) ) {
		wp_nav_menu( $args );
	} else {
		$menu_link = get_admin_url( null, 'nav-menus.php' );
		?>
				<div class="create-nav-msg">
			<?php
				printf(
					wp_kses(
						__( 'Create your first <a href="%s"><strong>navigation menu here</strong></a> and add it to the "Main menu" location.', 'woodmart' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					$menu_link
				);
			?>
				</div>
			<?php
	}
	?>
</div><!--END MAIN-NAV-->
