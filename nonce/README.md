---

### WordPress Nonce Example

#### Overview

A nonce is a security token used in WordPress to protect your site from certain types of attacks. It ensures that requests to perform actions are coming from a legitimate source. This guide explains how to generate, verify, and use a nonce with a basic example.

### 🛠️ Simple Example of Nonce Creation and Verification

1. Creating a Nonce You’ll generate a nonce using the wp_create_nonce() function. This is typically used when displaying a form or preparing a URL with an action that needs to be secured.

##### Example:

```php
// Generate a nonce
$nonce = wp_create_nonce('my_nonce_action');

<!-- Create a link with the nonce included -->
<a href="<?= admin_url('admin-post.php?action=my_action&nonce=' . $nonce) ?>">Click to Perform Action</a>'
```

##### Explanation:

wp_create_nonce('my_nonce_action') generates a nonce that’s tied to the my_nonce_action action. The nonce is then appended to a link that points to admin-post.php, which is a WordPress handler for custom actions.

2. Verifying the Nonce When the link is clicked, WordPress will process the request. On the server side, you need to verify that the nonce is valid using wp_verify_nonce(). This ensures the action is legitimate and that it's not a malicious request.

##### Example: Verifying the Nonce on the Server

```php
// Action handler for the nonce link
add_action('admin_post_my_action', 'handle_my_action');

function handle_my_action() {
    // Verify the nonce
    if ( isset($_GET['nonce']) && wp_verify_nonce($_GET['nonce'], 'my_nonce_action') ) {
        // Nonce is valid, proceed with the action
        echo 'Action successfully performed!';
    } else {
        // Nonce verification failed
        echo 'Error: Invalid nonce';
    }
    wp_die(); // Always call wp_die() after the request is processed
}
```

##### Explanation:

wp_verify_nonce($\_GET['nonce'], 'my_nonce_action') checks the validity of the nonce. If the nonce is valid, you can proceed with the desired action (in this case, just displaying a success message). If the nonce is invalid, it outputs an error message.

3. Basic Flow

#### Here’s a quick recap of the steps:

-   Generate the nonce: Use wp_create_nonce() to create a security token and include it in your form or URL.
-   Include the nonce in the request: Add the nonce to your URL or form (in the case of a form, use a hidden input).
-   Verify the nonce: When the request is made, use wp_verify_nonce() on the server side to ensure the request is legitimate.
-   Proceed with the action: If the nonce is valid, perform the action (e.g., save data, perform an operation); if invalid, display an error.
-   Conclusion
-   This simple example demonstrates how to create and verify a nonce in WordPress. By using nonces, you ensure that actions on your website are secure and only triggered by legitimate requests. Always verify nonces when processing actions to prevent unauthorized activity.
