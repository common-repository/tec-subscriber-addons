<?php
/**
 * Event Subscription Page Template
 *
 * You can copy this template to
 * ../wp-content/themes/(your-current-theme)/tecsb/templates/subscriber/
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */

get_header();
$theme    = 'one';
$theme_bg = 'tecsb-theme-' . $theme . '-bg';
if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'tecsb_nonce' ) ) {
	?>
	<div class="tecsb-subscriber-page-container ">
	<?php
	esc_html_e( 'Page cannot be accessed directly.', 'tecsb' );
	?>
	</div>
	<?php
	get_footer();
	return;
}
?>
<div class="tecsb-subscriber-page-container ">
	<span class="tecsb-working"></span>
	<div class="tecsb-subscriber-page <?php echo esc_attr( $theme_bg ); ?>">
		<?php
		$notice = '';
		if ( ! isset( $_REQUEST['action'] ) || ( isset( $_REQUEST['action'] ) && 'manage' === $_REQUEST['action'] ) ) {
			$email = isset( $_REQUEST['email'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['email'] ) ) : '';
			?>
			<div class="tecsb_subscription_manager_form">
				<div class="tecsb-manager-container">
					<p class="tecsb-manager-notice">
					</p>
				</div>
				<div id="tecsb-subform-submit-email">
					<p>
						<label for="tecsb_email">
							<?php esc_html_e( 'Type your email address', 'tecsb' ); ?>
						</label>
						<input type="text" name='tecsb_email' style='width:100%' value='<?php echo esc_attr( sanitize_email( $email ) ); ?>'/>
					</p>
					<input type="hidden" name='action' value='tecsb_subscription_manager'>
					<p class="tecsb-subform-footer">
						<span class='tecsb-fe-manage-btn'>
							<?php esc_html_e( 'Manage Subscription', 'tecsb' ); ?>
						</span>
					</p>
				</div>
				<div id="tecsb-subform-manage-sub">
				</div>
			</div>
			<?php

		} else {
			$reaction = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';
			$email    = isset( $_REQUEST['email'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['email'] ) ) : '';
			$sid      = isset( $_REQUEST['sid'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['sid'] ) ) : '';
			$ukey     = isset( $_REQUEST['ukey'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['ukey'] ) ) : '';
			if ( ! empty( $reaction ) ) {
				global $tecsb;
				switch ( $reaction ) {
					case 'verify':
						$verify = $tecsb->function->tecsb_verify_subscription( $email, $sid, $ukey );
						if ( $verify ) {
							$notice = esc_html__( 'Email address verified successfully', 'tecsb' );
						} else {
							$notice = esc_html__( 'Something went wrong while verifing your email address', 'tecsb' );
						}
						break;
					case 'manage':
						break;
					case 'unsubscribe':
						$unsubscribe = $tecsb->function->tecsb_unsubscribe_subscription( $email, $sid, $ukey );
						if ( $unsubscribe ) {
							$notice = esc_html__( 'Email address unsubscribed successfully', 'tecsb' );
						} else {
							$notice = esc_html__( 'Something went wrong while unsubscribing your email address', 'tecsb' );
						}
						break;
					case 'default':
						break;
				}
			}
			?>
			<?php if ( ! empty( $notice ) ) : ?>
				<div class="tecsb-tsp-container">
					<p class="tecsb-tsp-notice">
						<?php echo esc_html( $notice ); ?>
					</p>
				</div>
			<?php endif; ?>
			<?php
		}
		?>
	</div>
</div>
<?php
get_footer();
