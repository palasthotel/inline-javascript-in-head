<?php

/**
 * Plugin Name: Inline JavaScript
 * Description: Removes given local enqueued script handles and places their contents into the head. Useful for small scripts with a size lower than ~500 Bytes to boost site performance. Caution: Use with care and sparingly!
 * Version: 1.0
 * Author: Palasthotel <rezeption@palasthotel.de> (Kim Meyer)
 * Author URI: https://palasthotel.de
 */


namespace InlineJavaScript;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Plugin {

	private static $instance;

	/** @return Plugin */
	public static function instance() {
		if ( Plugin::$instance === null ) {
			Plugin::$instance = new Plugin();
		}
		return Plugin::$instance;
	}

	/**
	 * List of all filter hook of this plugin
	 */
	const FILTER_HANDLES = "inline_javascript_handles";

	/**
	 * Plugin constructor
	 */
	private function __construct() {

		/**
		 * Base paths
		 */
		$this->dir = plugin_dir_path( __FILE__ );
		$this->url = plugin_dir_url( __FILE__ );

		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_script_for_inlining' ), 20 );
		add_action( 'wp_head', array( $this, 'inline_scripts_in_head' ), 98 );
	}

	private function get_script_handles_to_be_inlined() {
		return apply_filters( Plugin::FILTER_HANDLES, array() );
	}

	/**
	 * First remove JavaScript files with given handle.
	 */
	public function dequeue_script_for_inlining() {
		$handles = $this->get_script_handles_to_be_inlined();
		foreach ( $handles as $handle ) {
			wp_dequeue_script( $handle );
		}
	}

	/**
	 * Inline JavaScript files with given handle in the html head for a better
	 * performance.
	 */
	public function inline_scripts_in_head() {
		$handles = $this->get_script_handles_to_be_inlined();
		if ( empty( $handles ) ) {
			return;
		}
		$scripts = wp_scripts();
		if ( empty( $scripts ) || empty( $scripts->registered ) ) {
			return;
		}
		foreach ( $handles as $handle ) {
			if ( empty( $scripts->registered[ $handle ] ) ) {
				continue;
			}
			$script_url = $scripts->registered[ $handle ]->src;
			$script_path = realpath( str_replace( site_url(), '.', $script_url ) );
			if ( $script_path === false ) {
				continue;
			}

			$script_content = file_get_contents( $script_path );
			if ( $script_content === false ) {
				continue;
			}
			echo "\n<script>" . $script_content . "</script>\n";
		}
	}
}

Plugin::instance();
