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
            // $is_subscribed = $_SESSION['itx_subscribed'] ?? '';
            $is_subscribed = $_COOKIE['itz_subscribed'] ?? '';
            if ($is_subscribed === 'yes') return;

            include IM_PATH . '/templates/itz-modal.php';
        }
    }

    new IM_INIT;
}
