<?php
/**
 * Email template for New Event email
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */

?>
<?php
$event_image           = isset( $args['event_image'] ) ? $args['event_image'] : '';
$event_title           = isset( $args['event_title'] ) ? $args['event_title'] : '';
$event_time            = isset( $args['event_time'] ) ? $args['event_time'] : '';
$event_link            = isset( $args['event_link'] ) ? $args['event_link'] : '';
$manage_link           = isset( $args['manage_link'] ) ? $args['manage_link'] : '';
$tecsb_newevent_header = esc_html__( 'New Event', 'tecsb' );
$tecsb_newevent_header = $tecsb->function->return_option_value( 'tecsb_newevent_header', $tecsb_newevent_header );
?>
<table class="devicewidth" width="600" cellspacing="0" cellpadding="0" border="0" align="center"
style="text-align:center;"
>
	<tbody style="word-break: break-word;">
		<tr>
			<td>
				<table zp-bg-color="Module-Background" class="tecsb-table-center" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f8f8f8" align="center"
				style="text-align:center;"
				>
					<tbody style="word-break: break-word;">
						<tr>
							<td class="heightsmalldevices" height="57">&nbsp;</td>
						</tr>
						<tr>
							<td class="tecsb-heading-1  right-left-padding"
							style="padding: 0 12px;
	font:700 37px 'Montserrat', Helvetica, Arial, sans-serif;
	color:#f27b69;
	text-transform:uppercase;"
							>
								<font>
								<?php echo esc_html( $tecsb_newevent_header ); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td class="heightSDBottom" height="60">&nbsp;</td>
						</tr>
						<?php if ( ! empty( $event_image ) ) : ?>
							<tr>
								<td class="tecsb-image-td" valign="top">
									<a target="_blank" style="text-decoration: none;" href="<?php echo esc_url( $event_link ); ?>">
										<img src="<?php echo esc_attr( $event_image ); ?>" class="tecsb-newevent-image" width="100%" vspace="0" hspace="0" border="0">
									</a>
								</td>
							</tr>
						<?php endif; ?>
						<tr>
							<td class="heightsmalldevices" height="57">&nbsp;</td>
						</tr>
						<tr>
							<td class="tecsb-heading-2  right-left-padding" align="left"
							style="padding: 0 25px;
	font:37px  Arial, Helvetica, sans-serif;
	color:#3a3a3a;"
							>
								<font>
									<?php echo esc_html( $event_title ); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td class="heightsmalldevices" height="27">&nbsp;</td>
						</tr>
						<tr>
							<td class="tecsb-heading-3  right-left-padding" align="left"
							style="padding: 0 25px;
	font:27px  Arial, Helvetica, sans-serif;
	color:#3a3a3a;"
							>
								<font>
									<?php echo esc_html( $event_time ); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td class="heightsmalldevices" height="57">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="<?php echo esc_url( $event_link ); ?>" class="tecsb-email-btn"
								style="text-decoration:none;
								font: 700 14px/35px 'Montserrat', Helvetica, Arial, sans-serif;
	color: #ffffff;
	text-decoration: none;
	text-transform: uppercase;
	display: inline-block;
	overflow: hidden;
	outline: none;
	background: #af5372;
	padding: 10px 30px;
	border-radius: 40px;"
								>
									<?php esc_html_e( 'More Info', 'tecsb' ); ?>
								</a>
							</td>
						</tr>
						<tr>
							<td class="heightsmalldevices" height="57">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="<?php echo esc_url( $manage_link ); ?>"
								style="text-decoration:none;
								font: 300 11px/14px 'Montserrat', Helvetica, Arial, sans-serif;
	color: #af5372;
	text-decoration: none;
	text-transform: uppercase;
	display: inline-block;
	overflow: hidden;
	outline: none;
	padding: 5px 5px;"
								>
									<?php esc_html_e( 'To manage your subscription please click here', 'tecsb' ); ?>
								</a>
							</td>
						</tr>
						<tr>
							<td class="heightsmalldevices" height="57">&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
