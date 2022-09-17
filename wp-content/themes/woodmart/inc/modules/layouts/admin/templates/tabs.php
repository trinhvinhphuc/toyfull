<?php
/**
 * Tabs template.
 *
 * @package Woodmart
 *
 * @var array  $tabs        Tabs.
 * @var string $current_tab Current tab.
 * @var string $base_url    Base url.
 */

?>
<div class="nav-tab-wrapper">
	<?php foreach ( $tabs as $key => $label ) : ?>
		<?php
		$classes = '';

		if ( $current_tab === $key ) {
			$classes .= ' nav-tab-active';
		}
		?>

		<a class="nav-tab<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_attr( add_query_arg( 'wd_layout_type_tab', $key, $base_url ) ); ?>">
			<?php echo esc_html( $label ); ?>
		</a>
	<?php endforeach; ?>
</div>
