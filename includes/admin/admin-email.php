<?php
/**
 * Settings Page for Email Settings
 *
 * @package tecsb
 * @author mokchya
 */

?>
<?php
$site_name              = get_bloginfo( 'name' );
$admin_email            = get_option( 'admin_email' );
$tecsb_footer_left_note = esc_html__( '© 2020, All rights reserved.', 'tecsb' );
$tecsb_newevent_header  = esc_html__( 'New Event', 'tecsb' );
?>
<div class="tecsb-admin-content-box">
	<div class="tecsb-admin-content-header">
		<h3><i class="tecsb-icon-mail-alt header-icon"></i><?php esc_html_e( 'Email Settings', 'tecsb' ); ?></h3>
	</div>
	<div class="tecsb-admin-content-main">
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'Sender Settings', 'tecsb' ); ?>
			</p>
			<p>
				<label for="tecsb_sender_name"><?php esc_html_e( 'Sender Name', 'tecsb' ); ?></label>
				<span class="input">
					<input type="text" name="tecsb_sender_name" placeholder="<?php echo esc_html( $site_name ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_sender_name' ) ); ?>"/>
				</span>
			</p>
			<p>
				<label for="tecsb_sender_email"><?php esc_html_e( 'Sender Email', 'tecsb' ); ?></label>
				<span class="input">
					<input type="text" name="tecsb_sender_email" placeholder="<?php echo esc_html( $admin_email ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_sender_email' ) ); ?>"/>
				</span>
			</p>
		</div>
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'Header / Footer Notes', 'tecsb' ); ?>
			</p>
			<p>
				<label for="tecsb_footer_left_note"><?php esc_html_e( 'Footer Left Note', 'tecsb' ); ?></label>
				<span class="input">
					<input type="text" name="tecsb_footer_left_note" placeholder="<?php echo esc_html( $tecsb_footer_left_note ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_footer_left_note', $tecsb_footer_left_note ) ); ?>"/>
				</span>
			</p>
		</div>
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'Email Information and Template', 'tecsb' ); ?>
			</p>
			<div class="tecsb-email-type-settings tecsb-accordion-container">
				<button class="tecsb-accordion"><?php esc_html_e( 'Verification Email', 'tecsb' ); ?></button>
				<div class="tecsb-accordion-panel">
					<p>
						<label for="tecsb_verification_subject"><?php esc_html_e( 'Email Subject', 'tecsb' ); ?></label>
						<span class="input">
							<input type="text" name="tecsb_verification_subject" placeholder="<?php esc_html_e( 'Verify your Subscription', 'tecsb' ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_verification_subject' ) ); ?>"/>
						</span>
					</p>
					<p>
						<span class="preview-email-body" data-type="verification"><?php esc_html_e( 'Email Preview', 'tecsb' ); ?>
					</p>
				</div>
				<button class="tecsb-accordion"><?php esc_html_e( 'Confirmation Email', 'tecsb' ); ?></button>
				<div class="tecsb-accordion-panel">
					<p>
						<label for="tecsb_confirmation_subject"><?php esc_html_e( 'Email Subject', 'tecsb' ); ?></label>
						<span class="input">
							<input type="text" name="tecsb_confirmation_subject" placeholder="<?php esc_html_e( 'Thank you for subscribing to our site!', 'tecsb' ); ?>"  value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_confirmation_subject' ) ); ?>"/>
						</span>
					</p>
					<p>
						<span class="preview-email-body" data-type="confirmation"><?php esc_html_e( 'Email Preview', 'tecsb' ); ?>
					</p>
				</div>
				<button class="tecsb-accordion"><?php esc_html_e( 'Notification Email', 'tecsb' ); ?></button>
				<div class="tecsb-accordion-panel">
					<p>
						<label for="tecsb_notification_subject"><?php esc_html_e( 'Email Subject', 'tecsb' ); ?></label>
						<span class="input">
							<input type="text" name="tecsb_notification_subject" placeholder="<?php esc_html_e( 'You have a new subscriber!', 'tecsb' ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_notification_subject' ) ); ?>"/>
						</span>
					</p>
					<p>
						<span class="preview-email-body" data-type="notification"><?php esc_html_e( 'Email Preview', 'tecsb' ); ?>
					</p>
				</div>
				<button class="tecsb-accordion"><?php esc_html_e( 'New Event Email', 'tecsb' ); ?></button>
				<div class="tecsb-accordion-panel">
					<p>
						<label for="tecsb_newevent_subject"><?php esc_html_e( 'Email Subject', 'tecsb' ); ?></label>
						<span class="input">
							<input type="text" name="tecsb_newevent_subject" placeholder="<?php esc_html_e( 'New Event {event-name}', 'tecsb' ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_newevent_subject' ) ); ?>"/>
						</span>
					</p>
					<p>
						<label for="tecsb_newevent_header"><?php esc_html_e( 'Header', 'tecsb' ); ?></label>
						<span class="input">
							<input type="text" name="tecsb_newevent_header" placeholder="<?php esc_html_e( 'New Event', 'tecsb' ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_newevent_header', $tecsb_newevent_header ) ); ?>"/>
						</span>
					</p>
					<p>
						<span class="preview-email-body" data-type="newevent"><?php esc_html_e( 'Email Preview', 'tecsb' ); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="tecsb-admin-popup-wrap">
	<div class="tecsb-admin-popup-container tecsb-transform-out">
		<div class="tecsb-admin-popup-header">
			<span class="from"><b><?php esc_html_e( 'From', 'tecsb' ); ?></b><i></i></span>
			<span class="to"><b><?php esc_html_e( 'To', 'tecsb' ); ?></b><i></i></span>
			<span class="subject"><b><?php esc_html_e( 'Subject', 'tecsb' ); ?></b><i></i></span>
		</div>
		<div class="tecsb-admin-popup-content"></div>
	<a class="tecsb-admin-popup-close" href="#">x</a>
	</div>
</div>
