<?php

if (!defined('ABSPATH'))
    exit;

if (!class_exists('IM_INIT')) {
    class IM_INIT
    {
        public function __construct()
        {
            add_action('wp_enqueue_scripts', [$this,  'add_itz_modal_scripts_css']);
            add_action('wp_footer', [$this,  'itz_modal']);

            // Ajax for newsletter 
            add_action('wp_ajax_nopriv_custom_script_name', [$this, 'itz_newsletter_ajax']);
            add_action('wp_ajax_custom_script_name', [$this, 'itz_newsletter_ajax']);
        }

        /**
         * load the css and javascript for newsletter :)
         */
        public function add_itz_modal_scripts_css()
        {
            // Load styles 
            wp_enqueue_style('itz-modal-css', IM_URL . '/assets/css/itz-modal.css', array(), IM_VER);

            // Load Scripts 
            wp_enqueue_script('itz-modal-js', IM_URL . '/assets/js/itz-modal.js', array('jquery'), IM_VER, true);
            wp_localize_script(
                'itz-modal-js',
                'itz_ajax_object',
                array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('itz-nonce')
                )
            );
        }

        /**
         * Added modal to footer
         */
        public function itz_modal()
        {
            include IM_PATH . '/templates/itz-modal.php';
        }


        /**
         * Submit newsletter to DB :)
         */
        public function itz_newsletter_ajax()
        {
            $nonce = $_POST['nonce'] ?? '';
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';

            $res = [
                'success' => false,
            ];

            if (empty($nonce) || empty($name) || empty($email)) {
                $res['error'] = 'Missing data';
                wp_send_json($res);
                exit;
            }

            if (!wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
                die('Busted!');
            }
        }
    }

    new IM_INIT;
}
