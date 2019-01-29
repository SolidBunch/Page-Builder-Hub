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

		/*
		if ( Utils::is_vc() ) {
			add_action( 'vc_after_init', array( $this, 'load' ) );
		} else {
			add_action( 'init', array( $this, 'load' ) );
			add_action( 'wp_footer', array( $this, 'footer' ) );
		}
		*/
		
		add_action( 'plugins_loaded', array( $this, 'load' ) );
		add_action( 'wp_footer', array( $this, 'footer' ) );

	}

	/**
	 * Load addons
	 *
	 * @return void
	 **/
	public function load() {

		// Load Gutenberg blocks
		PBH()->Controller->Gutenberg->load();
		$this->addons['gutenberg'] = PBH()->Controller->Gutenberg->addons;

	}


	public function footer() {
	}
}
