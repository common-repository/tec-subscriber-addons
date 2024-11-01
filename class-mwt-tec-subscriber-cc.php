<?php
/**
 * Plugin Name: Subscriber Addons for The Events Calendar
 * Plugin URI: http://tecsb.mywptrek.com
 * Description: Subscribe to all calendar events
 * Author: MyWpTrek
 * Text Domain: tecsb
 * Domain Path: /languages
 * Version: 2.0.2
 * Author URI: http://www.mywptrek.com/profile
 * Requires at least: 5.0
 * Tested up to: 5.8.2
 */

if ( ! function_exists( 'tsa_fs' ) ) {
	/**
	 * Create a helper function for easy SDK access.
	 */
	function tsa_fs() {
		global $tsa_fs;

		if ( ! isset( $tsa_fs ) ) {
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/freemius/start.php';

			$tsa_fs = fs_dynamic_init(
				array(
					'id'             => '9470',
					'slug'           => 'tec-subscriber-addons',
					'type'           => 'plugin',
					'public_key'     => 'pk_fbc1e3159726aea904f5199e3eb3b',
					'is_premium'     => false,
					'has_addons'     => false,
					'has_paid_plans' => false,
					'menu'                => array(
						'slug'    => 'tecsb_menu',
						'account' => false,
						'support' => true,
						'parent'  => array(
							'slug' => 'edit.php?post_type=tribe_events',
						),
					),
				)
			);
		}

		return $tsa_fs;
	}

	// Init Freemius.
	tsa_fs();
	// Signal that SDK was initiated.
	do_action( 'tsa_fs_loaded' );
}
/**
 * Main Class for Plugin
 */
class MWT_Tec_Subscriber_FM {
	/**
	 * Plugin Version
	 *
	 * @var string
	 */
	public $version = '2.0.2';
	/**
	 * Event Calendar Version
	 *
	 * @var string
	 */
	public $tec_version = '5.1.2';
	/**
	 * Plugin Name
	 *
	 * @var string
	 */
	public $name = 'Subscriber Addons for The Events Calendar';
	/**
	 * Plugin Slug
	 *
	 * @var string
	 */
	public $slug = 'tecsb';
	/**
	 * Halt plugin load
	 *
	 * @var boolean
	 */
	public $halt = false;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->super_init();
		$this->options = get_option( 'tecsb-options' );
		add_action( 'plugins_loaded', array( $this, 'tecsb_plugins_loaded' ) );
		add_action( 'init', array( $this, 'tecsb_init' ) );
	}
	/**
	 * Check if compatible with.
	 */
	public function tecsb_check_plugins() {
		if ( class_exists( 'MWT_Tec_Subscriber' ) ) {
			add_action( 'admin_notices', array( $this, 'tecsb_already_exist_notice' ) );
			return true;
		}
		return false;
	}
	/**
	 * If older plugin already installed
	 */
	public function tecsb_already_exist_notice() {
		?>
		<div class="message error">
			<p>
				<?php
				esc_html_e( 'Seems like older version of plugin already activated. Please deactivate it, some conflict may arise if you try to run both.', 'tecsb' );
				?>
			</p>
		</div>
		<?php
	}
	/**
	 * Init
	 */
	public function tecsb_init() {
		add_action( 'wp_loaded', array( $this, 'tecsb_subscription_page_loaded' ) );
	}
	/**
	 * Super Initialization
	 */
	public function super_init() {
		$this->plugin_url  = path_join( WP_PLUGIN_URL, basename( dirname( __FILE__ ) ) );
		$this->plugin_slug = plugin_basename( __FILE__ );
		$this->plugin_path = dirname( __FILE__ );
		$this->blocks_path = $this->plugin_url . '/includes/blocks';
	}

	/**
	 * Plugin Initialization
	 */
	public function tecsb_plugins_loaded() {
		if ( $this->tecsb_check_plugins() ) {
			return;
		}

		include_once $this->plugin_path . '/includes/class-tecsb-post-type.php';
		include_once $this->plugin_path . '/includes/class-tecsb-frontend.php';
		include_once $this->plugin_path . '/includes/class-tecsb-function.php';
		include_once $this->plugin_path . '/includes/class-tecsb-email.php';
		include_once $this->plugin_path . '/includes/blocks/class-tecsb-blocks.php';

		$this->function = new Tecsb_Function();
		$this->frontend = new Tecsb_Frontend();
		$this->email    = new Tecsb_Email();

		if ( is_admin() ) {
			include_once $this->plugin_path . '/includes/admin/class-tecsb-admin-init.php';
			include_once $this->plugin_path . '/includes/admin/class-tecsb-admin-ajax.php';
			include_once $this->plugin_path . '/includes/admin/class-tecsb-event-metabox.php';
			$this->admin = new Tecsb_Admin_Init();
		}

		if ( defined( 'DOING_AJAX' ) ) {
			include_once $this->plugin_path . '/includes/class-tecsb-ajax.php';
		}
	}
	/**
	 * Add Subscription Page after Loaded
	 */
	public function tecsb_subscription_page_loaded() {
		if ( $this->tecsb_check_plugins() ) {
			return;
		}
		$this->tecsb_subcription_pages();
	}
	/**
	 * Install Pages needed for Subscription addon
	 */
	public function tecsb_subcription_pages() {
		$page_id = $this->function->tecsb_subscription_page();
	}
}
$GLOBALS['tecsb'] = new MWT_Tec_Subscriber_FM();
