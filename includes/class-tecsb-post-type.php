<?php
/**
 * Register Post Types and Taxonomies
 *
 * @author  mokchya
 * @package tecsb
 */
class Tecsb_Post_Types {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_tecsb_subscriber_post_type' ), 5 );
		if ( is_admin() ) {
			add_filter( 'manage_edit-tecsb-subscriber_sortable_columns', array( $this, 'tecsb_subscriber_sort' ) );
			add_action( 'manage_tecsb-subscriber_posts_custom_column', array( $this, 'tecsb_custom_event_columns' ), 2 );
			add_filter( 'manage_edit-tecsb-subscriber_columns', array( $this, 'tecsb_edit_event_columns' ) );
			add_filter( 'request', array( $this, 'tecsb_editorder_column' ) );
		}
		add_action( 'add_meta_boxes', array( $this, 'tecsb_add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'tecsb_save_post_meta' ), 10, 2 );
	}

	/**
	 * Register Custom Post Type
	 */
	public function register_tecsb_subscriber_post_type() {
		$labels = array(
			'name'               => _x( 'Subscribers', 'post type general name', 'tecsb' ),
			'singular_name'      => _x( 'Subscriber', 'post type singular name', 'tecsb' ),
			'add_new'            => esc_html__( 'Add New Subscriber', 'tecsb' ),
			'add_new_item'       => esc_html__( 'Add New Subscriber', 'tecsb' ),
			'edit_item'          => esc_html__( 'Edit Subscriber', 'tecsb' ),
			'new_item'           => esc_html__( 'New Subscriber', 'tecsb' ),
			'all_items'          => esc_html__( 'All Subscribers', 'tecsb' ),
			'view_item'          => esc_html__( 'View Subscriber', 'tecsb' ),
			'search_items'       => esc_html__( 'Search Subscribers', 'tecsb' ),
			'not_found'          => esc_html__( 'No Subscribers found', 'tecsb' ),
			'not_found_in_trash' => esc_html__( 'No Subscribers found in Trash', 'tecsb' ),
			'parent_item_colon'  => '',
			'menu_name'          => _x( 'Subscribers', 'admin menu', 'tecsb' ),
		);
		register_post_type(
			'tecsb-subscriber',
			array(
				'labels'             => $labels,
				'description'        => esc_html__( 'Subscribers for The Event Calendar', 'tecsb' ),
				'public'             => true,
				'show_ui'            => true,
				'map_meta_cap'       => true,
				'publicly_queryable' => false,
				'hierarchical'       => false,
				'query_var'          => true,
				'supports'           => array( 'title' ),
				'menu_position'      => 8,
				'show_in_menu'       => 'edit.php?post_type=tribe_events',
				'has_archive'        => true,
			)
		);
	}
	/**
	 * Add Meta Box
	 */
	public function tecsb_add_meta_boxes() {
		add_meta_box(
			'tecsb_metaboxes',
			esc_html__( 'The Event Calendar Subscriber', 'tecsb' ),
			array( $this, 'tecsb_metaboxes_content' ),
			'tecsb-subscriber',
			'normal',
			'high'
		);
	}
	/**
	 * MetaBox Content
	 */
	public function tecsb_metaboxes_content() {
		global $post, $tecsb;
		$spmv       = get_post_custom( $post->ID );
		$categories = get_terms( 'tribe_events_cat', array( 'hide_empty' => false ) );
		$cat_arr    = $tecsb->function->tecsb_sort_terms_hierarchicaly( $categories );
		$email      = isset( $spmv['tecsb_subscriber_email'] ) ? $spmv['tecsb_subscriber_email'][0] : '';
		$status     = isset( $spmv['tecsb_subscription_status'] ) ? $spmv['tecsb_subscription_status'][0] : '';
		$verified   = isset( $spmv['tecsb_email_verified'] ) ? $spmv['tecsb_email_verified'][0] : '';
		$key        = isset( $spmv['tecsb_user_unique_key'] ) ? $spmv['tecsb_user_unique_key'][0] : '';
		$cat_arr_   = get_post_meta( $post->ID, 'tecsb_subs_category' );
		$cat_arr_   = isset( $cat_arr_[0] ) && is_array( $cat_arr_[0] ) ? $cat_arr_[0] : array();
		?>
		<div class='tecsb-mb'>
			<div class='tecsb-mb-wrapper'>
				<div class='tecsb-mb-container'>
					<?php wp_nonce_field( 'tecsb_meta_box_nonce', 'meta_box_nonce_tecsb' ); ?>
					<table width='100%' class='tecsb-metabox-table' cellspacing="" style='vertical-align:top' valign='top'>
						<tr>
							<td>
								<?php esc_html_e( 'Email Address', 'tecsb' ); ?>
							</td>
							<td>
								<input type='text' name='tecsb_subscriber_email' value='<?php echo esc_attr( sanitize_email( $email ) ); ?>' readonly/>
							</td>
						</tr>
						<tr>
							<td>
								<?php esc_html_e( 'Unique Key', 'tecsb' ); ?>
							</td>
							<td>
								<input type='text' name='tecsb_user_unique_key' value='<?php echo esc_attr( $key ); ?>' readonly/>
							</td>
						</tr>
						<tr>
							<td>
								<?php esc_html_e( 'Subscrition Status', 'tecsb' ); ?>
							</td>
							<td>
								<?php $tecsb->function->tecsb_switch_button( 'tecsb_subscription_status', 'green', 'on' === $status ? 'checked' : '' ); ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php esc_html_e( 'Email Verified', 'tecsb' ); ?>
							</td>
							<td>
								<?php $tecsb->function->tecsb_switch_button( 'tecsb_email_verified', 'green', 'on' === $verified ? 'checked' : '' ); ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="tecsb-bold">
								<?php esc_html_e( 'Categories subscribed to', 'tecsb' ); ?>
							</td>
						</tr>
						<?php
						if ( is_array( $cat_arr ) && ! empty( $cat_arr ) ) :
							foreach ( $cat_arr as $cat ) :
								?>
						<tr>
							<td>
								<?php echo esc_html( $cat->name ); ?>
							</td>
							<td>
								<?php $tecsb->function->tecsb_switch_button( 'tecsb_subs_category[' . $cat->slug . ']', 'green', in_array( $cat->slug, $cat_arr_, true ) ? 'checked' : '' ); ?>
							</td>
						</tr>
								<?php
							endforeach;
						endif;
						?>
					</table>
				</div>
			</div>
		</div>
		<?php
	}
	/**
	 * Save MetaData
	 *
	 * @param integer $post_id Post ID.
	 * @param WP_Post $post WP Post.
	 */
	public function tecsb_save_post_meta( $post_id, $post ) {
		global $tecsb;
		if ( 'tecsb-subscriber' !== $post->post_type ) {
			return;
		}
		if ( ! isset( $_POST['meta_box_nonce_tecsb'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['meta_box_nonce_tecsb'] ) ), 'tecsb_meta_box_nonce' ) ) {
			return;
		}
		$fields = array(
			'tecsb_subscriber_email',
			'tecsb_subscription_status',
			'tecsb_email_verified',
			'tecsb_subs_category',
			'tecsb_unique_user_key',
		);
		foreach ( $fields as $field ) {
			if ( 'tecsb_subs_category' === $field ) {
				if ( ! empty( $_POST[ $field ] ) && is_array( $_POST[ $field ] ) ) {
					$category = array();
					$_post    = isset( $_POST[ $field ] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST[ $field ] ) ) : array();
					foreach ( $_post as $index => $value ) {
						if ( 'on' === $value ) {
							$category[] = $index;
						}
					}
					update_post_meta( $post_id, $field, $category );
				}
			} elseif ( 'tecsb_subscriber_email' === $field ) {
				$email = isset( $_POST['tecsb_subscriber_email'] ) ? sanitize_email( wp_unslash( $_POST['tecsb_subscriber_email'] ) ) : '';
				update_post_meta( $post_id, $field, $email );
			} elseif ( 'tecsb_unique_user_key' === $field ) {
				$email      = isset( $_POST['tecsb_subscriber_email'] ) ? sanitize_email( wp_unslash( $_POST['tecsb_subscriber_email'] ) ) : '';
				$unique_key = $tecsb->function->tecsb_generate_user_key( $email );
				update_post_meta( $post_id, $field, $unique_key );
			} else {
				if ( ! empty( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
				} elseif ( empty( $_POST[ $field ] ) ) {
					delete_post_meta( $post_id, $field );
				}
			}
		}
	}
	/**
	 * Make Subscriber columns sortable
	 *
	 * @param array $columns Default Columns.
	 */
	public function tecsb_subscriber_sort( $columns ) {
		$custom = array(
			'subscribed' => 'subscribed',
			'verified'   => 'verified',
		);
		return wp_parse_args( $custom, $columns );
	}
	/**
	 * Custom Column
	 *
	 * @param array $column Default Columns.
	 */
	public function tecsb_custom_event_columns( $column ) {
		global $post;
		$spmv = get_post_custom( $post->ID );
		switch ( $column ) {
			case 'subscribed':
				$link   = wp_nonce_url( admin_url( 'admin-ajax.php?action=tecsb_toggle_activation&sid=' . $post->ID ), 'tecsb_toggle_activation' );
				$output = ( ! empty( $spmv['tecsb_subscription_status'] ) && 'on' === $spmv['tecsb_subscription_status'][0] ) ?
					'<a href="' . $link . '"><span class="tecsb_column_active">' . esc_html__( 'Subscribed', 'tecsb' ) . '</span></a>' :
					'<a href="' . $link . '"><span class="tecsb_column_inactive">' . esc_html__( 'Unsubscribed', 'tecsb' ) . '</span></a>';
				echo wp_kses(
					$output,
					array(
						'a'    => array(
							'href' => array(),
						),
						'span' => array(
							'class' => array(),
						),
					)
				);
				break;
			case 'verified':
				$output = ( ! empty( $spmv['tecsb_email_verified'] ) && 'on' === $spmv['tecsb_email_verified'][0] ) ?
					'<span class="tecsb_column_active">' . esc_html__( 'Verified', 'tecsb' ) . '</span>' :
					'<span class="tecsb_column_inactive">' . esc_html__( 'Not-Verified', 'tecsb' ) . '</span>';
				echo wp_kses(
					$output,
					array(
						'a'    => array(
							'href' => array(),
						),
						'span' => array(
							'class' => array(),
						),
					)
				);
				break;
		}
	}
	/**
	 * Tecsb Columns
	 *
	 * @param array $existing_columns Existing Columns.
	 */
	public function tecsb_edit_event_columns( $existing_columns ) {
		if ( empty( $existing_columns ) && ! is_array( $existing_columns ) ) {
			$existing_columns = array();
		}
		unset( $existing_columns['title'], $existing_columns['comments'], $existing_columns['date'] );

		$columns               = array();
		$columns['cb']         = '<input type="checkbox" />';
		$columns['title']      = esc_html__( 'Title', 'tecsb' );
		$columns['subscribed'] = esc_html__( 'Subscribe Status', 'tecsb' );
		$columns['verified']   = esc_html__( 'Verified Status', 'tecsb' );
		$columns['date']       = esc_html__( 'Date', 'tecsb' );

		return array_merge( $columns, $existing_columns );
	}
	/**
	 * Editorder Columns
	 *
	 * @param array $vars Default Vars.
	 */
	public function tecsb_editorder_column( $vars ) {
		if ( 'tecsb-subscriber' !== $vars['post_type'] ) {
			return $vars;
		}

		if ( isset( $vars['orderby'] ) ) {
			if ( 'subscribed' === $vars['orderby'] ) {
				$vars = array_merge(
					$vars,
					array(
						'meta_key' => 'subscribed',
						'orderby'  => 'meta_value',
					)
				);
			}
			if ( 'verified' === $vars['orderby'] ) {
				$vars = array_merge(
					$vars,
					array(
						'meta_key' => 'verified',
						'orderby'  => 'meta_value',
					)
				);
			}
		}
		return $vars;
	}
}
new Tecsb_Post_Types();
