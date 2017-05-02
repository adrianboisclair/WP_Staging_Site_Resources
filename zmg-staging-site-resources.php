<?php
/*
Plugin Name: ZMG Staging Site Resources
Description: Loads TZR Image Assets
Author: Adrian Boisclair
Version: 0.7.0
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
        $options = get_option( 'ZMG_Staging_Site_Resources_settings' );
        return $options['ZMG_Staging_Site_Resources_text_field_0'];
    }

    public function enabled()
    {
        $options = get_option( 'ZMG_Staging_Site_Resources_settings' );
        return $options['ZMG_Staging_Site_Resources_checkbox_field_1'];
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
        if( $this->enabled() ) {
            add_filter( 'post_thumbnail_html', array( $this, 'image_resources' ) );
            add_filter( 'post_thumbnail_html', array( $this, 'image_resources' ) );
            add_filter( 'wp_get_attachment_image_src', array( $this, 'image_resources' ) );
            add_filter( 'wp_get_attachment_image', array( $this, 'image_resources' ) );
            add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );
        }
    }
}

/******************************************************
 ******************** Options Page ********************
 ******************************************************/

add_action( 'admin_menu', 'ZMG_Staging_Site_Resources_add_admin_menu' );
add_action( 'admin_init', 'ZMG_Staging_Site_Resources_settings_init' );

function ZMG_Staging_Site_Resources_add_admin_menu() {
    add_options_page( 'ZMG_Staging_Site_Resources', 'ZMG_Staging_Site_Resources', 'manage_options', 'zmg_staging_site_resources', 'ZMG_Staging_Site_Resources_options_page' );
}


function ZMG_Staging_Site_Resources_settings_init() {

    register_setting( 'pluginPage', 'ZMG_Staging_Site_Resources_settings' );

    add_settings_section(
        'ZMG_Staging_Site_Resources_pluginPage_section',
        __( 'Loads Images from Production Site', 'wordpress' ),
        'ZMG_Staging_Site_Resources_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'ZMG_Staging_Site_Resources_text_field_0',
        __( 'Production Domain', 'wordpress' ),
        'ZMG_Staging_Site_Resources_text_field_0_render',
        'pluginPage',
        'ZMG_Staging_Site_Resources_pluginPage_section'
    );

    add_settings_field(
        'ZMG_Staging_Site_Resources_checkbox_field_1',
        __( 'Enable', 'wordpress' ),
        'ZMG_Staging_Site_Resources_checkbox_field_1_render',
        'pluginPage',
        'ZMG_Staging_Site_Resources_pluginPage_section'
    );

}


function ZMG_Staging_Site_Resources_text_field_0_render() {

    $options = get_option( 'ZMG_Staging_Site_Resources_settings' );
    ?>
    <input type='text' name='ZMG_Staging_Site_Resources_settings[ZMG_Staging_Site_Resources_text_field_0]' value='<?php echo $options['ZMG_Staging_Site_Resources_text_field_0']; ?>'>
    <?php

}


function ZMG_Staging_Site_Resources_checkbox_field_1_render() {

    $options = get_option( 'ZMG_Staging_Site_Resources_settings' );
    ?>
    <input type='checkbox' name='ZMG_Staging_Site_Resources_settings[ZMG_Staging_Site_Resources_checkbox_field_1]' <?php checked( $options['ZMG_Staging_Site_Resources_checkbox_field_1'], 1 ); ?> value='1'>
    <?php

}


function ZMG_Staging_Site_Resources_settings_section_callback() {

    echo __( '', 'wordpress' );

}


function ZMG_Staging_Site_Resources_options_page() {

    ?>
    <form action='options.php' method='post'>

        <h2>ZMG Staging Site Resources</h2>

        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>

    </form>
    <?php

}

$ZMG_Staging_Site_Resources = new ZMG_Staging_Site_Resources();