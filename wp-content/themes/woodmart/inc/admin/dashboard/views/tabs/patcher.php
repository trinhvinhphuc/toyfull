<?php
/**
 * Interface for patch.
 *
 * @package Woodmart
 */

use XTS\Modules\Patcher\Client;

?>
<div class="woodmart-row woodmart-one-column">
	<div class="woodmart-column woodmart-stretch-column">
		<div class="woodmart-column-inner">
			<div class="wd-box xts-dashboard">
				<div class="woodmart-box-header">
					<h2>
						<?php esc_html_e( 'Patcher', 'woodmart' ); ?>
					</h2>
				</div>
				<div class="woodmart-box-content">
					<div class="xts-loader-wrapper">
						<div class="xts-loader">
							<div class="xts-loader-el"></div>
							<div class="xts-loader-el"></div>
						</div>
						<p>
							<?php esc_html_e( 'It may take a few minutes...', 'woodmart' ); ?>
						</p>
					</div>
					<?php Client::get_instance()->interface(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
