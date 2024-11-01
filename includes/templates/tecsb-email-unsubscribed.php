<?php
/**
 * Email template for Unsubscription Notification email
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
				<table zp-bg-color="Module-Background" class="full right-left-padding" class="tecsb-table-center" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f8f8f8" align="center">
					<tbody style="word-break: break-word;">
						<tr>
							<td class="heightsmalldevices" height="57">&nbsp;</td>
						</tr>
						<tr>
							<td class="tecsb-heading-4"
							style="padding: 0 6px;
	font:17px  Arial, Helvetica, sans-serif;
	color:#3a3a3a;"
							>
								<font>
								<?php
								printf(
									sprintf( // translators: email address.
										esc_html__( 'Your email (%s) unsubscribed form calendar successfully.', 'tecsb' ),
										esc_html( sanitize_email( $email ) )
									)
								);
								?>
								</font>
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