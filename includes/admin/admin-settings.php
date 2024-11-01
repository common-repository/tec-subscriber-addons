<?php
/**
 * Subscriber plugin admin setting page
 *
 * @package tecsb
 * @author mokchya
 */

?>
<form method="post" action="options.php">
	<?php settings_fields( 'tecsb-options' ); ?>
	<?php do_settings_sections( 'tecsb-options' ); ?>
	<?php $options = get_option( 'tecsb-options' ); ?>
	<div class="tecsb-admin-wrapper">
		<h2 class="nav-tab-wrapper">  
			<div class="nav-tab nav-tab-active green">
				<?php esc_html_e( 'Event Subscriber for The Events Calendar', 'tecsb' ); ?>
			</div>  
		</h2>
		<?php do_action( 'tecsb_admin_tab' ); ?>
		<table class="tecsb-admin-table">
			<tbody>
				<tr>
					<td valign="top" class="tecsb-admin-sidebar">
						<ul class="tecsb-admin-tab green">
							<li><a class="tecsb-tablinks active" href="#general"><i class="tecsb-icon-cog-alt"></i><span><?php esc_html_e( 'General', 'tecsb' ); ?></span></a></li>
							<li><a class="tecsb-tablinks" href="#email"><i class="tecsb-icon-mail-alt"></i><span><?php esc_html_e( 'Email', 'tecsb' ); ?></span></a></li>
							<li><a class="tecsb-tablinks" href="#form"><i class="tecsb-icon-wpforms"></i><span><?php esc_html_e( 'Form', 'tecsb' ); ?></span></a></li>
							<?php do_action( 'tecsb_more_tab' ); ?>
						</ul>
						<span class="tecsb-sidebar-footer orange">
							<a class="tesb-sidebar-fbtn save-settings-all"><i class="tecsb-icon-floppy-1"></i><span><?php esc_html_e( 'Save Changes', 'tecsb' ); ?></span></a>
						</span>
					</td>

					<td class="tecsb-admin-tabcontent" width="100%" valign="top">
						<div class="tecsb-admin-saving"></div>
						<div id="general" class="active tecsb-admin-content">
							<?php require_once 'admin-general.php'; ?>
						</div>
						<div id="email" class="tecsb-admin-content">
							<?php require_once 'admin-email.php'; ?>
						</div>
						<div id="form" class="tecsb-admin-content">
							<?php require_once 'admin-form.php'; ?>
						</div>
						<?php do_action( 'tecsb_more_content' ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- <div class="tecsb-admin-footer">
			<button type="submit" name="tecsb-admin-save" class="tecsb-admin-save grey"><?php esc_html_e( 'SAVE CHANGES', 'tecsb' ); ?></button>
		</div> -->
	</div>
</form>
