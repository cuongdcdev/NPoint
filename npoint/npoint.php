<?php
/**
 * Plugin Name: NPoint - Web3 Loyalty system #builtOnNear
 * Description: 
 * Author: @cuongdc_real
 * Author URI: https://twitter.com/cuongdc_real
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: nsub
 */
const NSUB_DOMAIN = "nsub";

require_once("const.php");
require_once("inc/lib.php");
require_once("inc/run-nodejs.php");
require_once("inc/endpoint.php");
require_once("inc/shortcode.php");
require_once("inc/metabox.php");
require_once("inc/admin/scripts.php");

// if (!class_exists("RationalOptionPages")) {
//     require_once("inc/admin/RationalOptionPages.php");
// }
// require_once("inc/admin/ui-settings.php");

//enqueue scripts 
add_action("wp_enqueue_scripts","nsub_scripts");
add_action("login_enqueue_scripts" , "nsub_scripts");
function nsub_scripts(){
    wp_enqueue_style("nsubstyle", plugin_dir_url(__FILE__) . "asset/dist/index.css");
    wp_enqueue_script("nsubscript", plugin_dir_url(__FILE__) . "asset/dist/index.js");
    wp_enqueue_script("nsubajax", plugin_dir_url(__FILE__) . "asset/nsub_ajax.js", ["jquery"]);
    $nsubArr = [
        "ajaxUrl" => admin_url("admin-ajax.php"),
        "nonce" => wp_create_nonce("near-login"),
        "isSignedIn" => is_user_logged_in(),
    ];
    $nonceContent = false;

    if (is_single() || isset($_GET["transactionHashes"]) && is_single()) {
        $nonceContent =  wp_create_nonce("nsub-content");
        $nsubArr["pid"] =  get_the_ID();
        $nsubArr["nonce_content"] =  $nonceContent;
        $nsubArr["postConfig"] = nsub_get_post_config($nsubArr["pid"]);
        $nsubArr["postConfig"]["owner_address"] = get_option("nsub_page_main")["owner_wallet"];
    }
    if (is_user_logged_in()) {
        $nsubArr["nonce"] = wp_create_nonce("near-logout");
        
    }

    wp_localize_script("nsubajax", "nsubObject", $nsubArr);
}

//login with NEAR after login form 
add_action('login_form', function(){
    echo do_shortcode("[nsub_login]");
});

