<?php
/**
 * Admin class for subscriber plugin
 *
 * @package tecsb
 * @author mokchya
 */
class Tecsb_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'tecsb_admin_script_style' ) );
		add_action( 'admin_menu', array( $this, 'tecsb_set_menu_in_tec' ) );

		add_action( 'admin_init', array( $this, 'tecsb_register_settings' ) );
	}

	/**
	 * Load admin style and script
	 */
	public function tecsb_admin_script_style() {
		global $tecsb;
		wp_enqueue_style( 'tecsb-admin-styles', $tecsb->plugin_url . '/assets/css/tecsb-admin-style.css', array(), $tecsb->version );

		wp_enqueue_style( 'tecsb-icons', $tecsb->plugin_url . '/assets/css/tecsb-icons.css', array(), $tecsb->version );

		wp_enqueue_script( 'tecsb-admin-script', $tecsb->plugin_url . '/assets/js/tecsb-admin-script.js', array( 'jquery' ), $tecsb->version, true );

		$params = array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'tecsb_admin_ajax_nonce' ),
		);
		wp_localize_script( 'tecsb-admin-script', 'tecsb_admin_ajax', $params );
	}

	/**
	 * Set menu to The Event Calendar menu
	 */
	public function tecsb_set_menu_in_tec() {
		add_submenu_page(
			'edit.php?post_type=tribe_events',
			esc_html__( 'Event Subscription in The Event Calendar', 'tecsb' ),
			esc_html__( 'Event Subscription', 'tecsb' ),
			'administrator',
			'tecsb_menu',
			array( $this, 'tecsb_settings_page' )
		);
	}

	/**
	 * Call to Settings Page
	 */
	public function tecsb_settings_page() {
		include 'admin-settings.php';
	}

	/**
	 * Register Settings
	 */
	public function tecsb_register_settings() {
		register_setting( 'tecsb-options', 'tecsb-options', array( $this, 'tecsb_settings_validate' ) );
	}

	/**
	 * Validate user provided options
	 *
	 * @param array $args Arguments.
	 */
	public function tecsb_settings_validate( $args ) {
		return $args;
	}
}
