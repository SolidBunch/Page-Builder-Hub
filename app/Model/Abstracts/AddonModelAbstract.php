<?php
namespace PBH\Model\Abstracts;

/**
 * Addon abstract model class
 *
 * @category   Wordpress
 * @package    Peage Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

abstract class AddonModelAbstract {
	/**
	 * Addon name
	 */
	public $slug;

	/**
	 * Shortcode config
	 */
	public $config;

	/**
	 * Addon directory
	 */
	public $dir;

	/**
	 * Addon URI
	 */
	public $url;

	/**
	 * Styles
	 */
	public $styles = [];

	/**
	 * Scripts
	 */
	public $scripts = [];

	/**
	 * Script localization
	 */
	public $localize_script = [];

	/**
	 * inline script
	 */
	public $inline_script = [];

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	public function __construct() {

	}
	
	/**
	 * Register style
	 */
	public function register_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
		$this->styles[] = [
			'handle' => $handle,
			'src'    => $src,
			'deps'   => $deps,
			'ver'    => $ver,
			'media'  => $media
		];
		wp_register_style( $handle, $src, $deps, $ver, $media );
	}
	
	/**
	 * Enqueue style
	 */
	public function enqueue_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
		wp_enqueue_style( $handle, $src, $deps, $ver, $media );
	}

	/**
	 * Register script
	 */
	public function register_script( $handle, $src = '', $deps = array(), $ver = false, $in_footer = false ) {
		$this->scripts[] = [
			'handle'    => $handle,
			'src'       => $src,
			'deps'      => $deps,
			'ver'       => $ver,
			'in_footer'  => $in_footer
		];
		wp_register_script( $handle, $src, $deps, $ver, $in_footer );
	}
	
	/**
	 * Enqueue script
	 */
	public function enqueue_script( $handle, $src = '', $deps = array(), $ver = false, $in_footer = false ) {
		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	}

	/**
	 * Localize shortcode script
	 */
	public function localize_script( $handle, $object_name, $l10n ) {
		$this->localize_script[] = [
			'handle'		=> $handle,
			'object_name'	=> $object_name,
			'l10n'			=> $l10n
		];
		wp_localize_script( $handle, $object_name, $l10n );
	}

	/**
	 * Add inline script
	 */
	public function add_inline_script( $handle, $data, $position = 'after' ) {
		$this->inline_script[] = [
			'handle'	=> $handle,
			'data'		=> $data,
			'position'	=> $position
		];
		wp_add_inline_script($handle, $data, $position);
	}
}
