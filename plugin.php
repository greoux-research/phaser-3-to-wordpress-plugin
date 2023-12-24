<?php

/**
 * @package pwp
 * @version 1.0
 **/

/**
Plugin Name: Phaser 3 to WordPress
Plugin URI: https://greoux.re/code/index.php/phaser-3-to-wordpress-plugin/
Description: Insert a phaser.io-based game in your WordPress posts and pages with a simple shortcode: [pwp].
Author: Gréoux Research
Version: 1.0
Author URI: https://greoux.re
**/

/* --- */

if (!function_exists("add_action")) {

    exit;

}

/* --- */

define("GREOUXRE_PWP_URL", plugin_dir_url(__FILE__));
define("GREOUXRE_PWP_DIR", plugin_dir_path(__FILE__));

/* --- */

$GREOUXRE_PWP_CAN_BE_LOADED = 0;

function GREOUXRE_PWP_TEMPLATE_REDIRECT()
{
    global $GREOUXRE_PWP_CAN_BE_LOADED;

    if ((is_page() or is_single()) and (strpos(get_post(get_the_ID())->post_content, "[pwp]") !== false)) {

        $GREOUXRE_PWP_CAN_BE_LOADED = 1;

    }

}

add_action("template_redirect", "GREOUXRE_PWP_TEMPLATE_REDIRECT");

/* --- */

function GREOUXRE_PWP_WP_ENQUEUE_SCRIPTS()
{

    global $GREOUXRE_PWP_CAN_BE_LOADED;

    if ($GREOUXRE_PWP_CAN_BE_LOADED === 1) {

        wp_enqueue_script("jquery");

        wp_enqueue_script(
            "phaser3",
            GREOUXRE_PWP_URL . "assets/phaser@3.55.2/phaser.min.js"
        );

        wp_enqueue_script(
            "pwp",
            GREOUXRE_PWP_URL . "assets/game@1.0/game.js",
            array("jquery", "phaser3")
        );

    }

}

add_action("wp_enqueue_scripts", "GREOUXRE_PWP_WP_ENQUEUE_SCRIPTS");

/* --- */

function GREOUXRE_PWP_HTM($atts)
{

    global $GREOUXRE_PWP_CAN_BE_LOADED;

    if ($GREOUXRE_PWP_CAN_BE_LOADED === 1) {

        return "<div id='pwp' style='height: 100%; max-width: 600px; margin: 2rem auto; overflow: hidden;' data-path='" . GREOUXRE_PWP_URL . "assets/game@1.0/'></div>";

    } else {

        return "";

    }

}

add_shortcode("pwp", "GREOUXRE_PWP_HTM");

/* --- */
