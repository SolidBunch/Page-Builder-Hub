<?php
namespace PBH\Controller;

/**
 * Backend controller
 *
 * Controller which loading only on backend (admin panel)
 * contains all needed additional hooks,methods
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Backend {

	/**
	 * Constructor - add all needed actions
	 *
	 * @return void
	 **/
	public function __construct() {

		// load admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		
		//add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );

		// Change theme options default menu position
		add_action( 'fw_backend_add_custom_settings_menu', array( $this, 'add_theme_options_menu' ) );

	}
	
	/**
	 * Plugin admin init
	 *
	 */
	public function admin_menu() {
		add_menu_page( __('Page Builder Hub', '{domain}'), __('Page Builder Hub', '{domain}'), 'manage_options', 'pbh', [$this, 'admin_page'] );
		add_submenu_page( 'pbh', __('Add-ons', '{domain}'), __('Add-ons', '{domain}'), 'manage_options', 'pbh', [$this, 'admin_page']);
		add_submenu_page( 'pbh', __('Settings', '{domain}'), __('Settings', '{domain}'), 'manage_options', 'pbh-settings', [$this, 'admin_page']);
		add_submenu_page( 'pbh', __('About', '{domain}'), __('About', '{domain}'), 'manage_options', 'pbh-about', [$this, 'admin_page']);
	}
	
	public function admin_page() {
		$view = str_replace(['toplevel_page_','page-builder-hub_page_'],  '', current_action());
		PBH()->View->load('/'.$view);
	}

	/**
	 * Load admin assets
	 *
	 * @return void
	 **/
	public function load_assets() {
		wp_enqueue_style( 'page-builder-hub-backend', PBH_PLUGIN_URL . '/assets/css/admin/admin.css',
			false, PBH()->config['cache_time'] );
	}

	/**
	 * Add Website Options Menu
	 *
	 * @param array $data - options menu information
	 *
	 * @return void
	 */
	public function add_theme_options_menu( array $data ) {

		add_theme_page(
			esc_html__( 'Website Settings', 'page-builder-hub' ),
			esc_html__( 'Website Settings', 'page-builder-hub' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);

	}

}
