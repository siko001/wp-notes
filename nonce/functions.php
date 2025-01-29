
<?php
// Action handler for the nonce link
add_action('admin_post_my_action', 'handle_my_action');

function handle_my_action() {
    // Verify the nonce
    if (isset($_GET['nonce']) && wp_verify_nonce($_GET['nonce'], 'my_nonce_action')) {
        // Nonce is valid, proceed with the action
        echo 'Action successfully performed!';
    } else {
        // Nonce verification failed
        echo 'Error: Invalid nonce';
    }
    wp_die(); // Always call wp_die() after the request is processed
}
?>