<?php

if (!defined('ABSPATH'))
    exit;

add_action('init', 'start_session', 1);
function start_session()
{
    if (!session_id()) {
        session_start();
    }
}

// Ajax for newsletter
add_action('wp_ajax_nopriv_itz_newsletter', 'itz_newsletter_ajax');
add_action('wp_ajax_itz_newsletter', 'itz_newsletter_ajax');


/**
 * Submit newsletter to DB :)
 */
function itz_newsletter_ajax()
{
    $nonce = $_POST['nonce'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    $res = [
        'success' => false,
    ];

    // If some data is missing
    if (empty($nonce) || empty($name) || empty($email)) {
        $res['error'] = 'Missing data';
        wp_send_json($res);
        exit;
    }

    // If nonce is not validated
    if (!wp_verify_nonce($nonce, 'itz-nonce')) {
        $res['error'] = 'No valid nonce found';
        wp_send_json($res);
        exit;
    }

    global $wpdb;
    $itz_newsletter = $wpdb->prefix . 'itz_newsletter';  // table name
    $wpdb->insert($itz_newsletter, array(
        'name' => sanitize_text_field($name),
        'email' => sanitize_text_field($email),
    ));


    setcookie("itz_subscribed", "yes", 2147483647, '/', $_SERVER['HTTP_HOST']);



    $res['success'] = true;
    wp_send_json($res);
    exit;
}
