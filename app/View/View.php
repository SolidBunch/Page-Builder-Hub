<?php

namespace PBH\View;

/**
 * View Class
 *
 * Anything to do with templates
 * and outputting client code
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class View {
	
	/**
	 * Load view. Used on back-end side
	 *
	 * @param string $path
	 * @param array $data
	 * @param bool $return
	 * @param null $base
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	function load( $path = '', array $data = array(), $return = false, $base = null ) {
		
		if (empty($base)) $base = PBH_PLUGIN_DIR . '/views';
		
		$full_path = $base . $path . '.php';
		
		if ( $return ) {
			ob_start();
		}
		
		if ( file_exists( $full_path ) ) {
			require $full_path;
		} else {
			throw new \Exception( 'The view path ' . $full_path . ' can not be found.' );
		}
		
		if ( $return ) {
			return ob_get_clean();
		}
	}
	
	/**
	 * Remove wpautop
	 *
	 * @see  wp_js_remove_wpautop()
	 *
	 * @param $content
	 * @param bool $autop
	 *
	 * @return string
	 */
	function js_remove_wpautop( $content, $autop = false ) {
		
		if ( $autop ) {
			$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
		}
		
		return do_shortcode( shortcode_unautop( $content ) );
	}
	
}
