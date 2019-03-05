=== Inline JavaScript ===
Contributors: palasthotel, greatestview
Donate link: https://palasthotel.de/
Tags: javascript, inline, head, performance
Requires at least: 4.0
Tested up to: 5.1
Stable tag: 1.0
License: GNU General Public License v3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Removes given local enqueued script handles and places their content into the head. Useful for small scripts with a size lower than ~500 Bytes to boost site performance. Caution: Use with care and sparingly!

== Description ==
In some cases you cannot wait for a JavaScript file to load, even if it is placed early in the `<head>` section of your template. You can benefit from better performance, if you place the JavaScript code directly inside a `<script>` tag inside the header. This is where this plugin comes in: It provides a filter `inline_javascript_handles`, which takes JavaScript handles, dequeues those scripts and echos their code content inline into the wp_head section instead of linking them via a script tag.

Please beware that placing lots of JavaScript code inline in the `<head>` section can be critical. First you lose caching benefits and second the general document size can increase easily. A general rule of thumb is that you should only consider JavaScript files for inline placement, which are critical and which have a file size lower than ~500 Bytes.

== Installation ==
1. Upload `inline-javascript.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. You’re done! Try following an attachment link, the browser should redirect back to the post, where this link is placed.

== Changelog ==

= 1.0 =
* First release