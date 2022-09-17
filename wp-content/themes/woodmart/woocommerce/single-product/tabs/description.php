<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

use Elementor\Plugin;
use XTS\Modules\Layouts\Main as Builder;

defined( 'ABSPATH' ) || exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );
?>

<?php if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>

<?php
if ( 'elementor' === woodmart_get_current_page_builder() && Builder::get_instance()->has_custom_layout( 'single_product' ) ) {
	$editor       = Plugin::$instance->editor;
	$is_edit_mode = $editor->is_edit_mode();
	$editor->set_edit_mode( false );
	$post_id      = get_the_ID();
	$document     = Plugin::$instance->documents->get_doc_for_frontend( $post_id );
	$content      = Plugin::$instance->frontend->get_builder_content( $post_id, $is_edit_mode );

	if ( $document->is_built_with_elementor() && $content ) {
		echo $content; // phpcs:ignore
	} else {
		the_content();
	}

	Plugin::$instance->editor->set_edit_mode( $is_edit_mode );
} else {
	the_content();
}
?>
