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


//  On activation create new table to store the itz newsletter 
register_activation_hook(__FILE__, 'itz_activation');
function itz_activation()
{
    global $wpdb;
    $db_table_name = $wpdb->prefix . 'itz_newsletter';  // table name
    $charset_collate = $wpdb->get_charset_collate();

    // Check to see if the table exists already, if not, then create it
    if ($wpdb->get_var("show tables like '$db_table_name'") != $db_table_name) {
        // Table to keep user Buy and reedeem status
        $sql = "CREATE TABLE $db_table_name (
                id int(11) NOT NULL auto_increment,
                name varchar(255) NOT NULL,
                email varchar(255) NOT NULL,
                date datetime NOT NULL DEFAULT current_timestamp(),
                UNIQUE KEY id (id)
          ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
