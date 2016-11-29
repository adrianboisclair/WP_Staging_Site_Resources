<?php
/*
Plugin Name: ZMG Image Resources
Description: Loads TZR Image Assets
Author: Adrian Boisclair
Version: 0.0.4
*/

/**
 * Get Current Server Name
 * @return string
 */
function tzr_get_server_name() {
    return $_SERVER['SERVER_NAME'] ?: '';
}

/**
 * Get Resource Server
 * Replace the returned string with your production site domain
 * @return string
 */
function tzr_get_source_server() {
    return 'thezoereport.com';
}

/**
 * Function: Filter for TZR Image Resources
 * @param $post_thumbnail
 * @return mixed
 */
function tzr_image_resources( $post_thumbnail ) {
    $server = tzr_get_server_name();
    $tzr = tzr_get_source_server(); // TODO: This is set in a control panel

    return $server !== $tzr ? str_replace($server, $tzr, $post_thumbnail) : $post_thumbnail;
}

add_filter( 'post_thumbnail_html', 'tzr_image_resources' );
add_filter( 'wp_get_attachment_image', 'tzr_image_resources' );
add_filter( 'wp_get_attachment_image_src', 'tzr_image_resources');

/**
 * Disable Intrusive Image Src Set
 * The image srcset causes images to fail
 */
add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );