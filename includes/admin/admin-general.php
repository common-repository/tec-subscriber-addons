<?php
/**
 * Settings Page for General Settings
 *
 * @package tecsb
 * @author mokchya
 */

$options = get_option( 'tecsb-options' );
global $tecsb;
?>
<div class="tecsb-admin-content-box">
	<div class="tecsb-admin-content-header">
		<h3><i class="tecsb-icon-cog-alt header-icon"></i><?php esc_html_e( 'General Settings', 'tecsb' ); ?></h3>
	</div>
	<div class="tecsb-admin-content-main">
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'General Settings', 'tecsb' ); ?>
			</p>
			<p class="tecsb-onoff-switch">
					<?php $_status = $tecsb->function->return_check_yesno( 'tecsb_admin_ssad' ); ?>
					<?php $tecsb->function->tecsb_switch_button( 'tecsb_admin_ssad', 'green', $_status ); ?>
					<span class="label">
						<?php esc_html_e( 'Save subscriber as draft?', 'tecsb' ); ?>
					</span>
			</p>
		</div>
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'Subscription Form', 'tecsb' ); ?>
			</p>
			<p class="tecsb-onoff-switch">
				<?php $_status = $tecsb->function->return_check_yesno( 'tecsb_admin_sform_above' ); ?>
				<?php $tecsb->function->tecsb_switch_button( 'tecsb_admin_sform_above', 'green', $_status ); ?>
				<span class="label">
					<?php esc_html_e( 'Display Subscription page above events page?', 'tecsb' ); ?>
				</span>
			</p>
			<p class="tecsb-onoff-switch">
				<?php $_status = $tecsb->function->return_check_yesno( 'tecsb_admin_sform_below' ); ?>
				<?php $tecsb->function->tecsb_switch_button( 'tecsb_admin_sform_below', 'green', $_status ); ?>
				<span class="label">
					<?php esc_html_e( 'Display Subscription page below events page?', 'tecsb' ); ?>
				</span>
			</p>
		</div>
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'Link to your Privacy Policy page', 'tecsb' ); ?>
			</p>
			<p class="tecsb-admin-content-info">
				<?php esc_html_e( '** A Link will be shown below subscription form if not left empty.', 'tecsb' ); ?>
			</p>
			<p>
				<input type="text" name="tecsb_admin_pp" placeholder="" value="<?php echo esc_html( $tecsb->function->return_option_value( 'tecsb_admin_pp' ) ); ?>"/>
			</p>
		</div>

		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
					<?php esc_html_e( 'Link to your Terms of Use page', 'tecsb' ); ?>
			</p>
			<p class="tecsb-admin-content-info">
				<?php esc_html_e( '** A Link will be shown below subscription form if not left empty.', 'tecsb' ); ?>
			</p>
			<p>
				<input type="text" name="tecsb_admin_tou" placeholder="" value="<?php echo esc_html( $tecsb->function->return_option_value( 'tecsb_admin_tou' ) ); ?>"/>
			</p>
		</div>

		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'Uninstall Settings', 'tecsb' ); ?>
			</p>
			<p class="tecsb-onoff-switch">
				<?php $_status = $tecsb->function->return_check_yesno( 'tecsb_admin_uninstall' ); ?>
				<?php $tecsb->function->tecsb_switch_button( 'tecsb_admin_uninstall', 'green', $_status ); ?>
				<span class="label">
					<?php esc_html_e( 'Delete setting options on uninstall', 'tecsb' ); ?>
				</span>
			</p>
		</div>
	</div>
</div>
