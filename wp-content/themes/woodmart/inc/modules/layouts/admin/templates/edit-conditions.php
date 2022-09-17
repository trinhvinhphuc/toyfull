<?php
/**
 * Edit conditions template.
 *
 * @package Woodmart
 *
 * @var Admin  $admin      Admin instance.
 * @var string $type       Layout type.
 * @var array  $conditions Conditions.
 * @var int    $post_id    Post id.
 */

use XTS\Modules\Layouts\Admin;

$conditions = $conditions ? wp_json_encode( $conditions, JSON_HEX_APOS ) : '';

ob_start();
?>
<div class="xts-layout-conditions" data-type="<?php echo esc_attr( $type ); ?>" data-conditions='<?php echo
$conditions; ?>' data-id="<?php echo esc_attr( $post_id ); ?>">
	<a href="javascript:void(0);" class="xts-layout-conditions-edit-add xts-hidden xts-inline-btn xts-color-primary dashicons-plus-alt">
		<?php esc_html_e( 'Add condition', 'woodmart' ); ?>
	</a>

	<div class="xts-popup-actions xts-layout-submit-wrap">
		<a href="javascript:void(0);" class="xts-layout-conditions-edit-save xts-btn xts-color-primary xts-hidden">
			<?php esc_html_e( 'Save conditions', 'woodmart' ); ?>
		</a>
	</div>

</div>
<?php
$content = ob_get_clean();

$admin->get_template(
	'popup',
	array(
		'btn_text'    => esc_html__( 'Edit conditions', 'woodmart' ),
		'btn_classes' => ' xts-layout-conditions-edit',
		'title_text'  => esc_html__( 'Edit conditions', 'woodmart' ),
		'content'     => $content,
	)
);
