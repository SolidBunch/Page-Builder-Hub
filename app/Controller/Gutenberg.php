<?php
namespace PBH\Controller;

use PBH\Controller\Abstracts\AddonControllerAbstract;

/**
 * Gutenberg Controller
 *
 * Controller for Gutenberg blocks
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

class Gutenberg extends AddonControllerAbstract {

	public $addons = [];

	/**
	 * Constructor
	 **/
	public function __construct() {
	    parent::__construct();

		/*
		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return;
		}
		*/
		
		add_action( 'plugins_loaded', array( $this, 'load' ) );
		
		// add block category
		add_filter( 'block_categories', [ $this, 'register_block_category' ] );
	}
	
	/**
	 * Load blocks
	 *
	 * @return void
	 **/
	public function load() {

		$addons_dirs = PBH()->addons_dirs();
		//dd($addons_dirs);
		
		foreach($addons_dirs as $addon_dir) {
			//$dirs = glob( PBH_PLUGIN_DIR . '/addons/gutenberg/*', GLOB_ONLYDIR );
			$dirs = glob( $addon_dir . '/gutenberg/*', GLOB_ONLYDIR );
			
			foreach ( $dirs as $dir ) {
				$fname = $dir . '/init.php';
				$slug = basename($dir);
				if (file_exists($fname)) {
					require_once( $fname );
					$className = 'PBH_'.$slug.'_Gutenberg';
					if (class_exists($className)) {
						$this->addons[$slug] = [
							'info' => [],
							'instance' => new $className()
						];
						$this->addons[$slug]['instance']->init();
					}

				}
			}
		}
		//dump( $this->addons );
		
		// Add addons to custom addons controller
		PBH()->Controller->Addons->addons['gutenberg'] = $this->addons;
	}
	
	
	/**
	 * Add block category (Gutenberg)
	 */
	public function register_block_category( $categories ) {

		$categories[] = [
			'slug'  => 'pbh-blocks',
			'title' => __( 'Page Builder Hub :: Blocks', '{domain}' ),
			'icon'  => null,
		];

		return $categories;
	}

}
