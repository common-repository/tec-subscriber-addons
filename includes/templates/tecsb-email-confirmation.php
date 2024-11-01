<?php
/**
 * Email template for Confirmation email
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */

?>
<table class="devicewidth" width="600" cellspacing="0" cellpadding="0" border="0" align="center"
style="text-align:center;"
>
	<tbody style="word-break: break-word;">
		<tr>
			<td>
				<table class="full right-left-padding" class="tecsb-table-center" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f8f8f8" align="center"
				style="
				text-align:center;
				background-color: #F8F8F8;
				"
				>
					<tbody style="word-break: break-word;">
						<tr>
							<td class="heightsmalldevices" height="57">&nbsp;</td>
						</tr>
						<tr>
							<td class="tecsb-heading-1" 
							style="padding: 0 12px;
	font:700 37px 'Montserrat', Helvetica, Arial, sans-serif;
	color:#f27b69;
	text-transform:uppercase;"
							>
								<font>
								<?php esc_html_e( 'Your email address has been verified.', 'tecsb' ); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td class="heightSDBottom" height="60">&nbsp;</td>
						</tr>
						<tr>
							<td class="tecsb-heading-4"
							style="padding: 0 6px;
	font:17px  Arial, Helvetica, sans-serif;
	color:#3a3a3a;"
							>
								<font>
									<?php esc_html_e( 'To manage your subscription please follow the link below.', 'tecsb' ); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td class="heightSDBottom" height="80">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="<?php echo esc_url( $link ); ?>" class="tecsb-email-btn"
								style="text-decoration: none;
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
									<?php esc_html_e( 'Subscription Manager', 'tecsb' ); ?>
								</a>
							</td>
						</tr>
						<tr>
							<td class="heightSDBottom" height="80">&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
