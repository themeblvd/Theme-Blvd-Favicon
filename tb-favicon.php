<?php
/*
Plugin Name: Theme Blvd Favicon
Description: Easily add a standard favicon along with optional bookmark icons for all portable Apple devices to your Theme Blvd theme.
Version: 1.0.0
Author: Jason Bobich
Author URI: http://jasonbobich.com
License: GPL2
License: GPL2

    Copyright 2012  Jason Bobich

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

define( 'TB_FAVICON_PLUGIN_VERSION', '1.0.0' );
define( 'TB_FAVICON_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'TB_FAVICON_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

/**
 * Initiate favicon plugin
 *
 * @since 1.0.0
 */

function themeblvd_favicon_init() {
	
	// Check to make sure Theme Blvd Framework 2.2+ is running
	if( ! defined( 'TB_FRAMEWORK_VERSION' ) || version_compare( TB_FRAMEWORK_VERSION, '2.1.0', '<' ) ) {
		add_action( 'admin_notices', 'themeblvd_favicon_warning' );
		return;
	}
	
	// Setup option params
	$name = __( 'Favicons', 'themeblvd_favicon' );
	$description = __( 'A favicon generally appears at the top of the web browser next to the title or URL of your website for your online visitors. The favicon also gets associated with your website when users bookmark it. In addition to the standard favicon, you can also configure the Apple touch icons that users see when bookmarking your website from various Apple devices.<br><br><strong>These are all completely optional; any items you leave blank in this section will simply not display on your website.</strong>', 'themeblvd_favicon' );
	$options = array(
		'favicon' => array( 
			'name' 		=> __( 'Standard Favicon (16x16)', 'themeblvd_favicon' ),	
			'desc' 		=> __( 'Insert the URL to the .ico file or PNG image you\'d like to use as your website\'s favicon.<br><br>For help generating a standard favicon ICO file, visit <a href="http://www.favicon.cc/" target="_blank">favicon.cc</a>.', 'themeblvd_favicon' ),
			'id' 		=> 'favicon',
			'type' 		=> 'upload'
		),
		'apple_touch_57x57' => array( 
			'name' 		=> __( 'Standard Apple Touch Icon (57x57)', 'themeblvd_favicon' ),	
			'desc' 		=> __( 'Insert the URL to the PNG image file you\'d like to use as your website\'s Apple touch icon on standard apple devices.<br><br>This is more of the "fallback" for older Apple devices.', 'themeblvd_favicon' ),
			'id' 		=> 'apple_touch_57x57',
			'type' 		=> 'upload'
		),
		'apple_touch_72x72' => array( 
			'name' 		=> __( 'Apple Touch Icon - iPad 1st/2nd Generation (72x72)', 'themeblvd_favicon' ),	
			'desc' 		=> __( 'Insert the URL to the PNG image file you\'d like to use as your website\'s Apple touch icon on first and second generation iPads.', 'themeblvd_favicon' ),
			'id' 		=> 'apple_touch_72x72',
			'type' 		=> 'upload'
		),
		'apple_touch_114x114' => array( 
			'name' 		=> __( 'Apple Touch Icon - iPhone with Retina (114x114)', 'themeblvd_favicon' ),	
			'desc' 		=> __( 'Insert the URL to the PNG image file you\'d like to use as your website\'s Apple touch icon on for the iPhone 4S and later, which come with retina display.', 'themeblvd_favicon' ),
			'id' 		=> 'apple_touch_114x114',
			'type' 		=> 'upload'
		),
		'apple_touch_144x144' => array( 
			'name' 		=> __( 'Apple Touch Icon - iPad with Retina (144x144)', 'themeblvd_favicon' ),	
			'desc' 		=> __( 'Insert the URL to the PNG image file you\'d like to use as your website\'s Apple touch icon on third generation iPads and later, which come with retina display.', 'themeblvd_favicon' ),
			'id' 		=> 'apple_touch_144x144',
			'type' 		=> 'upload'
		)
	);
	
	// Add option section
	themeblvd_add_option_section( 'config', 'favicons', $name, $description, $options );
	
	// Hook our output to wp_head
	add_action( 'wp_head', 'themeblvd_favicon' );
	
}
add_action( 'after_setup_theme', 'themeblvd_favicon_init' );

/**
 * Register text domain for localization.
 *
 * @since 1.0.0
 */

function themeblvd_favicon_textdomain() {
	load_plugin_textdomain( 'themeblvd_favicon', false, TB_FAVICON_PLUGIN_DIR . '/lang' );
}
add_action( 'plugins_loaded', 'themeblvd_favicon_textdomain' );

/**
 * Display warning telling the user they must have a 
 * theme with Theme Blvd framework v2.1+ installed in 
 * order to run this plugin.
 *
 * @since 1.0.0
 */

function themeblvd_favicon_warning() {
	echo '<div class="updated">';
	echo '<p>'.__( 'You currently have the "Theme Blvd Favicon" plugin activated, however you are not using a theme with Theme Blvd Framework v2.1+, and so this plugin will not do anything.', 'themeblvd_favicon' ).'</p>';
	echo '</div>';
}

/**
 * Add favicon links.
 *
 * @since 1.0.0
 */

function themeblvd_favicon() {
	
	// Standard favicon
	$icon_16x16 = themeblvd_get_option('favicon');
	if( $icon_16x16 )
		echo '<link rel="shortcut icon" href="'.$icon_16x16.'" />'."\n";
	
	// Apple touch icons
	$icon_144x144 = themeblvd_get_option('apple_touch_144x144');
	if( $icon_144x144 )
		echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="'.$icon_144x144.'" />'."\n";
	
	$icon_114x114 = themeblvd_get_option('apple_touch_114x114');
	if( $icon_114x114 )
		echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="'.$icon_114x114.'" />'."\n";
		
	$icon_72x72 = themeblvd_get_option('apple_touch_72x72');
	if( $icon_72x72 )
		echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="'.$icon_72x72.'" />'."\n";
		
	$icon_57x57 = themeblvd_get_option('apple_touch_57x57');
	if( $icon_57x57 )
		echo '<link rel="apple-touch-icon-precomposed" href="'.$icon_57x57.'" />'."\n";

}