<?php
/*
Plugin Name: ZMG Staging Site Resources
Description: Loads TZR Image Assets
Author: Adrian Boisclair
Version: 0.1.0
*/

class ZMG_Staging_Site_Resources {

    /**
     * ZMG_Staging_Site_Resources constructor.
     * Initializes Plugin
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Get Current Server Name
     * @return string
     */
    public function get_server_name() {
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * Get Resource Server - Replace the returned string with your production site domain
     * @return string
     */
    public function get_source_server() {
        return 'thezoereport.com';
    }

    /**
     * Function: Filter for Image Resources
     * @param $post_thumbnail
     * @return mixed
     */
    public function image_resources( $post_thumbnail ) {
        $server = $this->get_server_name();
        $tzr = $this->get_source_server();

        return $server !== $tzr ? str_replace($server, $tzr, $post_thumbnail) : $post_thumbnail;
    }

    /**
     * Init Function: Loads All Filters
     */
    public function init() {
        add_filter( 'post_thumbnail_html', array( $this, 'image_resources' ) );
        add_filter( 'post_thumbnail_html', array( $this, 'image_resources' ) );
        add_filter( 'wp_get_attachment_image_src', array( $this, 'image_resources' ) );
        add_filter( 'wp_get_attachment_image', array( $this, 'image_resources' ) );
        add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );
    }

}

$ZMG_Staging_Site_Resources = new ZMG_Staging_Site_Resources();