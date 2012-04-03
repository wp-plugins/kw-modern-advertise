=== Kw Modern Advertise ===
Contributors: Laurent (KwarK) Bertrand
Donate link: http://kwark.allwebtuts.net/
Tags: display,modern-advertise-zone,modern-advertise,background-advertise,on-index-page,directly-in-theme,advertise-flash-effect
Requires at least: 2.6
Tested up to: 3.2.1
Stable tag: 1.0.2

Make background clickable. An ultralight way to display one modern advertise background zone based on background image.

== Description ==

This plugin mades your background clickable. This is just a way to install your modern advertise zone based on background image and make it clickable on your index page or in your theme or whatever you want.
Optionnaly, copy and past your flash effect (if you use this option, make clickable your flash effect directly in the code of your flash effect)

To change your settings please:

* Log into Wordpress
* Open the "Modern advertise" tab (which is located at the "Appaerence menu")

* Import your background with the defaut options background import
* Choose a few number of attribut to make clickable your new background
* Optionnal, copy and past your flash affect (Make clickable your flash effect directly in your flash code if you use flash effect)
* Chose enable/disable the different zone if you want.



== Installation ==

1. Upload 'Kw-modern-advertise' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Copy and past the php code `<?php if (function_exists('kw_advert_main')) { kw_advert_main(); } ?>` at the bottom of your header.php file if you desire to display all the background advertise zone on all navigation page/article or after the get_header in your index.php file for display just on your index page.
4. Or test copy/past zone per zone with the 3 php code if you have some problem with your theme `<?php if (function_exists('kw_add_left_display')) { kw_add_left_display(); } ?>` `<?php if (function_exists('kw_add_right_display')) { kw_add_right_display(); } ?>` `<?php if (function_exists('kw_add_top_display')) { kw_add_top_display(); } ?>`
5. Adjust your settings on the 'Modern advertise tab' wich is located at the appaerence Tab

== Screenshots ==

1. Backend Screen for kw-modern-advertise


== Frequently Asked Questions ==

View forum support on Wordpress for more information


== Upgrade Notice ==

Check the Wordpress information for upgrade


== Changelog ==

= 1.0.2 =

* Light code evolved

= 1.0.1 =

* Light bug fixed for access to background option for some Wordpress version

= 1.0 = 

* Added based Wordpress background options.
* Added Enable/Disable based css

