<?php
/**
 * Ajax functions for Subscriber
 *
 * @author  mokchya
 * @package tecsb
 * @version 1.0
 */
class Tecsb_Ajax {
	/**
	 * Constructor
	 */
	public function __construct() {
		$ajax_events = array(
			'tecsb_add_subscriber'                 => 'tecsb_add_subscriber',
			'tecsb_generate_subscription_manager'  => 'tecsb_generate_subscription_manager',
			'tecsb_modify_subscription_categories' => 'tecsb_modify_subscription_categories',
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}

	/**
	 * Add Email to Subscriber
	 */
	public function tecsb_add_subscriber() {
		global $tecsb;
		check_ajax_referer( 'tecsb_ajax_nonce', 'tecsb_nonce' );
		if ( isset( $_POST['action'] ) && 'tecsb_add_subscriber' !== $_POST['action'] ) {
			return;
		}
		if ( ! isset( $_POST['email'] ) && empty( $_POST['email'] ) ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Empty email field.', 'tecsb' ),
				)
			);
			exit;
		} else {
			$email      = sanitize_email( wp_unslash( $_POST['email'] ) );
			$categories = isset( $_POST['category'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['category'] ) ) : array();
			$status     = $tecsb->frontend->check_email_subscribe_status( $email );
			if ( $tecsb->frontend->check_email_exists( $email ) && true === $status ) {
				echo wp_json_encode(
					array(
						'status' => 'bad',
						'msg'    => esc_html__( 'Email already exist.', 'tecsb' ),
						'mid'    => 1,
					)
				);
				exit;
			} elseif ( $tecsb->frontend->check_email_exists( $email ) && false === $status ) {
				$subscriber_id = $tecsb->frontend->tecsb_get_subscriber_id( $email );
				update_post_meta( $subscriber_id, 'tecsb_email_verified', 'off' );
				$unique_key = $tecsb->function->tecsb_generate_user_key( $email );
				update_post_meta( $subscriber_id, 'tecsb_user_unique_key', $unique_key );
				// Add Subscriber as SUBSCRIBED as default.
				update_post_meta( $subscriber_id, 'tecsb_subscription_status', 'on' );
				if ( ! empty( $categories ) ) {
					update_post_meta( $subscriber_id, 'tecsb_subs_category', $categories );
				}
				if ( ! is_wp_error( $subscriber_id ) ) {
					$tecsb->email->tecsb_prepare_and_send_email( $email, $subscriber_id, $categories, 'verification', '', '', $unique_key );
					echo wp_json_encode(
						array(
							'status' => 'good',
							'msg'    => esc_html__( 'Subscription updated.', 'tecsb' ),
							'mid'    => 2,
						)
					);
					exit;
				} else {
					echo wp_json_encode(
						array(
							'status' => 'bad',
							'msg'    => esc_html__( 'Something went wrong while subscribing.', 'tecsb' ),
							'mid'    => 3,
						)
					);
					exit;
				}
			} else {
				$status   = $tecsb->function->return_check_yesno( 'tecsb_admin_ssad' );
				$post_arr = array(
					'post_type'    => 'tecsb-subscriber',
					'post_title'   => $email,
					'post_status'  => ( 'checked' === $status ) ? 'draft' : 'publish',
					'author_id'    => 1,
					'post_content' => 'Event Subscriber',
				);
				$post_id  = wp_insert_post( $post_arr );
				update_post_meta( $post_id, 'tecsb_subscriber_email', $email );
				$unique_key = $tecsb->function->tecsb_generate_user_key( $email );
				update_post_meta( $post_id, 'tecsb_user_unique_key', $unique_key );
				// Add Subscriber as SUBSCRIBED as default.
				update_post_meta( $post_id, 'tecsb_subscription_status', 'on' );
				if ( ! empty( $categories ) ) {
					update_post_meta( $post_id, 'tecsb_subs_category', $categories );
				}
				if ( ! is_wp_error( $post_id ) ) {
					$tecsb->email->tecsb_prepare_and_send_email( $email, $post_id, $categories, 'verification', '', '', $unique_key );
					echo wp_json_encode(
						array(
							'status' => 'good',
							'msg'    => esc_html__( 'Subscribed to events.', 'tecsb' ),
							'mid'    => 2,
						)
					);
					exit;
				} else {
					echo wp_json_encode(
						array(
							'status' => 'bad',
							'msg'    => esc_html__( 'Something went wrong while subscribing.', 'tecsb' ),
							'mid'    => 3,
						)
					);
					exit;
				}
			}
		}
	}
	/**
	 * Generate Subscription Manager Content
	 */
	public function tecsb_generate_subscription_manager() {
		global $tecsb;
		check_ajax_referer( 'tecsb_ajax_nonce', 'tecsb_nonce' );
		if ( isset( $_POST['action'] ) && 'tecsb_generate_subscription_manager' !== $_POST['action'] ) {
			return;
		}
		if ( ! isset( $_POST['email'] ) && empty( $_POST['email'] ) ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Empty email field.', 'tecsb' ),
				)
			);
			exit;
		} else {
			$email = sanitize_email( wp_unslash( $_POST['email'] ) );
			if ( ! $tecsb->frontend->check_email_exists( $email ) ) {
				echo wp_json_encode(
					array(
						'status' => 'ede',
						'msg'    => esc_html__( 'Email address doesnot exist.', 'tecsb' ),
					)
				);
				exit;
			} else {
				$subs = $tecsb->frontend->subscriber_email_post( $email );
				if ( $subs ) {
					$subscriber_id = $subs->ID;
					$spmv          = get_post_custom( $subscriber_id );
					$categories    = get_terms( 'tribe_events_cat', array( 'hide_empty' => false ) );
					$cat_arr       = $tecsb->function->tecsb_sort_terms_hierarchicaly( $categories );
					$cat_arr_      = get_post_meta( $subscriber_id, 'tecsb_subs_category' );
					$cat_arr_      = isset( $cat_arr_[0] ) && is_array( $cat_arr_[0] ) ? $cat_arr_[0] : array();

					$unique_key       = isset( $spmv['tecsb_user_unique_key'] ) ? $spmv['tecsb_user_unique_key'][0] : '';
					$unsubscribe_link = $tecsb->email->tecsb_generate_link(
						array(
							'email'      => rawurlencode( $email ),
							'action'     => 'unsubscribe',
							'subscriber' => $subscriber_id,
							'key'        => $unique_key,
						)
					);
					ob_start();
					?>
					<div class="tecsb_manager_modify_form tecsb_form">
						<div class="tecsb_modify_select_category">
							<span><?php esc_html_e( 'Select Category', 'tecsb' ); ?></span>
						</div>
						<div class="tecsb_modify_form_category">
							<span class="tecsb_cat_label"><?php esc_html_e( 'Choose cateogire(s)', 'tecsb' ); ?></span>
							<span class="tecsb_cat_info">
								<?php esc_html_e( 'If left empty, all categories will be selected.', 'tecsb' ); ?>
							</span>
							<?php
							if ( is_array( $cat_arr ) && ! empty( $cat_arr ) ) {
								foreach ( $cat_arr as $cat ) {
									?>
									<p class="tecsb-onoff-switch">
									<?php
									$status = in_array( $cat->slug, $cat_arr_, true ) ? 'checked' : '';
									?>
									<?php $tecsb->function->tecsb_switch_button( $cat->slug, 'default', $status ); ?>
									<span class="label">
										<?php echo esc_html( $cat->name ); ?>
									</span>
									</p>
									<?php
								}
							}
							?>
						</div>
						<div class="tecsb_modify_button">
							<span class="tecsb_modify_subscribe_fe_btn" data-ukey="<?php echo esc_attr( $unique_key ); ?>" data-email="<?php echo esc_attr( $email ); ?>" data-sid="<?php echo esc_attr( $subscriber_id ); ?>">
								<?php esc_html_e( 'Modify Subscription', 'tecsb' ); ?>
							</span>
							<a class="tecsb_modify_unsubscribe_fe_btn" href="<?php echo esc_url( $unsubscribe_link ); ?>">
								<?php esc_html_e( 'Unsubscribe Me', 'tecsb' ); ?>
							</a>
						</div>
					</div>
					<?php
					echo wp_json_encode(
						array(
							'status' => 'good',
							'msg'    => esc_html__( 'Prepare for output.', 'tecsb' ),
							'html'   => ob_get_clean(),
						)
					);
					exit;
				} else {
					echo wp_json_encode(
						array(
							'status' => 'ede',
							'msg'    => esc_html__( 'Email address doesnot exist.', 'tecsb' ),
						)
					);
					exit;
				}
			}
		}
	}
	/**
	 * Modify Subscription Categories
	 */
	public function tecsb_modify_subscription_categories() {
		global $tecsb;
		check_ajax_referer( 'tecsb_ajax_nonce', 'tecsb_nonce' );
		if ( isset( $_POST['action'] ) && 'tecsb_modify_subscription_categories' !== $_POST['action'] ) {
			return;
		}
		if (
			! isset( $_POST['email'] ) && empty( $_POST['email'] )
			||
			! isset( $_POST['ukey'] ) && empty( $_POST['ukey'] )
			) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Some required fields are missing.', 'tecsb' ),
				)
			);
			exit;
		} else {
			$sid        = isset( $_POST['sid'] ) ? sanitize_text_field( wp_unslash( $_POST['sid'] ) ) : '';
			$categories = isset( $_POST['category'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['category'] ) ) : array();
			update_post_meta( $sid, 'tecsb_subs_category', $categories );
			echo wp_json_encode(
				array(
					'status' => 'good',
					'msg'    => esc_html__( 'Categories updated successfully.', 'tecsb' ),
				)
			);
			exit;
		}
	}
}
new Tecsb_Ajax();
