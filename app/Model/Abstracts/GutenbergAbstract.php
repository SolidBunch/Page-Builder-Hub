<?php

namespace PBH\Model\Abstracts;

/**
 * Gutenberg addon model
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
abstract class GutenbergAbstract extends AddonAbstract {
	
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function init() {
		add_action( 'init', [ $this, 'run' ] );
		$this->enqueue_additional_assets();
	}
	
	public function run() {
		
		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return;
		}
		
		load_plugin_textdomain( 'pbh-blocks-' . $this->slug, false, $this->dir . '/languages' );
		
		// ---------------------------------------------------------------------------------
		// Editor Scripts
		// ---------------------------------------------------------------------------------
		$fname = $this->dir . '/assets/js/block.build.min.js';
		if ( file_exists( $fname ) ) {
			$this->register_script(
				'pbh-blocks-' . $this->slug . '-editor', // Handle
				$this->url . '/assets/js/block.build.min.js',
				[ 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ],
				filemtime( $fname ),
				true
			);
		}
		
		// ---------------------------------------------------------------------------------
		// Front Scripts ( enqueued at both : front and back )
		// ---------------------------------------------------------------------------------
		$fname = $this->dir . '/assets/js/scripts.min.js';
		if ( file_exists( $fname ) ) {
			$this->register_script(
				'pbh-blocks-' . $this->slug . '-front', // Handle
				$this->url . '/assets/js/scripts.min.js',
				[ 'jquery' ],
				filemtime( $fname ),
				true
			);
		}
		
		// ---------------------------------------------------------------------------------
		// Editor Styles
		// ---------------------------------------------------------------------------------
		$fname = $this->dir . '/assets/css/block-editor.min.css';
		if ( file_exists( $fname ) ) {
			$this->register_style(
				'pbh-blocks-' . $this->slug . '-editor',
				$this->url . '/assets/css/block-editor.min.css',
				[ 'wp-edit-blocks' ],
				filemtime( $fname )
			);
		}
		
		// ---------------------------------------------------------------------------------
		// Front Styles ( enqueued at both : front and back )
		// ---------------------------------------------------------------------------------
		$fname = $this->dir . '/assets/css/block-style.min.css';
		if ( file_exists( $fname ) ) {
			$this->register_style(
				'pbh-blocks-' . $this->slug . '-front',
				$this->url . '/assets/css/block-style.min.css',
				[],
				filemtime( $fname )
			);
		}
		
		// ---------------------------------------------------------------------------------
		// Register Block Type
		// ---------------------------------------------------------------------------------
		$this->register_block_type();
		
		// ---------------------------------------------------------------------------------
		// TRANSLATION ( since WP 5.0 )
		// May be extended to wp_set_script_translations( 'my-handle', 'my-domain', plugin_dir_path( MY_PLUGIN ) . 'languages' ) ).
		// For details see * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
		// ---------------------------------------------------------------------------------
		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'pbh-blocks-' . $this->slug . '-editor', 'pbh-blocks-' . $this->slug );
		}
	}
	
	
	/**
	 * Register Block Type
	 * Must be overriding at add-on
	 */
	public function register_block_type() { }
	
	
	/**
	 * Enqueue additional assets
	 * Must be overriding at add-on
	 */
	public function enqueue_additional_assets() {
		// --------------------------------------------------------------
		//  Example to enqueue additional assets (plugins such as slick) 
		// --------------------------------------------------------------
		/*
		// enqueue back-end assets only
		$this->enqueue_block_editor_assets( [
			[
				'type'          => 'script',
				'handle_suffix' => 'slick',
				'filename'      => 'slack_alert.js',
				// .. OPTIONAL
			],
			[
				'type'          => 'style',
				'handle_suffix' => 'slick',
				'filename'      => 'slack_alert.css',
				'deps'          => [ 'wp-edit-blocks' ], // OPTIONAL
				// .. OPTIONAL
			]
		] );
		
		// load both front-end + back-end assets
		$this->enqueue_block_assets( [
			[
				'type'          => 'script',
				'target'        => 'frontend', // 'backend', 'frontend', 'all'
				'handle_suffix' => 'slick',
				'filename'      => 'slack_alert2.js',
				'deps'          => [ 'jquery' ], // OPTIONAL
				'ver'           => 1111,         // OPTIONAL
				'in_footer'     => true          // OPTIONAL
			],
			[
				'type'          => 'style',
				'target'        => 'frontend', // 'backend', 'frontend', 'all'
				'handle_suffix' => 'slick',
				'filename'      => 'slack_alert2.css',
				'deps'          => [],   // OPTIONAL,  [] - frontend,  [ 'wp-edit-blocks' ] - backend 
				'ver'           => 1111, // OPTIONAL
				'media'         => 'all' // OPTIONAL
			]
		] );
		*/
	}
	
	
	/**
	 * Enqueue additional block_editor assets (load back-end assets)
	 *
	 * @param array $assets
	 * @param int $priority
	 */
	public function enqueue_block_editor_assets( array $assets, $priority = 7 ) {
		
		if ( ! $assets ) {
			return;
		}
		
		add_action( 'enqueue_block_editor_assets', function () use ( $assets ) {
			
			foreach ( $assets as $asset ) {
				
				if ( $asset['type'] === 'script' ) {
					
					$handle = "pbh-blocks-{$this->slug}-editor-{$asset['filename']}";
					$path   = "{$this->dir}/assets/js/{$asset['filename']}";
					$url    = "{$this->url}/assets/js/{$asset['filename']}";
					
					$defaults = [
						'deps'      => [ 'jquery' ],
						'ver'       => filemtime( $path ),
						'in_footer' => true
					];
					
					$asset = wp_parse_args( $asset, $defaults );
					wp_enqueue_script( $handle, $url, $asset['deps'], $asset['ver'], $asset['in_footer'] );
				}
				
				if ( $asset['type'] === 'style' ) {
					
					$handle = "pbh-blocks-{$this->slug}-editor-{$asset['filename']}";
					$path   = "{$this->dir}/assets/css/{$asset['filename']}";
					$url    = "{$this->url}/assets/css/{$asset['filename']}";
					
					$defaults = [
						'deps'  => [ 'wp-edit-blocks' ],
						'ver'   => filemtime( $path ),
						'media' => 'all'
					];
					
					$asset = wp_parse_args( $asset, $defaults );
					wp_enqueue_style( $handle, $url, $asset['deps'], $asset['ver'], $asset['media'] );
				}
				
			}
		}, $priority );
	}
	
	
	/**
	 * Enqueue additional block assets (load both front-end + back-end assets)
	 *
	 * @param array $assets
	 * @param int $priority
	 */
	public function enqueue_block_assets( array $assets, $priority = 7 ) {
		
		if ( ! $assets ) {
			return;
		}
		
		add_action( 'enqueue_block_assets', function () use ( $assets ) {
			
			foreach ( $assets as $asset ) {
				
				if ( $asset['type'] === 'script' ) {
					
					$handle = "pbh-blocks-{$this->slug}-editor-{$asset['filename']}";
					$path   = "{$this->dir}/assets/js/{$asset['filename']}";
					$url    = "{$this->url}/assets/js/{$asset['filename']}";
					
					$defaults = [
						'deps'      => [ 'jquery' ],
						'ver'       => filemtime( $path ),
						'in_footer' => true
					];
					
					$asset = wp_parse_args( $asset, $defaults );
					
					switch ( $asset['target'] ) {
						case 'backend':
							if ( is_admin() ) {
								wp_enqueue_script( $handle, $url, $asset['deps'], $asset['ver'], $asset['in_footer'] );
							}
							break;
						case 'frontend':
							if ( ! is_admin() ) {
								wp_enqueue_script( $handle, $url, $asset['deps'], $asset['ver'], $asset['in_footer'] );
							}
							break;
						default:
							wp_enqueue_script( $handle, $url, $asset['deps'], $asset['ver'], $asset['in_footer'] );
					}
				}
				
				if ( $asset['type'] === 'style' ) {
					
					$handle = "pbh-blocks-{$this->slug}-editor-{$asset['filename']}";
					$path   = "{$this->dir}/assets/css/{$asset['filename']}";
					$url    = "{$this->url}/assets/css/{$asset['filename']}";
					
					$defaults = [
						'deps'  => [],
						'ver'   => filemtime( $path ),
						'media' => 'all'
					];
					
					$asset = wp_parse_args( $asset, $defaults );
					
					switch ( $asset['target'] ) {
						case 'backend':
							if ( is_admin() ) {
								wp_enqueue_style( $handle, $url, $asset['deps'], $asset['ver'], $asset['media'] );
							}
							break;
						case 'frontend':
							if ( ! is_admin() ) {
								wp_enqueue_style( $handle, $url, $asset['deps'], $asset['ver'], $asset['media'] );
							}
							break;
						default:
							wp_enqueue_style( $handle, $url, $asset['deps'], $asset['ver'], $asset['media'] );
					}
				}
			}
		}, $priority );
	}
	
	
}
