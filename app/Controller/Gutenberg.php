<?php
namespace PBH\Controller;

/**
 * Gutenberg Controller
 *
 * Rewrite default Visual Composer functions
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Gutenberg {

	/**
	 * Constructor
	 **/
	public function __construct() {

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
				if (file_exists($fname)) {
					require_once( $fname );
				}
			}
		}
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
