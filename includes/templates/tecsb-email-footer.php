<?php
/**
 * Email template Footer
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */

$footer_left_default = esc_html__( '© 2020, All rights reserved.', 'tecsb' );
?>
						<table class="tecsb-table-full" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
							<tbody style="word-break: break-word;">
								<tr>
									<td align="center">
										<table class="footer inner-table" cellspacing="0" cellpadding="0" border="0" align="center"
										style="width: 600px;background: #af5372;
											border-radius: 0 0 5px 5px;text-align:center;"
										>
											<tbody style="display:block;">
												<tr>
													<td align="center">
														<table class="footer-blank right-left-padding inner-table" cellspacing="0" cellpadding="0" border="0" align="center"
														style="width: 600px;"
														>
															<tbody style="word-break: break-word;">
																<tr>
																	<td height="20">&nbsp;</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td height="20">
														<div class="footer-full-width"
														style="padding: 0 20px;
	display: block;"
														>
															<span class="footer-text left"
															style="font:11px Helvetica,  Arial, sans-serif;
	color:#FFF;
	float: left;
	padding: 0 6px;"
															>
																<font>
																<?php echo esc_html( $tecsb->function->return_option_value( 'tecsb_footer_left_note', $footer_left_default ) ); ?>
																</font>
															</span>
															<span class="footer-text right"
															style="font:11px Helvetica,  Arial, sans-serif;
	color:#FFF;
	float: right;
	padding: 0 6px;"
															>
																<a style="color:#ffffff; text-decoration:none;" href="<?php echo esc_url( $site_link ); ?>">
																<?php esc_html_e( 'Visit Us', 'tecsb' ); ?>
																</a>
															</span>
														</div>
													</td>
												</tr>
												<tr>
													<td align="center">
														<table class="footer-blank right-left-padding inner-table" cellspacing="0" cellpadding="0" border="0" align="center"
														style="width: 600px;text-align:center;"
														>
															<tbody style="word-break: break-word;">
																<tr>
																	<td height="20">&nbsp;</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<table class="tecsb-table-full" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
							<tbody style="word-break: break-word;">
								<tr>
									<td>
										<table class="padding-twenty" cellspacing="0" cellpadding="0" border="0" align="center">
											<tbody style="word-break: break-word;">
												<tr>
													<td>
														<table class="tecsb-table-full" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
															<tbody style="word-break: break-word;">
																<tr>
																	<td height="64">&nbsp;</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>
