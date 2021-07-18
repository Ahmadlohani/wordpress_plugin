<?php

/**
 * @package InstaUserAPi   
*/
/*
Plugin Name: Insta User Api 
Description: This plugin is used to fetch User Instagram Data
Author: Ahmad Hassan Khan
Text Domain: Insta User-Api
*/  
defined("ABSPATH") or die("You cannot access to this file!!!");

define ("PLUGIN_PATH", plugin_dir_path( __FILE__ ));
define ("PLUGIN_URL", plugin_dir_url( __FILE__ ));

include PLUGIN_PATH. "include/checkfields.php";
include PLUGIN_PATH. "user_ajax_controller.php";

$api = new InstaUserApi();
$api->registerScripts();
$api->ajax_action();
register_activation_hook(__FILE__, array($api, "activation_hook_func"));
register_deactivation_hook(__FILE__, array($api, "deactivation_hook_func"));
