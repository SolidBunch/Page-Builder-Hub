<?php
/*
 * Page Builder Hub plugin for Wordpress
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      1.0.0
 *
 * Plugin Name: Page Builder Hub
 * Plugin URI: https://github.com/SolidBunch/page-builder-hub
 * Description: Wordpress plugin, a library of premium quality content elements for different page builders.
 * Version: 1.0.0
 * Author: SolidBunch
 * Author URI: https://solidbunch.com
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: page-builder-hub
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'PBH_VERSION' ) ) {
	define( 'PBH_VERSION', '1.0' );
}
if ( ! defined( 'PBH_PLUGIN_DIR' ) ) {
    define( 'PBH_PLUGIN_DIR', untrailingslashit(plugin_dir_path( __FILE__ )) );
}
if ( ! defined( 'PBH_PLUGIN_URL' ) ) {
    define( 'PBH_PLUGIN_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );
}

// helper functions for developers
require_once __DIR__ . '/app/dev.php';

/*
if(class_exists('WP_CLI')) {
	//define theme root directory for future commands
	define('THEME_ROOT_DIRECTORY' , __DIR__);
	//load commands for dir
	foreach (glob(__DIR__ . '/dev/cli/*.php') as $file) {
		require $file;
	}
}
*/

spl_autoload_register( function ( $class ) {
	
	// project-specific namespace prefix
	$prefix = 'PBH\\';
	
	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/app/';
	
	// does the class use the namespace prefix?
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		// no, move to the next registered autoloader
		return;
	}
	
	// get the relative class name
	$relative_class = substr( $class, $len );
	
	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
	
	// if the file exists, require it
	if ( file_exists( $file ) ) {
		require $file;
	}
} );

// Global point of enter
if ( ! function_exists( 'PBH' ) ) {
	
	function PBH() {
		return \PBH\App::getInstance();
	}
	
}
PBH()->run();