<?php 
/*
    Plugin Name: Our Word Filter Plugin
    Description: Replaces a list of words
    Version: 1.0
    Author: Teo
*/

if (! defined('ABSPATH')) exit; // L127 | Prevents outsiders to trigger our plugin by visiting it's slug

class OurWorFilterPlugin {
    function __construct() {
        add_action( 'admin_menu', array($this, 'ourMenu') );
        add_action( 'admin_init', array($this, 'ourSettings') );
        
        if(get_option( 'plugin_words_filter' )) add_filter('the_content', array($this, 'filterLogic'));
        
    }

    function ourSettings() {
        add_settings_section( 'replacement-text-section', null, null, 'word-filter-options');
        register_setting('replacementFields', 'replacementText');
        add_settings_field( 'replacement-text', 'Filtered Text', array($this, 'replacementFieldHTML'), 'word-filter-options', 'replacement-text-section');
    }

    function replacementFieldHTML() { ?>
        <input type="text" name="replacementText" value="<?php echo esc_attr(get_option('replacementText', '***')) ?>">
        <p class="description">Leave blank to remove the filtered words</p>
    <?php }

    function filterLogic($content) {
        $badWords = explode(',', get_option('plugin_words_filter'));
        $badWordsTrimmed = array_map('trim', $badWords);
        return str_replace($badWordsTrimmed, esc_html( get_option( 'replacementText', '***' ) ), $content);
    }

    function ourMenu() {
        $mainPageHook = add_menu_page('Words to Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'), 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+Cg==', 20);
        // add_menu_page('Words to Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'), plugin_dir_url(__FILE__) . 'custom.svg', 20);
        add_submenu_page( 'ourwordfilter', 'Words to Filter', 'Words List', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'));
        add_submenu_page( 'ourwordfilter', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionSubPage'));
        // Adding Custom CSS to the Word Filter Page
        add_action("load-{$mainPageHook}", array($this, 'mainPageAssets'));
    }

    function mainPageAssets() {
        wp_enqueue_style('filterAdminCSS', plugin_dir_url(__FILE__) . 'styles.css');
    }

    function optionSubPage() { ?>
        <div class="wrap">
            <h1>Word Filter Options</h1>
            <form action="options.php" method="POST">
                <?php 
                    settings_errors();
                    settings_fields('replacementFields');
                    do_settings_sections('word-filter-options');
                    submit_button();
                ?>
            </form>
        </div>
    <?php }

    function handleForm() {
       if(wp_verify_nonce( $_POST['ourNonce'], 'saveFilterWords') && current_user_can('manage_options')) {
            update_option('plugin_words_filter', sanitize_text_field( $_POST['plugin_words_to_filter'] )); ?>
            <div class="updated">
                <p>Your filered words were saved</p>
            </div>
        <?php } else { ?>
            <div class="error">
                <p>Sorry, you don't have permission to perform this action</p>
            </div>
       <?php }
        
    }

    function wordFilterPage() { ?>
        <div class="wrap">
            <h1>Word Filter</h1>
            <?php if($_POST['justsubmitted'] == "true") $this->handleForm() ?>
            <form method="POST">
                <input type="hidden" name="justsubmitted" value="true">
                <?php wp_nonce_field( 'saveFilterWords', 'ourNonce' ) ?>
                <label for="plugin_words_to_filter"><p>Enter a <strong>comma-separated</strong> list of words to filter</p></label>
                <div class="word-filter__flex-container">
                    <textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="bad, awful"><?php echo esc_textarea( get_option( 'plugin_words_filter' ) ) ?></textarea>  
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </form>
        </div>
    <?php }
}

$ourWorFilterPlugin = new OurWorFilterPlugin();