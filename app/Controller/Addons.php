<?php
namespace PBH\Controller;

/**
 * Addons controller
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Addons {

	public $addons = [];

	/**
	 * Constructor - add all needed actions
	 *
	 * @return void
	 **/
	public function __construct() {

	}

	/**
	 * Load addons
	 *
	 * @return void
	 **/
	public function load() {
		/*

		// Load Gutenberg blocks
		PBH()->Controller->Gutenberg->load();
		$this->addons['gutenberg'] = PBH()->Controller->Gutenberg->addons;
		
		// Load WPBakery Page Builder shortcodes
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			PBH()->Controller->WPB->load();
			$this->addons['wpb'] = PBH()->Controller->WPB->shortcodes;
		}
		*/

	}


	public function footer() {
	}
}
