<?php

/**
 * Class for settings
 *
 */
class Settings{
 
    /**
    * Constructor
    * @return void
    */
    public function __construct() {
        add_action( 'admin_menu', array(&$this, 'register_sub_menu') );
    }
 
    /**
    * Register submenu for API settings
    * @return void
    */
    public function register_sub_menu() {
        add_submenu_page( 
            'options-general.php', 'Clickatell', 'Clickatell', 'manage_options', 'clickatell-settings', array(&$this, 'submenu_page_callback')
        );
        add_action('admin_init', array(&$this, 'clickatell_settings_api_init'));
    }
 
    /**
    * Submenu callback
    * @return void
    */
    public function submenu_page_callback() {
        ?>
        <div class="wrap">
            <h2>Clickatell Settings</h2>
        </div>
        <form action="options.php" method="post">
            <?php settings_fields('clickatell_settings_api_options'); ?>
            <?php do_settings_sections('clickatell-settings'); ?>
            <?php submit_button(); ?>
        </form>
        <?php
    }


    public function clickatell_settings_api_init(){
        register_setting( 'clickatell_settings_api_options', 'clickatell_settings_api_key', 'esc_attr');
        add_settings_section('clickatell_settings_section', 'API Settings', array(&$this,'clickatell_settings_section_cb'), 'clickatell-settings');
        add_settings_field('clickatell_api_settings_field', 'API Key', array(&$this,'clickatell_api_settings_field_cb'), 'clickatell-settings', 'clickatell_settings_section');
    }

    public function clickatell_settings_section_cb(){
        echo '<p>Get your api key from <a href="https://www.clickatell.com">https://www.clickatell.com</a> and enter here</p>';
    }
 
    public function clickatell_api_settings_field_cb(){
        $value = get_option( 'clickatell_settings_api_key', '' );
        echo '<input type="text" id="clickatell_settings_api_key" name="clickatell_settings_api_key" value="' . $value . '" />';
    }
}
 
new Settings();