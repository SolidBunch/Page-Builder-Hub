<?php
namespace PBH\Controller;

use PBH\Controller\Abstracts\AddonControllerAbstract;

/**
 * WPBakery Page Builder controller
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class WPB extends AddonControllerAbstract {
	
	public $shortcodes = [];
	
	/**
	 * Constructor
	 *
	 * @return void
	 **/
	public function __construct() {
		parent::__construct();

		// Load only if WPB Page Builder is active
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			
			add_action( 'vc_after_init', array( $this, 'load' ) );
		}

	}

	/**
	 * Load shortcodes
	 *
	 * @return void
	 **/
	public function load() {

		$addons_dirs = PBH()->addons_dirs();
		
		foreach($addons_dirs as $addon_dir) {
			$dirs = glob( $addon_dir . '/wpb/*', GLOB_ONLYDIR );
			
			foreach ( $dirs as $shortcode_dir ) {
				$fname  = $shortcode_dir . '/init.php';
				$parent = basename( $shortcode_dir );
				
				if ( file_exists( $fname ) ) {
					// Load childs shortcodes if exist
					$childs = [];
					if ( is_dir( $shortcode_dir . '/childs' ) ) {
						$dirs_childs = glob( $shortcode_dir . '/childs/*', GLOB_ONLYDIR );
						foreach ( $dirs_childs as $shortcode_child_dir ) {
							$shortcode = $this->load_shortcode( $shortcode_child_dir, $parent );
							$childs[]  = $shortcode->shortcode;
						}
					}
					// Load shortcode
					$this->load_shortcode( $shortcode_dir, '', $childs );
				}
			}
		}
		
		// Add addons to custom addons controller
		PBH()->Controller->Addons->addons['wpb'] = $this->shortcodes;
		
		//dump( $this->shortcodes );
	}

	public function load_shortcode($shortcode_dir, $parent='', $childs=[]) {
		$config = include( $shortcode_dir . '/config.php' );
		
		// Add childs shortcodes to container config
		if (!empty($childs) && isset($config['as_parent'])) {
			$only = explode(',', $config['as_parent']['only']);
			foreach($childs as $child) {
				if (!in_array($child, $only)) $only[] = $child;
			}
			$config['as_parent']['only'] = implode(',', $only);
		}

		//dump($config);
		require_once( $shortcode_dir . '/init.php' );
		
		$class_name = str_replace('-','_',$config['base']).'_WPB';
		if (class_exists($class_name)) {
			$this->shortcodes[ $config['base'] ] = new $class_name ( array(
				'config'    => $config
			) );
			return $this->shortcodes[ $config['base'] ];
		}
	}
	
	/**
	 * Get shortcode content. Made for calling inside WPBakeryShortCode class
	 * @param $shortcode
	 * @param $atts
	 * @param string $content
	 *
	 * @return mixed
	 */
	public function content($shortcode, $atts, $content="") {
		return $this->shortcodes[$shortcode]->content($atts, $content);
	}
}
