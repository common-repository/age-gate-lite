<?php

    /**
     * Admin settings of Age Gate Lite
     */

    // create custom plugin settings menu
    add_action('admin_menu', 'agl_admin_menu');

    function agl_admin_menu() {

        //create new top-level menu
        add_menu_page('Age Gate Lite', 'Age Gate Lite', 'administrator', __FILE__, 'agl_settings_page' , 'dashicons-lock');

        //call register settings function
        add_action( 'admin_init', 'agl_settings' );
    }

    function agl_addons_enqueue() {
    	wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );

    	wp_register_script('age-gate-lite-js', plugins_url('age-gate-lite-js.js' , __FILE__ ), array('jquery','wp-color-picker'));
        wp_enqueue_script('age-gate-lite-js');
        
    }
    add_action('admin_enqueue_scripts', 'agl_addons_enqueue');

    function agl_settings() {
        register_setting( 'agl_settings_group', 'agl_cookie_days' );
        register_setting( 'agl_settings_group', 'agl_primary_color', array('default' => '#ff6c2d'));
        register_setting( 'agl_settings_group', 'agl_title_color', array('default' => '#000000'));
        register_setting( 'agl_settings_group', 'agl_main_title' );
        register_setting( 'agl_settings_group', 'agl_description' );
        register_setting( 'agl_settings_group', 'agl_custom_success_message' );
        register_setting( 'agl_settings_group', 'agl_yes_btn_text' );
        register_setting( 'agl_settings_group', 'agl_no_btn_text' );
        register_setting( 'agl_settings_group', 'agl_test_mode' );
        register_setting( 'agl_settings_group', 'agl_logo_img' );
        register_setting( 'agl_settings_group', 'agl_age_limit' );
        register_setting( 'agl_settings_group', 'agl_safe_link' );
    }

    function agl_settings_page() {
    ?>
        <style>
            .image-preview-wrapper {position: relative;width: 122px;}
            img#image-preview {border: 1px solid #ddd;padding: 10px;width: 100px;height: 100px;object-fit: contain;}
            a#remove_agl_logo_button {position: absolute;top: -8px;right: -8px;text-align: center;width: 25px;height: 25px;border-radius: 50%;background: #fff;box-shadow: 0px 1px 3px #ccc;line-height: 20px;text-decoration: none;font-size: 18px;font-weight: bold;}
            a#remove_agl_logo_button span.dashicons.dashicons-no {line-height: 25px;}
        </style>
        <div class="wrap">
        <h1>Age Gate Lite Settings</h1>
        <div>
            <form method="post" action="options.php" >
                <?php settings_fields( 'agl_settings_group' ); ?>
                <?php do_settings_sections( 'agl_settings_group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Age Gate Logo</th>
                        <td>
                            <input id="agl_logo_img" type="hidden" name="agl_logo_img" value="<?php echo get_option('agl_logo_img'); ?>" />
                            <?php if ( get_option( 'agl_logo_img' ) != '') {  } ?>
                            <div class='image-preview-wrapper' style="display: <?php  echo ( get_option('agl_logo_img') !='' ? 'block' :  'none') ; ?>">
                                <img id='image-preview' src='<?php echo get_option( 'agl_logo_img' ) ; ?>' height='100'>
                                <a id="remove_agl_logo_button" href="javascript:void(0);"><span class="dashicons dashicons-no"></span></a>
                            </div>
                            <input id="upload_agl_logo_button" type="button" class="button-primary" style="min-width: 122px;" value="Update Logo" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Age Limit</th>
                        <td>
                            <input type="number" name="agl_age_limit" value="<?php echo esc_attr( get_option('agl_age_limit') ); ?>"> Years
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Don't Show Age Gate For</th>
                        <td>
                            <input type="number" name="agl_cookie_days" value="<?php echo esc_attr( get_option('agl_cookie_days') ); ?>"> Day(s)
                            <br><small>Leave Empty to show age gate once per session</small>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Primary Color</th>
                        <td>
                            <input type="text" name="agl_primary_color" value="<?php echo esc_attr( get_option('agl_primary_color') ); ?>" class="agl-color-picker" >
                            <br><small>Buttons / links </small>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Main Title Color</th>
                        <td>
                            <input type="text" name="agl_title_color" value="<?php echo esc_attr( get_option('agl_title_color') ); ?>" class="agl-color-picker" >
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Main Title</th>
                        <td>
                            <input style="width:100%" type="text" name="agl_main_title" value="<?php echo esc_attr( get_option('agl_main_title') ); ?>" >
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Description</th>
                        <td>
                            <textarea style="width:100%;resize:none;" name="agl_description" rows="5"><?php echo get_option('agl_description'); ?></textarea>
                            <br><small>Below main title / Html, Shortcode etc.. Supported</small>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Success Screen (optional)</th>
                        <td>
                            <textarea style="width:100%;resize:none;" name="agl_custom_success_message" rows="5"><?php echo get_option('agl_custom_success_message'); ?></textarea>
                            <br><small>Can be used to show newsleters, promos, deals etc.. / Html, Shortcode etc.. Supported</small>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Yes Button Label</th>
                        <td>
                            <input style="width:100%" type="text" name="agl_yes_btn_text" value="<?php echo esc_attr( get_option('agl_yes_btn_text') ); ?>" >
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">No Button Label</th>
                        <td>
                            <input style="width:100%" type="text" name="agl_no_btn_text" value="<?php echo esc_attr( get_option('agl_no_btn_text') ); ?>" >
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Safe Link</th>
                        <td>
                            <input style="width:100%" type="url" name="agl_safe_link" value="<?php echo esc_attr( get_option('agl_safe_link') ); ?>" placeholder="https://google.com" >
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Test Mode</th>
                        <td>
                            <input type="checkbox" name="agl_test_mode" value="1" <?php checked(1, get_option('agl_test_mode'), true); ?> /> <small>( For debuging / testing )</small>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php }
