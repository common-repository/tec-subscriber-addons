<?php
/**
 * Email functions for Subscriber
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */
class Tecsb_Email {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->options = get_option( 'tecsb-options' );
	}
	/**
	 * Prepare and Send Email
	 *
	 * @param string $email Email Address.
	 * @param int    $subscriber_id Subscriber ID.
	 * @param array  $categories Categories Array.
	 * @param string $type Email Type.
	 * @param string $demo Demo or not.
	 * @param int    $eid Event ID.
	 * @param string $unique_key Unique Key.
	 */
	public function tecsb_prepare_and_send_email( $email, $subscriber_id, $categories, $type, $demo = '', $eid = '', $unique_key = '' ) {
		$args   = array(
			'to'            => $email,
			'type'          => $type,
			'subscriber_id' => $subscriber_id,
			'categories'    => $categories,
			'eid'           => $eid,
			'unique_key'    => $unique_key,
		);
		$return = $this->tecsb_send_email( $args, $demo );
		return $return;
	}
	/**
	 * Send Email
	 *
	 * @param string $args Arguments.
	 * @param string $demo Demo or Not.
	 */
	public function tecsb_send_email( $args, $demo ) {
		global $tecsb;
		$default = array(
			'to'            => '',
			'type'          => 'confirmation',
			'subscriber_id' => '',
			'categories'    => array(),
			'demo'          => $demo,
		);
		$args    = array_merge( $default, $args );

		switch ( $args['type'] ) {
			case 'confirmation':
				$link    = $this->tecsb_generate_link(
					array(
						'email'      => rawurlencode( $args['to'] ),
						'action'     => 'manage',
						'subscriber' => $args['subscriber_id'],
						'key'        => $args['unique_key'],
					)
				);
				$subject = ( ! empty( $this->options['tecsb_email_confirmation_subject'] ) )
					?
						$this->options['tecsb_email_confirmation_subject']
					:
					esc_html__( 'Thank you for subscribing to our site!', 'tecsb' );
				$file    = 'tecsb-email-confirmation';

				$args['link'] = $link;
				break;
			case 'verification':
				$link    = $this->tecsb_generate_link(
					array(
						'email'      => rawurlencode( $args['to'] ),
						'action'     => 'verify',
						'subscriber' => $args['subscriber_id'],
						'key'        => $args['unique_key'],
					)
				);
				$subject = ( ! empty( $this->options['tecsb_email_verification_subject'] ) )
					?
						$this->options['tecsb_email_verification_subject']
					:
						esc_html__( 'Verify your subscription', 'tecsb' );
				$file    = 'tecsb-email-verification';

				$args['link'] = $link;
				break;
			case 'notification':
				$subject = ( ! empty( $this->options['tecsb_email_new_notification_subject'] ) )
					?
						$this->options['tecsb_email_new_notification_subject']
					:
						esc_html__( 'You have a new subscriber!', 'tecsb' );
				$file    = 'tecsb-email-notification';
				break;
			case 'unsubscribed':
				$subject = ( ! empty( $this->options['tecsb_email_notification_subject'] ) )
					?
						$this->options['tecsb_email_notification_subject']
					:
						esc_html__( 'Unsubscribe Confirmation', 'tecsb' );
				$file    = 'tecsb-email-unsubscribed';
				break;
			case 'newevent':
				$manage_link = $this->tecsb_generate_link(
					array(
						'email'  => rawurlencode( $args['to'] ),
						'action' => 'manage',
					)
				);
				$subject = ( ! empty( $this->options['tecsb_email_newevent_subject'] ) )
					?
						$this->options['tecsb_email_newevent_subject']
					:
						esc_html__( 'New Event: {event-name}', 'tecsb' );

				$event_image = false;
				if ( has_post_thumbnail( $args['eid'] ) ) {
					$event_image = wp_get_attachment_image_src( get_post_thumbnail_id( $args['eid'] ), 'full', false );
					if ( is_array( $event_image ) ) {
						$event_image = $event_image[ 0 ];
					}
				}
				$args['manage_link'] = $manage_link;
				$args['event_link']  = ( 'demo' === $args['demo'] ) ? '#' : get_permalink( $args['eid'] );
				$args['event_title'] = ( 'demo' === $args['demo'] ) ? esc_html__( 'Wonderful Day Event', 'tecsb' ) : get_the_title( $args['eid'] );
				$args['event_time']  = ( 'demo' === $args['demo'] ) ? esc_html__( '27 March @ 01:00 PM', 'tecsb' ) : tribe_get_start_date( $args['eid'] );
				$args['event_image'] = ( 'demo' === $args['demo'] ) ? $tecsb->plugin_url . '/includes/templates/demo.jpg' : $event_image;
				$args['eventname']   = $args['event_title'];
				if ( strpos( $subject, '{event-name}' ) !== false ) {
					$subject = str_replace( '{event-name}', html_entity_decode( $args['eventname'] ), $subject );
				}
				$file = 'tecsb-email-newevent';
				break;
			case 'default':
				return;
		}

		if ( empty( $args['to'] ) ) {
			return;
		}
		$args['subject'] = $subject;
		$email_message   = array(
			'to'      => $args['to'],
			'subject' => $subject,
			'message' => stripslashes( $this->tecsb_email_from_template( $file, $args ) ),
			'from'    => $this->tecsb_get_from_info(),
			'type'    => $args['type'],
			'html'    => 'yes',
		);
		if ( 'demo' === $demo ) {
			return $email_message;
		} else {
			return $this->tecsb_deliver_email( $email_message );
		}
	}
	/**
	 * Deliver Email
	 *
	 * @param array $email_message Email Message.
	 */
	public function tecsb_deliver_email( $email_message ) {
		if ( 'yes' === $email_message['html'] ) {
			add_filter( 'wp_mail_content_type', array( $this, 'tecsb_set_html_content_type' ) );
		}
		$headers   = array();
		$headers[] = 'From: ' . $email_message['from'];
		$return    = wp_mail( $email_message['to'], $email_message['subject'], $email_message['message'], $headers );

		if ( 'yes' === $email_message['html'] ) {
			remove_filter( 'wp_mail_content_type', array( $this, 'tecsb_set_html_content_type' ) );
		}

		$ts_mail_errors = array();
		if ( ! $return ) {
			global $ts_mail_errors;
			global $phpmailer;
			if ( ! isset( $ts_mail_errors ) ) {
				$ts_mail_errors = array();
			}

			if ( isset( $phpmailer ) ) {
				$ts_mail_errors[] = $phpmailer->ErrorInfo;
			}
			return array(
				'status' => 'bad',
				'result' => $return,
				'error'  => $ts_mail_errors,
			);
		} else {
			return array(
				'status' => 'good',
				'result' => $return,
			);
		}
	}
	/**
	 * Set HTML Content Type
	 */
	public function tecsb_set_html_content_type() {
		return 'text/html';
	}
	/**
	 * Get From Info
	 */
	public function tecsb_get_from_info() {
		$site_name   = get_bloginfo( 'name' );
		$admin_email = get_option( 'admin_email' );
		$from_name   = isset( $this->options['tecsb_sender_name'] ) && ! empty( $this->options['tecsb_sender_name'] )
			?
			$this->options['tecsb_sender_name']
			:
			$site_name;
		$from_email  = isset( $this->options['tecsb_sender_email'] ) && ! empty( $this->options['tecsb_sender_email'] )
			?
			$this->options['tecsb_sender_email']
			:
			$admin_email;
		return $from_name . ' <' . $from_email . '>';
	}
	/**
	 * Generate email from template
	 *
	 * @param string $file Template file name.
	 * @param array  $args Email Arguments.
	 */
	public function tecsb_email_from_template( $file, $args ) {
		global $tecsb;
		$link        = isset( $args['link'] ) && ! empty( $args['link'] ) ? $args['link'] : '';
		$email       = $args['to'];
		$email_title = $args['subject'];
		ob_start();
		$header   = $this->tecsb_template_loader( 'tecsb-email-header' );
		$footer   = $this->tecsb_template_loader( 'tecsb-email-footer' );
		$template = $this->tecsb_template_loader( $file );
		include_once $header;
		include_once $template;
		include_once $footer;
		return ob_get_clean();
	}
	/**
	 * Generate Link
	 *
	 * @param array $args Link arguments.
	 */
	public function tecsb_generate_link( $args ) {
		global $tecsb;
		$tecsb_subscription_page_id = get_option( 'tecsb_subscription_page_id' );
		if ( empty( $tecsb_subscription_page_id ) ) {
			$tecsb_subscription_page_id = $tecsb->function->tecsb_subscription_page();
		}
		$link   = get_permalink( $tecsb_subscription_page_id );
		$action = $args['action'];
		/* if ( 'manage' === $args['action'] ) {
			return $link . '?action=' . $action;
		} */
		$email      = $args['email'];
		$subscriber = $args['subscriber'];
		$key        = isset( $args['key'] ) ? $args['key'] : '';
		$url        = $link . '?action=' . $action . '&email=' . $email . '&sid=' . $subscriber . '&ukey=' . $key;
		$url        = wp_nonce_url( $url, 'tecsb_nonce' );
		return $url;
	}
	/**
	 * Email Template Loader
	 *
	 * @param string $filename Filename.
	 */
	public function tecsb_template_loader( $filename ) {
		global $tecsb;
		$filename = $filename . '.php';
		$template = $tecsb->plugin_path . '/includes/templates/' . $filename;
		return $template;
	}
}
