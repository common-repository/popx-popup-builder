<?php
/*
Plugin Name:  PopX - Popup Builder
Plugin URI:   https://wpmobo.com/popx
Description:  PopX is a versatile WordPress popup builder, allowing users to create and customize engaging popups effortlessly.
Version:      1.0.1
Author:       WPMobo
Author URI:   https://wpmobo.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  popx-popup-builder
Domain Path:  /languages
*/


// Block Direct access
if( !defined( 'ABSPATH' ) ){ die( 'You should not access this file directly!.' ); }

// Define Plugin Version.
if( !defined( 'POPX_VERSION' ) )
	define( 'POPX_VERSION', '1.0.1' );

// Define Constants for direct access alert message.
if( !defined( 'POPX_ALERT_MSG' ) )
	define( 'POPX_ALERT_MSG', esc_html__( 'You should not access this file directly.!', 'popx-popup-builder' ) );

// Define constants for plugin directory path.
if( !defined( 'POPX_DIR_PATH' ) )
	define( 'POPX_DIR_PATH', plugin_dir_path( __FILE__ ) );

// Define constants for plugin dirname.
if( !defined( 'POPX_DIR_NAME' ) )
	define( 'POPX_DIR_NAME', dirname( __FILE__ ) );

// Define constants for plugin directory path.
if( !defined( 'POPX_DIR_URL' ) )
	define( 'POPX_DIR_URL', plugin_dir_url( __FILE__ ) );

// Define constants for plugin basenam.
if( !defined( 'POPX_BASENAME' ) )
	define( 'POPX_BASENAME', plugin_basename( __FILE__ ) );

require_once POPX_DIR_PATH.'vendor/autoload.php';

final class Popx {

	private static $instance = null;

	private function __construct() {
		$this->client_insights();
		$this->includeFiles();
		$this->init();
	}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function init() {
		
		//
		add_filter( 'plugin_action_links', [ $this, 'add_plugin_link' ], 10, 2 );
		add_filter( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_ajax_render_popx_popup', [__CLASS__, 'render_popx_popup' ] );
        add_action( 'wp_ajax_nopriv_render_popx_popup', [ __CLASS__, 'render_popx_popup' ] );

	}

	public static function render_popx_popup() {

		$pages = [
			'page_id' => !empty( $_POST['page_id'] ) ? absint( sanitize_text_field( $_POST['page_id'] ) ) : '',
			'is_shop' => !empty( $_POST['is_shop'] ) ? esc_html( sanitize_text_field( $_POST['is_shop'] ) ) : '',
			'is_front_page' => !empty( $_POST['is_front_page'] ) ? esc_html( sanitize_text_field( $_POST['is_front_page'] ) ) : '',
			'is_home' => !empty( $_POST['is_home'] ) ? esc_html( sanitize_text_field( $_POST['is_home'] ) ) : '',
			'is_single_archive' => !empty( $_POST['is_single_archive'] ) ? esc_html( sanitize_text_field( $_POST['is_single_archive'] ) ) : ''
		];

        \Popx\Popx_Base::popup_html_one( $pages );

        wp_die();
    }

	private function includeFiles() {
		require_once POPX_DIR_PATH . 'inc/Helper.php';
		require_once POPX_DIR_PATH . 'inc/WP_Hooks.php';
		require_once POPX_DIR_PATH . 'classes/Post_Type_Base.php';
		require_once POPX_DIR_PATH . 'classes/Meta_Base.php';
		require_once POPX_DIR_PATH . 'classes/Popx_Base.php';
	}
	public function enqueue_scripts() {
		wp_enqueue_style( 'popx-main', POPX_DIR_URL.'assets/css/main.css', [], POPX_VERSION );
		wp_enqueue_script( 'popx-main', POPX_DIR_URL.'assets/js/main.js', ['jquery'], POPX_VERSION, true );

		wp_localize_script(
			'popx-main', 
			'popxScript',
			[

				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'pageid' => !is_front_page() && !is_home() && is_page() ? get_the_ID() : '',
				'is_front_page' => is_front_page(),
				'is_home' => is_home(),
				'is_shop' => $this->is_wc() && is_shop(),
				'is_single_archive' => is_single() || is_archive()
			]

		);


	}

	public function is_wc() {
		return class_exists( 'woocommerce' );
	}

	// Plugin page settings link add
	public function add_plugin_link( $plugin_actions, $plugin_file ) {
		
		if( $plugin_file == 'popx/popx.php' ) {
			$plugin_actions['popx_settings'] = sprintf( esc_html__( '%sSettings%s', 'popx-popup-builder' ), '<a href="'.esc_url( admin_url( 'edit.php?post_type=popx_popup' ) ).'">', '</a>' );
		}
	    
	    return $plugin_actions;
	}

	public function client_insights() {

		if ( ! class_exists( 'Appsero\Client' ) ) {
	      require_once __DIR__ . '/appsero/src/Client.php';
	    }

	    $client = new Appsero\Client( '8708e8b3-b9a9-490c-8a5c-166101bfc6af', 'PopX &#8211; Popup Builder', __FILE__ );

	    // Active insights
	    $client->insights()->init();

	}


}

Popx::getInstance();
