=== Inline JavaScript in Head ===
Contributors: palasthotel, greatestview
Donate link: https://palasthotel.de/
Tags: javascript, scripts, enqueue, inline, head, performance, filter, hook
Requires at least: 4.0
Tested up to: 5.1
Stable tag: 1.1.2
Requires PHP: 5.4
License: GNU General Public License v3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Boosts performance of critical short JavaScripts by placing their content directly into the HTML head.

== Description ==
In some cases you cannot wait for a JavaScript file to load, even if it is placed early in the `<head>` section of your template. You can benefit from better performance, if you place the JavaScript code directly inside a `<script>` tag into the header. This is where this plugin comes in: It provides a filter `inline_javascript_in_head_handles`, which takes JavaScript handles, dequeues those scripts and echos their code content inline into the head section instead of linking them via a script tag.

Please beware that placing lots of JavaScript code inline in the `<head>` section can be critical! First you lose caching benefits and second the document size can increase easily. A general rule of thumb is that you should only consider JavaScript files for inline placement, which are critical and which have a file size lower than ~500 Bytes.

= Example =

`
add_action( 'wp_enqueue_scripts', 'my_scripts' );
function my_scripts() {
	// Some critical script is enqueued
	wp_enqueue_script( 'js-detection', get_template_directory_uri() . '/js/js-detection.js' );
}

/**
 * Define JavaScript handles to be echoed inline in the html head section.
 */
add_filter( 'inline_javascript_in_head_handles', 'my_inline_javascript_in_head_handles', -20 );
function my_inline_javascript_in_head_handles( $handles ) {
	$scripts = [ 'js-detection' ];

	return array_merge( $handles, $scripts );
}
`


== Installation ==
1. Upload `inline-javascript-in-head.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the `inline_javascript_in_head_handles` filter in your theme or plugin.
4. You’re done!

== Changelog ==

= 1.1.2 =
* readme.txt code appearance screwed up, now hopefully fixed.

= 1.1.1 =
* readme.txt update

= 1.1 =
* Added filter `inline_javascript_in_head_wrap_try_catch`, which can add add a try catch wrapper around the JavaScript code.

= 1.0 =
* First release
