<?php
/**
 * Uninstall Options for The Events Calendar - Subscriber Addons
 *
 * @author  mokchya
 * @package tecsb
 * @since v0.1
 */

if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	$option = get_option( 'tecsb-options' );

	if ( 'on' === $option['tecsb_admin_uninstall'] ) {
		delete_option( 'tecsb-options' );
	}
}
