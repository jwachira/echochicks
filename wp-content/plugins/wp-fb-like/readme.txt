=== WP FB Like ===
Contributors: Ferri Sutanto
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QEQP2HVW8B5BN
Tags: facebook like button, facebook like, facebook
Requires at least: 2.7.2
Tested up to: 2.9.2
Stable tag: 1.3

== Description ==

WP FB Like makes it easy to install Facebook Plugin Like (http://developers.facebook.com/docs/reference/plugins/like) automatically to every post in your blog. There are options to display on the front page (home) and also pages.

Simply activate the plugin, and the settings as needed, then your blog is ready with the latest Facebook Like Plugin.

= New =

* add "manual" position, now user can add PHP function directly in any template using 
	
	<?php if(function_exists('wp_fb_like')) { wp_fb_like(); } ?>
	
	&lt;?php if(function_exists(&#039;wp_fb_like&#039;)) { wp_fb_like(); } ?&gt;

= Features =

* Options to display on pages and home
* Options to set style of div  that surrounds the button
* Easily installation and customisation
* Quicker loading times for the buttons, using iframe, not FBML
* Real time preview button on admin panel
* Manual function directly into template

== Installation ==

Follow the steps below to install the plugin.

1. Upload the WP FB Like directory to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings/Facebook Like to configure the button

== Screenshots ==

1. WP FB Like Settings Page
2. WP FB Like

== Frequently Asked Questions ==

For help and support please refer to the WP FB Like homepage at <a href="http://buzzknow.com/2010/04/24/facebook-like-button-simple-wordpress-plugin/">buzzknow.com</a>.

== Upgrade Notice ==

Nothing for now.

== Changelog ==

= 1.3 =

* fix small bug for manual position

= 1.2 =

* add "manual" position, now user can add PHP function directly in any template using 
	
	<?php if(function_exists('wp_fb_like')) { wp_fb_like(); } ?>
	
	&lt;?php if(function_exists(&#039;wp_fb_like&#039;)) { wp_fb_like(); } ?&gt;

= 1.1 =

* Fix for show faces bug

= 1.0 =

* First release