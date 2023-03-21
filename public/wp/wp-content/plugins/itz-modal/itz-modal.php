<?php

/**
 *
 *
 * @link              https://google.com
 * @since             1.0.0
 * @package           Itz_Modal
 *
 * @wordpress-plugin
 * Plugin Name:       Newsletter Opt-In Modal
 * Plugin URI:        https://google.com
 * Description:       Newsletter opt-in Plugin
 * Version:           1.0.0
 * Author:            Tirtha Ray
 * Author URI:        https://google.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       itz-modal
 * Domain Path:       /languages
 */


if (!defined('ABSPATH'))
    exit;

if (!defined('IM_VER'))
    define('IM_VER', time()); // define the plugin version

if (!defined('IM_URL'))
    define('IM_URL', plugin_dir_url(__FILE__)); // define the plugin url

if (!defined('IM_PATH'))
    define('IM_PATH', plugin_dir_path(__FILE__)); // define the plugin path


require IM_PATH . 'controller/ajax.php'; // init all ajax
require IM_PATH . 'controller/public-init.php'; // init fronted plugins