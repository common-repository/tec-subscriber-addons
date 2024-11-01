<?php
/**
 * Email template for Verification email
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */

?>
<table class="tecsb-table-full" cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
style="text-align:center;"
>
	<tbody style="word-break: break-word;">
		<tr>
			<td>
				<table class="inner-table center" cellspacing="0" cellpadding="0" border="0" bgcolor="#f8f8f8" align="center"
				style="width: 600px;text-align:center;
						border-bottom:1px solid #e5e5e5;
						border-top: 1px solid #e5e5e5;
						background-color: #f8f8f8;text-align:center;"
				>
					<tbody style="word-break: break-word;">
						<tr>
							<td height="57">&nbsp;</td>
						</tr>
						<tr>
							<td class="tecsb-heading-1"
							style="padding: 0 12px;
	font:700 37px 'Montserrat', Helvetica, Arial, sans-serif;
	color:#f27b69;
	text-transform:uppercase;"
							>
								<font>
								<?php esc_html_e( 'Thank you for subscribing to our calendar', 'tecsb' ); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td height="60">&nbsp;</td>
						</tr>
						<tr>
							<td class="tecsb-heading-4"
							style="padding: 0 6px;
	font:17px  Arial, Helvetica, sans-serif;
	color:#3a3a3a;"
							>
								<font>
									<?php esc_html_e( 'Please click the link below to verify your email address.', 'tecsb' ); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td height="80">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="<?php echo esc_url( $link ); ?>" class="tecsb-email-btn"
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
									<?php esc_html_e( 'Verify Now', 'tecsb' ); ?>
								</a>
							</td>
						</tr>
						<tr>
							<td height="80">&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
