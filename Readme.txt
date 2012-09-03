=== Kw Modern Advertise ===

Contributors: KwarK
Donate link: http://kwark.allwebtuts.net/
Tags: modern-advertise-zone, background, partner, advertiser, modern-advertise, adverts, background-adverts, background-advertise, wordpress, plugin
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: 1.2.3


Make background images clickable with randomize options and priority displaying option.

== Description ==

This plugin mades your background images clickable for your partners programs with background images

You may view how the plugin works here http://advertise.allwebtuts.net (I have added a white opacity voluntarily)

Currently the plugin works for centered theme. 

For other kind of theme, css adpatative works (directly in its php file) is necessary.

* All code review (previous version of 1.1 are deprecated)
* illimited background images
* illimited partners links
* pagination in administration
* now automatized, no-code to add if your theme supports `wp_footer`
* priorities displaying `- 1 to 5 +`
* Option fixed & Resize or scroll for background images
* cache system since 1.2.0 version
* based on conditional tags to synchronize background with these conditional tags

`is_page`
`is_category`
`is_home`
`is_single`

If you have some problem to display background img with `is_home` and for your home page, add in your footer.php and before `</body>`: 


`<?php wp_footer(); ?>`


== Installation ==

1. Upload 'Kw-modern-advertise' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Define the width @ Appaerance > modern advertise. Add your adverts (use the default uploader from wordpress to host your background images. Define an external img src-url work also).

== Screenshots ==

1. no screenshot


== Frequently Asked Questions ==

View forum support on Wordpress for more information


== Upgrade Notice ==

Check the Wordpress information for upgrade


== Changelog ==

= 1.2.3 =

* Fix pagination in administration
* Fix maxlengh 55 char too short in administration (now 255 char)

= 1.2.2 =

* Simple improves for frontend
* clarification of the administration

= 1.2.1 =

* Simple improves for administration

= 1.2.0 =

* Added pagination in administration
* Added a cache system
* Added internationalization
* Added language fr_FR

= 1.1.2 =

* Update with px value in admin in replacement of percent
* Debug/update css with px value for div overlapping
* added fixed or scroll options in administration for background images

= 1.1.1 =

* Added one col for background color
* Synch color of the bottom of each background color with each background img
* dbDelta update added for futur update.

= 1.1 =

* All code review
* now automatized
* multi-partners
* priorities
* multi-backgrounds img
* conditional tags based to synchronize with different content (is_page, is_category, is_home, is_single)

= 1.0.2 =

* Light code evolved

= 1.0.1 =

* Light bug fixed for access to background option for some Wordpress version

= 1.0 = 

* Added based Wordpress background options.
* Added Enable/Disable based css

