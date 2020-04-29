<?php

/**
 * Plugin Name: Inline JavaScript in Head
 * Description: Boosts performance of critical short JavaScripts by placing their content directly into the HTML head.
 * Version: 1.2.0
 * Author: Palasthotel <rezeption@palasthotel.de> (Kim Meyer)
 * Author URI: https://palasthotel.de
 */


namespace InlineJavaScriptInHead;

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
	const FILTER_HANDLES = "inline_javascript_in_head_handles";
	const FILTER_WRAP_TRY_CATCH = "inline_javascript_in_head_wrap_try_catch";

	/**
	 * Plugin constructor
	 */
	private function __construct() {
		add_action( 'wp_print_scripts', array( $this, 'inline_scripts_in_head' ), 0 );
	}

	/**
	 * Inline JavaScript files with given handle in the html head for a better in Head
	 * performance.
	 */
	public function inline_scripts_in_head() {
		$handles = apply_filters( Plugin::FILTER_HANDLES, array() );
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

			// Now it’s safe to dequeue the JavaScript file.
			$scripts->registered[ $handle ]->src = '';

			if ( apply_filters( Plugin::FILTER_WRAP_TRY_CATCH, false, $handle ) === true ) {
				$script_content = "try{" . $script_content . "}catch(e){}";
			}

			echo "<script>" . $script_content . "</script>\n";
		}
	}
}

Plugin::instance();
