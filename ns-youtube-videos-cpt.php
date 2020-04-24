<?php
/*
Plugin Name: Nuno Sarmento Youtube Videos CPT
Plugin URI: https://en-gb.wordpress.org/plugins/nuno-sarmento-youtube-videos-cpt
Description: This plugin allows you to create a custom post type 'videos' to be used on posts and pages as shortcode. The video CPT allows you to choose youtube, vimeo or dailymotion videos.
Version: 1.0.0
Author: Nuno Morais Sarmento
Author URI: https://www.nuno-sarmento.com
Text Domain: youtube-videos-cpt
Domain Path: /languages
License:     GPL2

Nuno Sarmento's Youtube Videos CPT plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Nuno Sarmento Youtube Videos CPT plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

defined('ABSPATH') or die('°_°’');

/* Set constant path to the plugin directory. */

if ( ! defined( 'NS-YOUTUBE_VIDEOS_CPT_path' ) ) {
	define( 'NS_YOUTUBE_VIDEOS_CPT_path', plugin_dir_path( __FILE__ ) );
}

/* ------------------------------------------
// Includes Files ----------------------------
--------------------------------------------- */

if ( ! @include( 'NS_YOUTUBE_VIDEOS_CPT_cpt.php' ) ) {
	require_once( NS_YOUTUBE_VIDEOS_CPT_path . 'includes/NS_YOUTUBE_VIDEOS_CPT_cpt.php' );
}

if ( ! @include( 'NS_YOUTUBE_VIDEOS_CPT_admin.php' ) ) {
	require_once( NS_YOUTUBE_VIDEOS_CPT_path . 'includes/NS_YOUTUBE_VIDEOS_CPT_admin.php' );
}

if ( ! @include( 'NS_YOUTUBE_VIDEOS_CPT_tinymce_btn.php' ) ) {
	require_once( NS_YOUTUBE_VIDEOS_CPT_path . 'includes/NS_YOUTUBE_VIDEOS_CPT_tinymce_btn.php' );
}
