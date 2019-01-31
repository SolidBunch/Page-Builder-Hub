<?php

namespace PBH;

use PBH\Helper\Utils;
use PBH\View\View;

/**
 * Application Singleton
 *
 * Primary application controller
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class App {
	
	/** @var  $instance - self */
	private static $instance;
	
	/** @var array */
	public $config;
	
	/** @var array */
	public $modules;
	
	/** @var \stdClass */
	public $Controller;
	
	/** @var \stdClass */
	public $Model;
	
	/** @var view */
	public $View;
	
	private function __construct() {
		add_action( 'init', [$this, 'init'] );
	}
	
	
	/**
	 * @return App Singleton
	 */
	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	/**
	 * Run the theme
	 **/
	public function init() {
		
		// Translation support
		load_theme_textdomain( 'page-builder-hub', PBH_PLUGIN_DIR . '/languages' );
		
	}
	
	/**
	 * Run the theme
	 **/
	public function run() {
		
		$this->Controller = new \stdClass();
		$this->Model      = new \stdClass();
		
		// Load dependency classes first
		// View
		$this->View = new View();
		
		// Autoload controllers
		$this->load_modules( 'Controller', '/' );
	}
	
	/**
	 * Autoload core modules in a specific directory
	 *
	 * @param string
	 * @param string
	 * @param bool
	 **/
	private function load_modules( $layer, $dir = '/' ) {
		
		$directory = PBH_PLUGIN_DIR . '/app/' . $layer . $dir;
		$handle    = opendir( $directory );
		
		while ( false !== ( $file = readdir( $handle ) ) ) {
			
			if ( is_file( $directory . $file ) ) {
				// Figure out class name from file name
				$class = str_replace( '.php', '', $file );
				
				// Avoid recursion
				if ( $class !== get_class( $this ) ) {
					$classPath            = "\\PBH\\{$layer}\\{$class}";
					$this->$layer->$class = new $classPath();
				}
				
			}
		}
		
	}
	
	public function addons_dirs() {
		do_action('pbh/addons-dirs1');
		return apply_filters( 'pbh/addons-dirs', [PBH_PLUGIN_DIR . '/addons'] );

	}
	
	private function __clone() {
	}
	
}
