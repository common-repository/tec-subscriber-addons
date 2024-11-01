<?php
/**
 * Helper functions for Subscriber
 *
 * @author  mokchya
 * @package tecsb
 * @version 1.0
 */
class Tecsb_Function {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->options = get_option( 'tecsb-options' );
		add_filter( 'display_post_states', array( $this, 'tecsb_display_post_state_subscriber_page' ), 20, 2 );
	}

	/**
	 * Display Post State for Subscriber page
	 *
	 * @param array   $states Array of all registered states.
	 * @param WP_Post $post   Post object that we can use.
	 */
	public function tecsb_display_post_state_subscriber_page( $states, $post ) {
		if ( 'tecsb-subscription' === $post->post_name ) {
			$states['tecsb-subscribe'] = esc_html__( 'Event Subscription - Tecsb', 'tecsb' );
		}
		return $states;
	}
	/**
	 * Tecsb Switch Button
	 *
	 * @param string $name Input Name.
	 * @param string $theme Theme.
	 * @param string $status Status.
	 */
	public function tecsb_switch_button( $name, $theme, $status ) {
		$allowed = array(
			'span'  => array(
				'class' => array(),
			),
			'input' => array(
				'type'    => array(),
				'name'    => array(),
				'value'   => array(),
				'checked' => array(),
				'id'      => array(),
			),
			'label' => array(
				'class' => array(),
				'for'   => array(),
			),
		);
		$output  = '';
		$output .= '<span class="tecsb-switch-container ' . $theme . '">';
		$output .= '<input name="' . $name . '" type="checkbox" id="' . $name . '" ' . $status . '>';
		$output .= '<label class="tecsb-switch" for="' . $name . '"></label>';
		$output .= '</span>';
		echo wp_kses( $output, $allowed );
	}
	/**
	 * Check checkbox option
	 *
	 * @param string $option_name Tecsb Option name.
	 */
	public function check_yesno( $option_name ) {
		if ( isset( $this->options[ $option_name ] ) && 'on' === $this->options[ $option_name ] ) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Returns checkbox option
	 *
	 * @param string $option_name Tecsb Option name.
	 */
	public function return_check_yesno( $option_name ) {
		if ( isset( $this->options[ $option_name ] ) && 'on' === $this->options[ $option_name ] ) {
			return 'checked';
		} else {
			return '';
		}
	}

	/**
	 * Return Option Values
	 *
	 * @param string $option_name Option name.
	 * @param string $default Default Value.
	 */
	public function return_option_value( $option_name, $default = '' ) {
		if ( isset( $this->options[ $option_name ] ) && ! empty( $this->options[ $option_name ] ) ) {
			return $this->options[ $option_name ];
		} else {
			return $default;
		}
	}

	/**
	 * Generate Category List
	 */
	public function get_category_list_checkbox_arr() {
		global $tecsb;
		$list         = '';
		$parent_terms = get_terms(
			'tribe_events_cat',
			array(
				'hide_empty' => false,
				'parent'     => 0,
			)
		);
		if ( ! is_wp_error( $parent_terms ) ) {
			foreach ( $parent_terms as $parent_term ) {
				$list .= "<input type='checkbox' name='" . $parent_term->slug . "' value='" . $parent_term->term_id . "'>" . $parent_term->name . '</br>';

				$child_terms = get_terms(
					'tribe_events_cat',
					array(
						'hide_empty' => false,
						'parent'     => $parent_term->term_id,
					)
				);
				if ( ! is_wp_error( $child_terms ) ) {
					foreach ( $child_terms as $child_term ) {
						$list .= "<span class='tecsb_cb_space_span'></span>";
						$list .= "<input type='checkbox' name='" . $child_term->slug . "' value='" . $child_term->term_id . "'>" . $child_term->name . '</br>';
					}
				}
			}
		}
		return $list;
	}

	/**
	 * Recursively sort an array of taxonomy terms hierarchically. Child categories will be
	 * placed under a 'children' member of their parent term.
	 *
	 * @param Array   $cats     taxonomy term objects to sort.
	 * @param integer $parent_id the current parent ID to put them in.
	 */
	public function tecsb_sort_terms_hierarchicaly( $cats, $parent_id = 0 ) {
		$into = array();
		foreach ( $cats as $i => $cat ) {
			if ( $cat->parent === $parent_id ) {
				$cat->children         = $this->tecsb_sort_terms_hierarchicaly( $cats, $cat->term_id );
				$into[ $cat->term_id ] = $cat;
			}
		}
		return $into;
	}
	/**
	 * Checks and return if option value is empty
	 *
	 * @param string $option_name Option name.
	 */
	public function check_empty_option( $option_name ) {
		if ( isset( $this->options[ $option_name ] ) && ! empty( $this->options[ $option_name ] ) ) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Crate or return subscription page
	 */
	public function tecsb_subscription_page() {
		global $post, $wpdb;
		$subscription_page = wp_cache_get( "SELECT ID FROM $wpdb->posts WHERE post_name='tecsb-subscription' AND post_status='publish'" );
		if ( empty( $subscription_page ) ) {
			$content = '-- Please Do Not move this page under any page! -- this page is used for The Events Calendar - Subscriber addon -- tecsb / MyWpTrek ';

			return $this->tecsb_create_page(
				'tecsb-subscription',
				'tecsb_subscription_page_id',
				esc_html__( 'Event Subscription', 'tecsb' ),
				$content
			);
		} else {
			return $subscription_page;
		}
	}
	/**
	 * Create page function
	 *
	 * @param string $slug Page Slug.
	 * @param string $option Page Options ID.
	 * @param string $page_title Page Title.
	 * @param string $page_content Page Content.
	 * @param int    $post_parent Parent ID.
	 */
	public function tecsb_create_page( $slug, $option, $page_title, $page_content, $post_parent = 0 ) {
		global $wpdb;
		$page_id = get_option( $option );

		if ( $page_id > 0 ) {
			$page = get_post( $page_id );
			if ( $page && 'publish' === $page->post_status ) {
				return;
			}
		}

		$page_found = wp_cache_get( 'SELECT ID, post_status FROM ' . $wpdb->posts . ' WHERE post_name = ' . $slug . ' LIMIT 1;' );

		if ( isset( $page_found->post_status ) && 'publish' === $page_found->post_status ) {
			if ( $page_id ) {
				update_option( $option, $page_found->ID );
				return $page_found->ID;
			}
		}

		$page_data = array(
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_author'    => 1,
			'post_name'      => $slug,
			'post_title'     => $page_title,
			'post_content'   => $page_content,
			'post_parent'    => $post_parent,
			'comment_status' => 'closed',
		);

		$page_id = wp_insert_post( $page_data );
		$res     = update_option( $option, $page_id );
		return $page_id;
	}
	/**
	 * Generate User Unique Key
	 *
	 * @param string $email Email Address.
	 */
	public function tecsb_generate_user_key( $email ) {
		return md5( time() ) . '-' . md5( $email );
	}
	/**
	 * Check User Key
	 *
	 * @param string $key Unique Key.
	 * @param string $email User Email.
	 */
	public function tecsb_check_user_key( $key, $email ) {
		$args = array(
			'post_type'  => 'tecsb-subscriber',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'   => 'tecsb_user_unique_key',
					'value' => $key,
				),
				array(
					'key'   => 'tecsb_subscriber_email',
					'value' => $email,

				),
			),
		);
		$subscriber = new WP_Query( $args );
		if ( $subscriber->have_posts() ) {
			return true;
		}
		return false;
	}
	/**
	 * Verify User Subscription
	 *
	 * @param string $email Email address.
	 * @param int    $sid Subscriber ID.
	 * @param string $ukey Unique Key.
	 */
	public function tecsb_verify_subscription( $email, $sid, $ukey ) {
		$args = array(
			'p'           => $sid,
			'post_type'   => 'tecsb-subscriber',
			'post_status' => 'published',
			'meta_query'  => array(
				'relation' => 'AND',
				array(
					'key'   => 'tecsb_user_unique_key',
					'value' => $ukey,
				),
				array(
					'key'   => 'tecsb_subscriber_email',
					'value' => $email,

				),
			),
		);
		$subscriber = new WP_Query( $args );
		global $tecsb;
		if ( $subscriber->found_posts > 0 ) {
			update_post_meta( $sid, 'tecsb_email_verified', 'off' );
			$result = update_post_meta( $sid, 'tecsb_email_verified', 'on' );
			if ( $result ) {
				$tecsb->email->tecsb_prepare_and_send_email( $email, $sid, array(), 'confirmation', '', '', $ukey );
			}
			return $result;
		}
		return false;
	}
	/**
	 * Verify Unsubscribe User Subscription
	 *
	 * @param string $email Email address.
	 * @param int    $sid Subscriber ID.
	 * @param string $ukey Unique Key.
	 */
	public function tecsb_unsubscribe_subscription( $email, $sid, $ukey ) {
		$args = array(
			'p'          => $sid,
			'post_type'  => 'tecsb-subscriber',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'   => 'tecsb_user_unique_key',
					'value' => $ukey,
				),
				array(
					'key'   => 'tecsb_subscriber_email',
					'value' => $email,

				),
			),
		);
		$subscriber = new WP_Query( $args );
		global $tecsb;
		if ( $subscriber->have_posts() ) {
			$result = update_post_meta( $sid, 'tecsb_subscription_status', 'off' );
			if ( $result ) {
				$tecsb->email->tecsb_prepare_and_send_email( $email, $sid, array(), 'unsubscribed', '', '', $ukey );
			}
			return $result;
		}
	}
	/**
	 * Generate New Event Email
	 *
	 * @param array $email_list Email List.
	 * @param int   $event_id   Event ID.
	 */
	public function tecsb_send_new_event_email( $email_list, $event_id ) {
		global $tecsb;
		$emails = implode( ', ', $email_list );
		$args   = array(
			'to'   => $emails,
			'type' => 'newevent',
			'demo' => 'none',
			'eid'  => $event_id,
		);
		return $tecsb->email->tecsb_send_email( $args, 'none' );
	}

	/**
	 * Generate Email Content
	 *
	 * @param string $case Condition.
	 */
	public function tecsb_get_email_content( $case ) {
		switch ( $case ) {
			case 'site_link':
				return get_site_url();
			case 'site_brand':
				if ( get_header_image() ) :
					return array(
						'type' => 'image',
						'data' => get_header_image(),
						'name' => get_bloginfo( 'name', 'display' ),
					);
				else :
					return array(
						'type' => 'name',
						'data' => get_bloginfo( 'name', 'display' ),
						'name' => get_bloginfo( 'name', 'display' ),
					);
				endif;
				break;
			case 'default':
				return;
		}
	}
	/**
	 * Get Themes List
	 */
	public function tecsb_get_themes_list() {
		return array(
			'1' => esc_html__( 'Default', 'tecsb' ),
			'2' => esc_html__( 'Modern', 'tecsb' ),
			'3' => esc_html__( 'Mauve', 'tecsb' ),
			'4' => esc_html__( 'Green', 'tecsb' ),
			'5' => esc_html__( 'Space', 'tecsb' ),
		);
	}
	/**
	 * Get Block Editor Themes array
	 */
	public function tecsb_get_blocks_themes_options() {
		$themes  = $this->tecsb_get_themes_list();
		$options = array();
		foreach ( $themes as $value => $label ) {
			$options[] = array(
				'label' => $label,
				'value' => $value,
			);
		}
		return $options;
	}
}
