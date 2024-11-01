<?php
/**
 * Email template Header
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */

$site_link  = $tecsb->function->tecsb_get_email_content( 'site_link' );
$site_brand = $tecsb->function->tecsb_get_email_content( 'site_brand' );
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0;">
		<meta name="format-detection" content="telephone=no"/>
		<title><?php echo esc_html( $email_title ); ?></title>
	</head>
	<body
		topmargin="0"
		rightmargin="0"
		bottommargin="0"
		leftmargin="0"
		marginwidth="0"
		marginheight="0"
		width="100%"
		text="#000000">
		<table cellspacing="0" cellpadding="0" border="0" align="center"
		style="border-collapse: collapse;
				border-spacing: 0;
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				-webkit-font-smoothing: antialiased;
				text-size-adjust: 100%;
				-ms-text-size-adjust: 100%;
				-webkit-text-size-adjust: 100%;
				line-height: 100%;
				color: #000000;
				background-color: #CECECE;
				background: #CECECE;
				position:relative;"
		>
			<tbody style="word-break: break-word;">
				<tr>
					<td style="padding: 8px;">
						<table class="tecsb-table-full-" width="100%" cellspacing="0" cellpadding="0" border="0" align="center"
							style=""
						>
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
						<table class="tecsb-table-full-" cellspacing="0" cellpadding="0" border="0" align="center" width="600">
							<tbody style="word-break: break-word;width: 600px;">
								<tr>
									<td align="center">
										<table cellspacing="0" cellpadding="0" width="100%" border="0" align="center"
										style="
												background: #FFFFFF;
												background-color: #FFFFFF;
												border-radius: 5px 5px 0 0;"
										>
											<tbody style="word-break: break-word;width: 100%;">
												<tr>
													<td height="40">&nbsp;</td>
												</tr>
												<tr>
													<td valign="middle" align="center">
														<a href="<?php echo esc_url( $site_link ); ?>"  
														style="width: 100%;
														margin-left: 12px;
														text-decoration:none;
														font:700 37px  Arial, Helvetica, sans-serif;
														line-height: 30px;
														color:#232823;
														"
														>
															<h2 style="line-height: 3.2rem;">
															<?php if ( 'image' === $site_brand['type'] ) { ?> 
																<img src="<?php echo esc_attr( $site_brand['data'] ); ?>" alt="<?php echo esc_attr( $site_brand['name'] ); ?>" style="max-height:300px;"/>
															<?php } else { ?>
																<?php echo esc_html( $site_brand['name'] ); ?>
															<?php } ?>
															</h2>
														</a>
													</td>
												</tr>
												<tr>
													<td height="40">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
