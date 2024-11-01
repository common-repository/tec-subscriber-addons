<?php
/**
 * Email template Styles
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */

?>
<style>
.ReadMsgBody {
	width: 100%;
	background-color: #cecece;
}

.ExternalClass {
	width: 100%;
	background-color: #cecece;
}
html {
	width: 100%
}
body table.tecsb-email-table{
	border-collapse: collapse;
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
	/* background-color: #cecece; */
	color: #000000;
}
table.tecsb-email-table{
	width: 100%;
	background-color: #cecece;
	margin: 0;
	padding: 0;
	position: relative;
}
table.tecsb-email-table table tbody{
	word-break: break-word;
}
table.tecsb-email-table a {
	text-decoration: none;
}
table.tecsb-email-table h1{
	font:700 37px  Arial, Helvetica, sans-serif;
	line-height: 30px;
}
table.tecsb-table-full{
	width: 100%;
}
table.tecsb-email-table table.inner-table{
	width: 600px;
}
table.tecsb-email-table table.header{
	background: #FFF;
	border-radius: 5px 5px 0 0;
}
table.tecsb-email-table table.center{
	text-align:center;
	border-bottom:1px solid #e5e5e5;
	border-top: 1px solid #e5e5e5;
	background-color: #f8f8f8;
}
table.tecsb-email-table table.footer{
	background: #af5372;
	border-radius: 0 0 5px 5px;
}
table.tecsb-email-table td.tecsb-heading-1{
	padding: 0 12px;
	font:700 37px 'Montserrat', Helvetica, Arial, sans-serif;
	color:#f27b69;
	text-transform:uppercase;
}
table.tecsb-email-table td.tecsb-heading-2{
	padding: 0 6px;
	font:37px  Arial, Helvetica, sans-serif;
	color:#3a3a3a;
}
table.tecsb-email-table td.tecsb-heading-3{
	padding: 0 6px;
	font:27px  Arial, Helvetica, sans-serif;
	color:#3a3a3a;
}
table.tecsb-email-table td.tecsb-heading-4{
	padding: 0 6px;
	font:17px  Arial, Helvetica, sans-serif;
	color:#3a3a3a;
}
table.tecsb-email-table .tecsb-email-btn{
	font: 700 14px/35px 'Montserrat', Helvetica, Arial, sans-serif;
	color: #ffffff;
	text-decoration: none;
	text-transform: uppercase;
	display: inline-block;
	overflow: hidden;
	outline: none;
	background: #af5372;
	padding: 10px 30px;
	border-radius: 40px;
}
table.tecsb-email-table .tecsb-email-btn:hover{
	text-decoration: none;
	opacity: 0.8;
	color: #FFF;
}
table.tecsb-email-table .footer-full-width{
	padding: 0 20px;
	display: block;
}
table.tecsb-email-table .footer-text{
	font:11px Helvetica,  Arial, sans-serif;
	color:#FFF;
}
table.tecsb-email-table .footer-text.right{
	float: right;
	padding: 0 6px;
}
table.tecsb-email-table .footer-text.left{
	float: left;
	padding: 0 6px;
}
@media only screen and (max-width:768px) {
	table.tecsb-table-full{
		margin: 0 10px 0 10px;
		width: 95%;
	}
}
</style>
