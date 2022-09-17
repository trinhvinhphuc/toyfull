<?php
/**
 * Predefined layouts template.
 *
 * @package Woodmart
 *
 * @var array $layouts Layouts.
 */

?>
<?php foreach ( $layouts as $layout_type => $values ) : ?>
	<div class="xts-layout-predefined-layouts xts-images-set xts-hidden" data-type="<?php echo esc_attr( $layout_type ); ?>">
		<h4><?php esc_html_e( 'Predefined layouts', 'woodmart' ); ?></h4>
		<div class="xts-btns-set">
			<?php foreach ( $values as $layout ) : ?>
				<div class="xts-layout-predefined-layout xts-set-item xts-set-btn-img" data-name="<?php echo esc_attr( $layout ); ?>">
					<img src="<?php echo esc_url( WOODMART_THEME_DIR . '/inc/modules/layouts/admin/predefined/' . $layout_type . '/' . $layout . '/preview.jpg' ); ?>" alt="<?php echo esc_attr__( 'Layout preview', 'woodmart' ); ?>">
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endforeach; ?>
