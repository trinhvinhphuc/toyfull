<?php

$extra_class = '';
$icon_type   = $params['icon_type'];

if ( $icon_type == 'custom' ) {
	$extra_class .= ' wd-tools-custom-icon';
}

woodmart_enqueue_inline_style( 'header-search' );

$extra_class .= woodmart_get_old_classes( ' search-button' );

$extra_class .= ' wd-display-' . $params['display'];

$settings = whb_get_settings();

if ( $params['display'] == 'form' ) {
	woodmart_enqueue_inline_style( 'header-search-form' );
	$search_style = isset( $params['search_style'] ) ? $params['search_style'] : 'default';
	$post_type    = $settings['search']['post_type'];

	if ( isset( $settings['mobilesearch'] ) && isset( $settings['mobilesearch']['post_type'] ) ) {
		$post_type = $settings['mobilesearch']['post_type'];
	}

	woodmart_search_form(
		array(
			'ajax'                   => $settings['search']['ajax'],
			'post_type'              => $post_type,
			'icon_type'              => $icon_type,
			'search_style'           => $search_style,
			'custom_icon'            => $params['custom_icon'],
			'wrapper_custom_classes' => 'wd-header-search-form-mobile' . woodmart_get_old_classes( ' woodmart-mobile-search-form' ),
		)
	);
	return;
}

woodmart_enqueue_js_script( 'mobile-search' );

?>

<div class="wd-header-search wd-tools-element wd-header-search-mobile<?php echo esc_attr( $extra_class ); ?>">
	<a href="#" rel="nofollow noopener" aria-label="<?php esc_html_e( 'Search', 'woodmart' ); ?>">
		<span class="wd-tools-icon<?php echo woodmart_get_old_classes( ' search-button-icon' ); ?>">
			<?php
			if ( $icon_type == 'custom' ) {
				echo whb_get_custom_icon( $params['custom_icon'] );
			}
			?>
		</span>
	</a>
</div>
