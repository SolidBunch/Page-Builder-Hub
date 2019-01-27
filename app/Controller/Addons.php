<?php
namespace PBH\Controller;

use PBH\Model\Shortcode;
use PBH\Helper\Utils;

/**
 * Shortcodes controller
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Addons {

	public $addons = [];

	public $custom_css = [];

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
		
		add_action( 'init', array( $this, 'load' ) );
		add_action( 'wp_footer', array( $this, 'footer' ) );

	}
	
	
	

	/**
	 * Load shortcodes
	 *
	 * @return void
	 **/
	public function load() {

		$this->addons['gutenberg'] = PBH()->Controller->Gutenberg->load();
		
	}


	public function footer() {

		echo '<style>';
		echo implode('', $this->custom_css);
		echo '</style>';
		/*
		if (!empty($this->custom_css)) {
			wp_add_inline_style( 'custom-style', implode('', $this->custom_css) );
		}
		*/
	}

}
