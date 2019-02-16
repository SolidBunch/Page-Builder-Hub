<?php
namespace PBH\Model\Abstracts;

use PBH\Helper\Utils;

/**
 * Shortcode model
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class WPBAbstract extends AddonModelAbstract {

	/**
	 * Shortcode constructor.
	 *
	 * @param $data
	 */
	public function __construct($data) {
		
		if (isset($data['config'])) {
			$this->config = $data['config'];
			if ( isset($this->config['icon']) ) $this->config['icon'] = $this->url . $this->config['icon'];
		}
		
		parent::__construct();
		
		// Add Visual Composer shortcode support
		if ( file_exists($this->dir . '/wpb.php')) {
			
			// Add shortcode map
			vc_map( $this->config );

			// Add shortcode to VC
			require_once( $this->dir . '/wpb.php' );
			
			// Add AJAX script
			if (file_exists($this->dir . '/ajax.php')) {
				require_once( $this->dir . '/ajax.php' );
			}
			
			// Register assets
			if (is_admin()) {
				$this->admin_assets();
			} else {
				$this->front_assets();
			}
		}
	}

	/**
	 * Prepare atts for shortcode
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function atts($atts) {
		//if (!isset($atts['classes'])) $atts['classes'] = '';

		if ( !empty($atts['css']) ) {
			$css_class = trim( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->slug, $atts ) );
			
			$atts['classes'] = $css_class . ' ' . trim(!empty( $atts['classes'] ) && trim( $atts['classes'] ) ? $atts['classes']:'');
		}
		//dump($atts);
		return $atts;
	}

	/**
	 * Prepare data for shortcode view
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function data($data) {
		if ( empty( $data['id']) && ! empty( $data['atts']['el_id'] ) ) {
			$data['id'] = $data['atts']['el_id'];
		}
		return $data;
	}

	/**
	 * Parse param group atts
	 *
	 * @see vc_param_group_parse_atts()
	 *
	 * @param $atts_string
	 * @return array|mixed
	 */
	function param_group_parse_atts( $atts_string ) {
		return json_decode( urldecode( $atts_string ), true );
	}
	
	/**
	 * Register admin assets
	 *
	 */
	public function admin_assets() {
		
		// ---------------------------------------------------------------------------------
		// Backend Scripts
		// ---------------------------------------------------------------------------------
		$fname = $this->dir . '/assets/js/backend.min.js';
		if ( file_exists( $fname ) ) {
			$this->enqueue_script(
				'pbh-wpb-' . $this->slug . '-backend',
				$this->url . '/assets/js/backend.min.js',
				[],
				filemtime( $fname ),
				true
			);
		}
		
		// ---------------------------------------------------------------------------------
		// Backend Styles
		// ---------------------------------------------------------------------------------
		$fname = $this->dir . '/assets/css/backend.min.css';
		if ( file_exists( $fname ) ) {
			$this->enqueue_style(
				'pbh-wpb-' . $this->slug . '-backend',
				$this->url . '/assets/css/backend.min.css',
				[],
				filemtime( $fname )
			);
		}
	}
	
	/**
	 * Register front assets
	 *
	 */
	public function front_assets() {

		// ---------------------------------------------------------------------------------
		// Front Scripts
		// ---------------------------------------------------------------------------------
		$fname = $this->dir . '/assets/js/scripts.min.js';
		if ( file_exists( $fname ) ) {
			$this->enqueue_script(
				'pbh-wpb-' . $this->slug . '-front',
				$this->url . '/assets/js/scripts.min.js',
				[ 'jquery' ],
				filemtime( $fname ),
				true
			);
		}
		
		// ---------------------------------------------------------------------------------
		// Front Styles
		// ---------------------------------------------------------------------------------
		$fname = $this->dir . '/assets/css/style.min.css';
		
		if ( file_exists( $fname ) ) {
			$this->enqueue_style(
				'pbh-wpb-' . $this->slug . '-front',
				$this->url . '/assets/css/style.min.css',
				[],
				filemtime( $fname )
			);
		}
	}
}
