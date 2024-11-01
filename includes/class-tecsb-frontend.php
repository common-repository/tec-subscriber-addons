<?php
/**
 * Frontend Class for Subscriber
 *
 * @author   mokchya
 * @version  1.0.0
 * @package  tecsb
 */
class Tecsb_Frontend {
	/**
	 * Constructor
	 */
	public function __construct() {
		global $tecsb;
		add_action( 'init', array( $this, 'tecsb_temp_save_post' ) );
		$above_ = $tecsb->function->return_check_yesno( 'tecsb_admin_sform_above' );
		$below_ = $tecsb->function->return_check_yesno( 'tecsb_admin_sform_below' );
		if ( 'checked' === $below_ ) {
			add_action( 'tribe_events_before_footer', array( $this, 'tecsb_generate_sb_box_below_cal' ) );
			add_action( 'tribe_template_before_include:events/v2/components/after', array( $this, 'tecsb_generate_sb_box_below_cal' ) );
		}
		if ( 'checked' === $above_ ) {
			add_action( 'tribe_events_before_header', array( $this, 'tecsb_generate_sb_box_below_cal' ) );
			add_action( 'tribe_template_before_include:events/v2/components/before', array( $this, 'tecsb_generate_sb_box_below_cal' ) );
		}
		if ( ! is_admin() ) {
			add_action( 'init', array( $this, 'register_script_style' ) );
			add_filter( 'template_include', array( $this, 'tecsb_template_loader' ), 99 );
		}
	}
	/**
	 * Temporary Save Post for avoiding cache
	 */
	public function tecsb_temp_save_post() {
		if ( class_exists( 'Tribe__Cache' ) ) {
			$tribe_cache = new Tribe__Cache();
			$tribe_cache->set_last_occurrence( 'save_post' );
		}
	}
	/**
	 * Load Template
	 *
	 * @param string $template Template Name.
	 */
	public function tecsb_template_loader( $template = '' ) {
		global $tecsb, $post;
		$file  = '';
		$paths = array(
			0 => get_template_directory() . '/',
			1 => get_template_directory() . '/' . $tecsb->slug . '/templates/subscriber/',
			2 => get_stylesheet_directory() . '/' . $tecsb->slug . '/templates/subscriber/',
			3 => $tecsb->plugin_path . '/includes/templates/',
		);

		$tecsb_subscription_page_id = get_option( 'tecsb_subscription_page_id' );
		if ( is_page( 'tecsb-subscription' ) ) {
			if ( ! empty( $post ) && ! empty( $tecsb_subscription_page_id ) && (int) $post->ID === (int) $tecsb_subscription_page_id ) {
				$file = 'tecsb-subscription.php';
				wp_enqueue_style( 'tecsb_style' );
				wp_enqueue_script( 'tecsb_script' );
			}
		}

		if ( ! empty( $file ) ) {
			foreach ( $paths as $path ) {
				if ( file_exists( $path . $file ) ) {
					$template = $path . $file;
					break;
				}
			}

			if ( ! $template ) {
				$template = $tecsb->plugin_path . '/templates/' . $file;
			}
		}
		return $template;
	}
	/**
	 * Generate Subscriber Box
	 */
	public function tecsb_generate_sb_box_below_cal() {
		global $tecsb;
		$subscribe_text = esc_html__( 'Subscribe', 'tecsb' );
		$category       = $tecsb->function->check_yesno( 'tecsb_admin_category' );
		$theme          = $tecsb->function->return_option_value( 'tecsb_subscription_theme', '1' );
		switch ( $theme ) {
			case '1':
				$theme_class = 'default';
				break;
			case '2':
				$theme_class = 'modern';
				break;
			case '3':
				$theme_class = 'mauve';
				break;
			case '4':
				$theme_class = 'green';
				break;
			case '5':
				$theme_class = 'space';
				break;
			case 'default':
				$theme_class = 'default';
				break;
		}
		?>
		<div class="tecsb_subscribe_box_container <?php echo esc_attr( $theme_class ); ?>">
			<div class='tecsb_subscribe_box' data-category ="<?php echo $category ? 'yes' : 'no'; ?>">
				<div class="tecsb-loading"></div>
				<div class='tecsb_sb_header'>
					<span><?php echo esc_html( $tecsb->function->return_option_value( 'tecsb_header_text', 'Notify Me' ) ); ?></span>
				</div>
				<div class='tecsb_sb_subheader'>
					<span><?php echo esc_html( $tecsb->function->return_option_value( 'tecsb_subheader_text', 'Notify me about any upcomig Events' ) ); ?></span>
				</div>
				<div class="tecsb_sb_msg_box"></div>
				<div class='tecsb_sb_content'>
					<div class="tecsb_form">
						<?php if ( $tecsb->function->check_yesno( 'tecsb_admin_category' ) ) : ?>
						<div class="tecsb_form_select_category">
							<span class=" radius"><?php esc_html_e( 'Select Category', 'tecsb' ); ?></span>
						</div>
						<div class="tecsb_form_category">
							<span class="tecsb_cat_label"><?php esc_html_e( 'Choose cateogire(s)', 'tecsb' ); ?></span>
							<span class="tecsb_cat_info">
								<?php esc_html_e( 'If left empty, all categories will be selected.', 'tecsb' ); ?>
							</span>
							<?php $categories = get_terms( 'tribe_events_cat', array( 'hide_empty' => false ) ); ?>
							<?php $cat_arr = $tecsb->function->tecsb_sort_terms_hierarchicaly( $categories ); ?>
							<?php
							global $tecsb;
							if ( is_array( $cat_arr ) && ! empty( $cat_arr ) ) {
								foreach ( $cat_arr as $cat ) {
									?>
									<p class="tecsb-onoff-switch">
									<?php $status = ''; ?>
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
						<?php endif; ?>
						<div class="tecsb_form_email">
							<input type="email" placeholder="<?php esc_attr_e( 'Your email address', 'tecsb' ); ?>" name="tecsb_email">
							<input type="submit" id="tecsb_subscribe_fe_btn" value="<?php echo esc_html( $subscribe_text ); ?>">
						</div>
					</div>
					<?php if ( false === $tecsb->function->check_empty_option( 'tecsb_admin_pp' ) ) : ?>
					<div class="tecsb_pp_link">
						<a href="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_admin_pp' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'tecsb' ); ?></a> 
					</div>
					<?php endif; ?>
					<?php if ( false === $tecsb->function->check_empty_option( 'tecsb_admin_tou' ) ) : ?>
					<div class="tecsb_tou_link">
						<?php esc_html_e( 'By subscribing, you agree with our ', 'tecsb' ); ?>
						<a href="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_admin_tou' ) ); ?>"><?php esc_html_e( 'Term of Use', 'tecsb' ); ?></a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Returns Plugin Options
	 *
	 * @param string $op_name Option Name.
	 */
	public function tecsb_option( $op_name ) {
		return true;
	}

	/**
	 * Register and enqueue frontend script and style
	 *
	 * @return void
	 */
	public function register_script_style() {
		global $tecsb;
		wp_register_style( 'tecsb_style', $tecsb->plugin_url . '/assets/css/tecsb-style.css', array(), $tecsb->version );
		wp_register_script( 'tecsb_script', $tecsb->plugin_url . '/assets/js/tecsb-script.js', array( 'jquery' ), $tecsb->version, true );
		wp_enqueue_script( 'tecsb_script' );
		wp_enqueue_style( 'tecsb_style' );
		$params = array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'tecsb_ajax_nonce' ),
		);
		wp_localize_script( 'tecsb_script', 'tecsb_ajax', $params );
	}

	/**
	 * Check email already exists
	 *
	 * @param string $email Email address.
	 */
	public function check_email_exists( $email ) {
		$args = array(
			'post_status' => 'publish',
			'post_type'   => 'tecsb-subscriber',
			'meta_query' => array(
				array(
					'key'   => 'tecsb_subscriber_email',
					'value' => $email,

				),
			),
		);
		$query = new WP_Query( $args );
		return ( $query->found_posts > 0 ) ? true : false;
	}
	/**
	 * Check email subscription status
	 *
	 * @param string $email Email address.
	 */
	public function check_email_subscribe_status( $email ) {
		$args = array(
			'post_status' => 'publish',
			'post_type'   => 'tecsb-subscriber',
			'meta_query' => array(
				array(
					'key'   => 'tecsb_subscriber_email',
					'value' => $email,

				),
			),
		);
		$query = new WP_Query( $args );
		if ( $query->found_posts > 0 ) {
			if ( isset( $query->posts[0] ) ) {
				$subscriber = $query->posts[0];
				$spmv       = get_post_custom( $subscriber->ID );
				$status     = ( ! empty( $spmv['tecsb_subscription_status'] ) && 'on' === $spmv['tecsb_subscription_status'][0] ) ? true : false;
				return $status;
			}
		}
		return false;
	}
	/**
	 * Check email subscription status
	 *
	 * @param string $email Email address.
	 */
	public function tecsb_get_subscriber_id( $email ) {
		$args = array(
			'post_status' => 'publish',
			'post_type'   => 'tecsb-subscriber',
			'meta_query' => array(
				array(
					'key'   => 'tecsb_subscriber_email',
					'value' => $email,

				),
			),
		);
		$query = new WP_Query( $args );
		if ( $query->found_posts > 0 ) {
			if ( isset( $query->posts[0] ) ) {
				$subscriber = $query->posts[0];
				return $subscriber->ID;
			}
		}
		return false;
	}
	/**
	 * Check email already exists
	 *
	 * @param string $email Email address.
	 */
	public function subscriber_email_post( $email ) {
		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'tecsb-subscriber',
			'posts_per_page' => 1,
			'meta_query'     => array(
				array(
					'key'   => 'tecsb_subscriber_email',
					'value' => $email,

				),
			),
		);
		$query = new WP_Query( $args );
		return isset( $query->posts[0] ) && ! empty( $query->posts[0] ) ? $query->posts[0] : false;
	}

	/**
	 * Generate Subscriber Box New Way (added for block use as well)
	 *
	 * @param string $theme Theme id.
	 */
	public function tecsb_generate_sb_box_new_way( $theme = '' ) {
		global $tecsb;
		$subscribe_text = esc_html__( 'Subscribe', 'tecsb' );
		$category       = $tecsb->function->check_yesno( 'tecsb_admin_category' );
		$theme          = empty( $theme ) ? $tecsb->function->return_option_value( 'tecsb_subscription_theme', '1' ) : $theme;
		switch ( $theme ) {
			case '1':
				$theme_class = 'default';
				break;
			case '2':
				$theme_class = 'modern';
				break;
			case '3':
				$theme_class = 'mauve';
				break;
			case '4':
				$theme_class = 'green';
				break;
			case '5':
				$theme_class = 'space';
				break;
			case 'default':
				$theme_class = 'default';
				break;
		}
		ob_start();
		?>
		<div class="tecsb_subscribe_box_container tecsb-center-block <?php echo esc_attr( $theme_class ); ?>">
			<div class='tecsb_subscribe_box' data-category ="<?php echo $category ? 'yes' : 'no'; ?>">
				<div class="tecsb-loading"></div>
				<div class='tecsb_sb_header'>
					<span><?php echo esc_html( $tecsb->function->return_option_value( 'tecsb_header_text', 'Notify Me' ) ); ?></span>
				</div>
				<div class='tecsb_sb_subheader'>
					<span><?php echo esc_html( $tecsb->function->return_option_value( 'tecsb_subheader_text', 'Notify me about any upcomig Events' ) ); ?></span>
				</div>
				<div class="tecsb_sb_msg_box"></div>
				<div class='tecsb_sb_content'>
					<div class="tecsb_form">
						<?php if ( $tecsb->function->check_yesno( 'tecsb_admin_category' ) ) : ?>
						<div class="tecsb_form_select_category">
							<span class=" radius"><?php esc_html_e( 'Select Category', 'tecsb' ); ?></span>
						</div>
						<div class="tecsb_form_category">
							<span class="tecsb_cat_label"><?php esc_html_e( 'Choose cateogire(s)', 'tecsb' ); ?></span>
							<span class="tecsb_cat_info">
								<?php esc_html_e( 'If left empty, all categories will be selected.', 'tecsb' ); ?>
							</span>
							<?php $categories = get_terms( 'tribe_events_cat', array( 'hide_empty' => false ) ); ?>
							<?php $cat_arr = $tecsb->function->tecsb_sort_terms_hierarchicaly( $categories ); ?>
							<?php
							global $tecsb;
							if ( is_array( $cat_arr ) && ! empty( $cat_arr ) ) {
								foreach ( $cat_arr as $cat ) {
									?>
									<p class="tecsb-onoff-switch">
									<?php $status = ''; ?>
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
						<?php endif; ?>
						<div class="tecsb_form_email">
							<input type="email" placeholder="<?php esc_attr_e( 'Your email address', 'tecsb' ); ?>" name="tecsb_email">
							<input type="submit" id="tecsb_subscribe_fe_btn" value="<?php echo esc_html( $subscribe_text ); ?>">
						</div>
					</div>
					<?php if ( false === $tecsb->function->check_empty_option( 'tecsb_admin_pp' ) ) : ?>
					<div class="tecsb_pp_link">
						<a href="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_admin_pp' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'tecsb' ); ?></a> 
					</div>
					<?php endif; ?>
					<?php if ( false === $tecsb->function->check_empty_option( 'tecsb_admin_tou' ) ) : ?>
					<div class="tecsb_tou_link">
						<?php esc_html_e( 'By subscribing, you agree with our ', 'tecsb' ); ?>
						<a href="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_admin_tou' ) ); ?>"><?php esc_html_e( 'Term of Use', 'tecsb' ); ?></a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
