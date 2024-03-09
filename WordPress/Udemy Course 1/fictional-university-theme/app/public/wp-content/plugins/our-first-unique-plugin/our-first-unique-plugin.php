<?php 
/*
    Plugin Name: Our Test Plugin
    Description: A truly amazing plugin
    Version: 1.0
    Author: Teo
*/

// if we use Class instead of functions, we can bypass the already taken names of functions and name them more simply e.g. adminPage() instead of ourPluginSettingsLink()
class WordCountAndTimePlugin { 
    function __construct() {
        add_action( 'admin_menu', array($this, 'adminPage') );

        // Save our preferences to the WP database by creating rows that will house our preferences
        add_action('admin_init', array($this, 'settings'));

    }

    // L123
    function settings() {
        
        add_settings_section( 'wcp_first_section', null, null,  'word-count-settings-page');

        // This will build the HTML input field for our form
        add_settings_field( 'wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section'  ); // arg1 - second arg of register_setting ; arg2 - HTML label text; arg3 - function that will display our HTML; arg4 - forth arg of adminPage(); arg5 - section we want to add this field to

        // This will set the DB row
        register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0')); // arg2 - actual name of the setting; arg3 - array (el1 - sanitization callback; el2 - default value)
    }

    function locationHTML() { ?>
        <select name="wcp_location" >
            <option value="0">Beginning of post</option>
            <option value="1">End of post</option>
        </select>
    <?php }

    function adminPage() {
        // add_options_page will add a new Settings Page Link in the WP Admin/Settings/dropdown
        add_options_page( 'Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'ourHTML'), 0 ); // arg1 - the title of the plugin, used in the Tab of the browser ; arg2 - the title that will appear in WP Admin/Settings (dropdown menu) ; arg3 - who is authorized to use this plugin - 'manage_options' - means only if the user is allowed to manage options should they see this page AKA is admin; arg4 - slug (must be unique) - what will be used at the end of the URL for our new Settings page; arg5 - callback function that will output the HTML of the Settings page; arg6 - in which position of the dropdown should the new Settings Page appear - 0 means first
    }
    
    function ourHTML() { ?>
        <div class="wrap">
            <h1>Word Count Settings</h1>
            <form action="options.php" method="POST">
                <?php 
                    settings_fields( 'wordcountplugin' );
                    do_settings_sections('word-count-settings-page');
                    submit_button();
                ?>
            </form>
        </div>
    <?php }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();








// add_filter( 'the_content', 'addToEndOfPost'); // this function filters the_content of every post type

// function addToEndOfPost($content) { 
//     if(is_page() && is_main_query()) { // sometimes a template might loop through secondary posts and display the <p> in extra places [121/9:00] ; another possible check is is_single(), it will work for any details screen for any posts type except page and attachment
//         return $content . '<p>My name is Teo</p>';
//     }

//     return $content;
// }


?>