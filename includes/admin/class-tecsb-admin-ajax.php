<?php
/**
 * Admin AJAX Functions
 *
 * @author  mokchya
 * @package tecsb
 */
class Tecsb_Admin_Ajax {
	/**
	 * Constructer
	 */
	public function __construct() {
		$ajax_events = array(
			'save_tecsb_options'                 => 'save_tecsb_options',
			'tecsb_generate_email_preview_admin' => 'tecsb_generate_email_preview_admin',
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}

	/**
	 * Generate Email Preview Content
	 */
	public function tecsb_generate_email_preview_admin() {
		global $tecsb;
		$res = check_ajax_referer( 'tecsb_admin_ajax_nonce', 'tecsb_nonce' );
		if ( isset( $_POST['action'] ) && 'tecsb_generate_email_preview_admin' !== $_POST['action'] ) {
			return;
		}
		$email_type = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : 'verification';
		$content    = $tecsb->email->tecsb_prepare_and_send_email( 'demo@mywptrek.com', 0, array(), $email_type, 'demo', '' );
		echo wp_json_encode(
			array(
				'status'  => 'good',
				'content' => $content,
			)
		);
		exit;
	}
	/**
	 * Save Options
	 */
	public function save_tecsb_options() {
		global $tecsb;
		$res = check_ajax_referer( 'tecsb_admin_ajax_nonce', 'tecsb_nonce' );
		if ( isset( $_POST['action'] ) && 'save_tecsb_options' !== $_POST['action'] ) {
			return;
		}
		$fields  = array(
			'tecsb_admin_ssad',
			'tecsb_admin_olu',
			'tecsb_admin_sform_above',
			'tecsb_admin_sform_below',
			'tecsb_admin_sform_popup',
			'tecsb_admin_pp',
			'tecsb_admin_tou',
			'tecsb_admin_uninstall',
			'tecsb_sender_name',
			'tecsb_sender_email',
			'tecsb_verification_subject',
			'tecsb_confirmation_subject',
			'tecsb_notification_subject',
			'tecsb_newevent_subject',
			'tecsb_admin_category',
			'tecsb_header_text',
			'tecsb_subheader_text',
			'tecsb_subscription_theme',
			'tecsb_footer_left_note',
			'tecsb_newevent_header',
		);
		$options = array();
		$data    = array();
		foreach ( $fields as $field ) {
			if ( 'tecsb_sender_email' === $field ) {
				$data[ $field ] = isset( $_POST['data'][ $field ] ) ? sanitize_email( wp_unslash( $_POST['data'][ $field ] ) ) : '';
			} elseif ( 'tecsb_admin_pp' === $field || 'tecsb_admin_tou' === $field ) {
				$data[ $field ] = isset( $_POST['data'][ $field ] ) ? esc_url_raw( wp_unslash( $_POST['data'][ $field ] ) ) : '';
			} else {
				$data[ $field ] = isset( $_POST['data'][ $field ] ) ? sanitize_text_field( wp_unslash( $_POST['data'][ $field ] ) ) : '';
			}
			$options[ $field ] = isset( $data[ $field ] ) ? $data[ $field ] : '';
		}
		update_option( 'tecsb-options', $options );
	}
}
new Tecsb_Admin_ajax();
