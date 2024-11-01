<?php
/**
 * Metabox for Event CPT
 *
 * @package tecsb
 * @author mokchya
 */
class Tecsb_Event_Metabox {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'tecsb_add_subscription_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'check_and_send_email' ), 20, 1 );
	}
	/**
	 * Add Role Metabox
	 */
	public function tecsb_add_subscription_meta_boxes() {
		add_meta_box(
			'tecsb_subscription_mb',
			esc_html__( 'Event Subscription', 'tecsb' ),
			array(
				$this,
				'tecsb_subscription_meta_box_content',
			),
			'tribe_events',
			'side',
			'high'
		);
	}
	/**
	 * Metabox Content
	 */
	public function tecsb_subscription_meta_box_content() {
		global $post, $tecsb;
		$event_pmv                 = ( ! empty( $post ) ) ? get_post_custom( $post->ID ) : null;
		$_tescb_email_subscription = ( ! empty( $event_pmv['_tescb_email_subscription'] ) ) ? $event_pmv['_tescb_email_subscription'][0] : null;
		if ( 'yes' === $_tescb_email_subscription ) {
			?>
			<p class='tecsb-notified'>
				<?php esc_html_e( 'Subscriber Notified!', 'tecsb' ); ?>
			</p>
			<?php
		} else {
			wp_nonce_field( 'tecsb_meta_box_nonce', 'meta_box_nonce_tecsb' );
			?>
			<p class="tecsb-onoff-switch">
				<?php $status = ''; ?>
				<?php $tecsb->function->tecsb_switch_button( '_tescb_email_subscription', 'green', $status ); ?>
				<span class="label">
					<?php esc_html_e( 'Email to Subscriber', 'tecsb' ); ?>
				</span>
			</p>
			<?php
		}
	}
	/**
	 * Check and Send email when event created
	 *
	 * @param integer $post_id Post ID.
	 */
	public function check_and_send_email( $post_id ) {
		global $tecsb;
		$post = get_post( $post_id );
		if ( 'tribe_events' !== $post->post_type ) {
			return;
		}

		if ( isset( $post->post_status ) && 'publish' !== $post->post_status ) {
			return;
		}
		if ( ! isset( $_POST['meta_box_nonce_tecsb'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['meta_box_nonce_tecsb'] ) ), 'tecsb_meta_box_nonce' ) ) {
			return;
		}
		if ( ! isset( $_POST['_tescb_email_subscription'] ) ) {
			return;
		}
		if ( 'on' !== $_POST['_tescb_email_subscription'] ) {
			return;
		}

		$subscribers = new WP_Query(
			array(
				'post_type'      => 'tecsb-subscriber',
				'posts_per_page' => -1,
				'post_status'    => 'published',
			)
		);
		$email_list  = array();
		if ( $subscribers->have_posts() ) :
			while ( $subscribers->have_posts() ) :
				$subscribers->the_post();
				$sid      = $subscribers->post->ID;
				$pmv      = get_post_custom( $sid );
				$terms    = get_the_terms( $post_id, 'tribe_events_cat' );
				$verified = ( ! empty( $pmv['tecsb_email_verified'] ) && 'on' === $pmv['tecsb_email_verified'][0] ) ? true : false;
				$status   = ( ! empty( $pmv['tecsb_subscription_status'] ) && 'on' === $pmv['tecsb_subscription_status'][0] ) ? true : false;
				$cat_arr_ = get_post_meta( $sid, 'tecsb_subs_category' );
				$cat_arr_ = isset( $cat_arr_[0] ) && is_array( $cat_arr_[0] ) ? $cat_arr_[0] : array();
				if ( ! $status ) {
					continue;
				}
				if ( ! $verified ) {
					continue;
				}
				if ( empty( $cat_arr_ ) ) {
					if ( isset( $pmv['tecsb_subscriber_email'][0] ) ) {
						$email_list[] = $pmv['tecsb_subscriber_email'][0];
						continue;
					}
				} else {
					if ( $terms && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $tax => $term ) {
							if ( in_array( $term->slug, $cat_arr_, true ) ) {
								$email_list[] = $pmv['tecsb_subscriber_email'][0];
								continue;
							}
						}
					} else {
						continue;
					}
				}
			endwhile;
			wp_reset_postdata();
		endif;
		if ( ! empty( $email_list ) ) {
			$return = $tecsb->function->tecsb_send_new_event_email( $email_list, $post_id );
		}
		// Disabling this for now may needed for future.
		// update_post_meta( $post_id, '_tescb_email_subscription', 'yes' );.
	}
}
new Tecsb_Event_Metabox();
