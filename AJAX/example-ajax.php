<?php

/**
 * Plugin Name: WP AJAX Form Nonce Example (Vanilla JS)
 * Description: A simple example of using AJAX with a form and nonce in WordPress.
 * Version: 1.0
 * Author: Your Name
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// 1️⃣ Enqueue JavaScript and Localize Nonce
function enqueue_my_ajax_script() {
    wp_enqueue_script('my-ajax-script', plugin_dir_url(__FILE__) . 'ajax.js', [], null, true);

    wp_localize_script('my-ajax-script', 'myAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('my_ajax_nonce') // Send nonce to JS
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_my_ajax_script');

// 2️⃣ AJAX Handler Function
function my_ajax_function() {
    // Check nonce for security
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'my_ajax_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce!']);
    }

    // Simulate form processing
    $name = sanitize_text_field($_POST['name']);
    wp_send_json_success(['message' => "Form submitted successfully! Hello, $name!"]);
}

// 3️⃣ Hook into AJAX actions
add_action('wp_ajax_my_ajax_action', 'my_ajax_function');
add_action('wp_ajax_nopriv_my_ajax_action', 'my_ajax_function'); // For non-logged-in users
