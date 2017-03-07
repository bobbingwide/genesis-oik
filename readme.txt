=== genesis-oik ===
Contributors: bobbingwide
Donate link: http://www.oik-plugins.com/oik/oik-donate/
Tags: genesis, one-column, two-columns, sidebars, responsive-layout, accessibility-ready, custom-background, custom-header, custom-menu, editor-style, featured-images, flexible-header, microformats, post-formats, rtl-language-support, sticky-post, threaded-comments
Requires at least: 4.6.3
Tested up to: 4.7.2
Version: 1.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Genesis Child Theme for oik-plugins and selected bobbing wide websites

== Description ==
genesis-oik is a child theme for the Genesis Theme Framework

* page layouts and widgets areas for custom post types
* page layouts for archives
* special 404 page
* image.php - as in genesis-image
* front-page does not display the title

== Installation ==

1. Purchase and Install the Genesis parent theme
2. Download the genesis-oik child theme
3. Install the genesis-oik child theme
4. Activate the genesis-oik child theme
5. Navigate to Appearance > Customize in your admin panel and customize to taste.
6. Navigate to Genesis > Theme Settings to set other options
7. Optionally, install and activate a range of oik-based plugins.


== Change Log ==
= 1.0.6 =
* Changed: Upgraded to slightly customised version of jQuery UI v1.12.1 copying missing images [github bobbingwide genesis-oik issues 4]
* Fixed: Added tests to confirm removal of logic that's now in genesistant [github bobbingwide genesis-oik issues 3]

= 1.0.5 =
* Added: Single post templates with A to Z pagination [github bobbingwide genesis-oik issue 7]
* Added: Support for A to Z pagination [github bobbingwide genesis-oik issue 6]
* Changed: Add styling for Author box created using [bw_user class=author-box fields=gravatar,name,description]
* Changed: Align secondary nav menu with the content that follows
* Changed: Disable WordPress 4.7 custom.css [github bobbingwide genesis-oik issues 5]
* Changed: Improve styling on archive and taxonomy pages [github bobbingwide genesis-oik issue 8]
* Changed: Style the span.summary at 90% normal size

= 1.0.4 = 
* Changed: Improve styling on iPad and iPhone 4
* Changed: Move archive styling into archive.css

= 1.0.3 =
* Added: Add 404 page to handle pragmatic links
* Added: Add styling for nested definition lists
* Added: Single attachment template
* Changed: Improve genesistant logic and add special EDD logic
* Changed: Improve span padding
* Changed: Invoke 'genesis_404' on the 404 page
* Changed: Re-enable archive.php using genesis()
* Changed: Remove _e_c() call
* Changed: Set colour for site-footer text
* Changed: Support not found for oik shortcodes
* Changed: Removed genesis_all() logic - use genesistant instead [github bobbingwide genesis-oik issue 2]

= 1.0.2 = 
* Add: Add temporary workaround for Chrome bug with the admin menu
* Changed: Always display the full sized image in image.php
* Changed: Better support for oik_sc_param
* Fixed: shortcode expansion in footer on 404 page
* Tested: With Genesis v2.1.3 but not Genesis 2.2.x

= 1.0.1 =
* Added: jquery-ui.css for use by [bw_accordion] and other jQuery UI components

= 1.0.0 =
* Added: First version, child theme of Genesis 2.1.2
* Added: Some styling in style.css copied from oik410130c
* Added: Other styling delivered in oik-custom.css - from oik-plugins.com

== Copyright ==
(C) Copyright Bobbing Wide 2015-2017

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

genesis-oik does not bundle third-party resources.

== Notes ==
* Dependent upon the Genesis Theme Framework
* Uses genesis-footer-widgets, oik-a2z, oik-shortcodes-a2z and other oik plugins.
 


