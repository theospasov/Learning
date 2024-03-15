<?php 
/*
    Plugin Name: Our Word Filter Plugin
    Description: Replaces a list of words
    Version: 1.0
    Author: Teo
*/

if (! defined('ABSPATH')) exit; // L127

class OurWorFilterPlugin {
    function __construct() {
        add_action( 'admin_menu', array($this, 'ourMenu') );
    }

    function ourMenu() {
        add_menu_page('Words to Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'), 'dashicons-smiley', 20);
        add_submenu_page( 'ourwordfilter', 'Words to Filter', 'Words List', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'));
        add_submenu_page( 'ourwordfilter', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionSubPage'));
    }

    function optionSubPage() { ?>
        Hello world from options
    <?php }

    function wordFilterPage() { ?>
        Hello world
    <?php }
}

$ourWorFilterPlugin = new OurWorFilterPlugin();