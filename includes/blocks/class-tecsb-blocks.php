<?php
/**
 * Blocks for Subscriber addons
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */
class Tecsb_Blocks {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'tecsb_init_gutenberg_blocks' ) );
	}
	/**
	 * Initialize Block
	 */
	public function tecsb_init_gutenberg_blocks() {
		global $tecsb;
		wp_register_script(
			'tecsb-blocks-editor',
			$tecsb->blocks_path . '/build/index.js',
			array(
				'wp-block-editor',
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-polyfill',
			),
			$tecsb->version,
			true
		);
		wp_set_script_translations( 'tecsb-blocks-editor', 'tecsb' );
		wp_localize_script(
			'tecsb-blocks-editor',
			'tecsb_blocks_config',
			array(
				'themes' => $tecsb->function->tecsb_get_blocks_themes_options(),
			)
		);
		wp_register_style(
			'tecsb-blocks-editor',
			$tecsb->blocks_path . '/build/index.css',
			array(),
			$tecsb->version
		);

		wp_register_style(
			'tecsb_style',
			$tecsb->plugin_url . '/assets/css/tecsb-style.css',
			array(),
			$tecsb->version
		);
		register_block_type(
			'tecsb/subscription-box',
			array(
				'api_version'     => 2,
				'editor_script'   => 'tecsb-blocks-editor',
				'editor_style'    => 'tecsb-blocks-editor',
				'style'           => 'tecsb_style',
				'render_callback' => array( $this, 'tecsb_render_subscription_box_block' ),
				'attributes'      => array(
					'themeSelected' => array(
						'type'    => 'string',
						'default' => '1',
					),
				),
			)
		);
	}
	/**
	 * Display Subscription Box
	 *
	 * @param array $attributes Attriburtes.
	 */
	public function tecsb_render_subscription_box_block( $attributes ) {
		$theme = isset( $attributes['themeSelected'] ) ? $attributes['themeSelected'] : '1';
		global $tecsb;
		$content = $tecsb->frontend->tecsb_generate_sb_box_new_way( $theme );
		return $content;
	}
}
new Tecsb_Blocks();
