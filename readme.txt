=== Plugin Name ===
Contributors: lontongcorp
Donate link: http://www.lontongcorp.com/2013/02/15/wordpress-html5-pushstate/
Tags: ajax, html5, pushstate, themes 
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enables HTML5 pushState for wordpress to get contents through AJAX without breaking SEO rank

== Description ==

Ajaxify wordpress with HTML5 pushState based on History.js by <a href="http://github.com/balupton/history.js">Benjamin Lupton</a>.

Support for HTML5 modern browser only, focus on mobile and not breaking SEO rank.
Take an advantages from History.js, visited contents saved into browser's so it will find and display it directly, no repeating request to server even have anchor (#).

Bundled with jQuery scrollTo plugin for user experiences and used to read and scroll to anchor.
Using jQuery AJAX methods, some plugins that used javascript will not work.
And due to AJAX methods, this will not working with cross-domain (subdomain) calls.

No Jetpack API (or similar) integrations for now, so it just get whole page/post request and filtering the content to show in the body.


== Installation ==

1. Download from wordpress plugins or upload to your server "/wp-content/plugins/" manually as usual
2. Activate and go the <a href="/wp-admin/options-general.php?page=pushstate">Settings</a> link
3. Put the container DOM ( "body", "#container_id", ".some-classes" )
    
Tested on TwentyTwelve themes, with "#content" container


== Screenshots ==

Live actions at <a href="http://www.lontongcorp.com/" target="_blank">my blog</a> and choose one of the post.


== Changelog ==

= 1.0.2 = 

* Improved performances
* Add more options
* Custom loading image (remove default)
* Loading image position, relative to DOM as CSS background
* Javascript on-complete callback
* Avoid pushState from feed links

= 1.0.1 = 

* Add parseURI from Steven Levithan <stevenlevithan.com>
* Avoid pushState from links:
  * any login page
  * wp-admin
  * any pictures (jp*g|png|gif|bmp|css|js)
* Change name to "HTML5 pushState (on Settings menu and others)

= 1.0.0 = 

First Release


== Early Version ==

This is just a preliminary version as I can see no real pushState implementation for wordpress yet. 

= Conflicts =

Some known not works with:

* WP SyntaxHighligher
* Some eCommerce plugins (WooCommerce, eShopping, etc)'s plugins
* News-Ticker
*  ... please let me know ...
