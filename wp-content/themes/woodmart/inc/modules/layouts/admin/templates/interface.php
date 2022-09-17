<?php
/**
 * Interface template.
 *
 * @package Woodmart
 *
 * @var Admin $admin Admin instance.
 */

use XTS\Modules\Layouts\Admin;

?>

<div class="wd-layout">
	<?php
	$admin->get_template(
		'popup',
		array(
			'btn_text'   => '',
			'title_text' => esc_html__( 'Create layout', 'woodmart' ),
			'content'    => $admin->get_form(),
		)
	);
	?>

	<?php $admin->print_condition_template(); ?>
	<?php $admin->print_tabs(); ?>
</div>
