## filters.php

The filters.php file is where you centralize all your filter and action hooks that you want to apply throughout your theme.

#### Example Use Case

Let's break it down with an example:

-   1. Add a Custom Filter for Title: This example shows how to filter the title of a post before it’s displayed.

```php
// app/filters.php

use Roots\Acorn\Application;

add_filter('the_title', function($title) {
    if (is_singular('post')) {
        $title = 'Custom Title: ' . $title; // Modify the post title
    }
    return $title;
});
```

-   2. Add a Custom Action Hook for Footer: This example adds custom content right before the footer closes.

```php
// app/filters.php

add_action('wp_footer', function() {
    echo '<div class="custom-footer-message">Thank you for visiting!</div>';
});
```

In this case, the action wp_footer is used to add custom HTML just before the closing </footer> tag in your theme.

-   3. Modify the Query for Posts (Filter Example): Suppose you want to modify the main query for a specific page, like the archive page for a custom post type.

```php
// app/filters.php

add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('custom_post')) {
        $query->set('posts_per_page', 10); // Limit the posts per page on the custom post type archive
    }
});
```

Here, we use the pre_get_posts action to modify the main query for the custom post type archive.

-   4. Redirecting Non-Logged-in Users (Action): You can use actions to perform tasks based on certain conditions.

```php
// app/filters.php

add_action('template_redirect', function() {
    if (!is_user_logged_in() && is_page('restricted-page')) {
        wp_redirect(home_url('/login')); // Redirect to the login page if not logged in
        exit();
    }
});
```

## Service Provider VS filters.php

### When to Use a ServiceProvider

Service providers are generally used to register and boot services that your application will use—whether that's registering custom post types (CPTs), taxonomies, or third-party libraries, or hooking into specific WordPress functionality like ACF, WooCommerce, etc.

However, if your filters and actions are highly specific to the theme and are more about hooking into WordPress core functionality, it is still perfectly fine to put them in the filters.php file.

### Putting Filters/Actions in ServiceProviders

You’d use a ServiceProvider for your filters/actions if:

-   They are part of a larger functionality or service (e.g., custom gateways for WooCommerce, custom fields with ACF, etc.).
-   You want to organize your code around logical services, which helps when the theme grows larger and more complex.
-   You’re dealing with things that can be easily registered and bootstrapped as part of your application’s core (e.g., custom functionality tied to your theme or plugin). Here’s an example of what this could look like in a service provider:

### Example: Putting Filters and Actions in a ServiceProvider

Let’s say you have a custom theme feature that adds custom user profile fields, and you want to use filters and actions to hook into it. You could structure it like this:

ServiceProvider for Custom User Profile Fields:

```php
namespace App\Providers;

use Roots\Acorn\ServiceProvider;

class UserProfileServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register custom post types, taxonomies, etc. here (if applicable)
    }

    public function boot()
    {
        // Filter to modify the user profile fields
        add_filter('user_contactmethods', function($methods) {
            $methods['custom_field'] = 'Custom Field';
            return $methods;
        });

        // Action to save custom field data when the user profile is updated
        add_action('personal_options_update', [$this, 'save_custom_user_fields']);
        add_action('edit_user_profile_update', [$this, 'save_custom_user_fields']);
    }

    public function save_custom_user_fields($user_id)
    {
        if (isset($_POST['custom_field'])) {
            update_user_meta($user_id, 'custom_field', sanitize_text_field($_POST['custom_field']));
        }
    }
}
```

Should You Always Use ServiceProviders for Filters/Actions?

-   Small/Specific Logic: If your filters/actions are small or specific to a template or a single page, it’s fine to keep them in filters.php. You don’t need to over-complicate things by creating a service provider for every small thing.

-   Modular/Reusable Logic: If you have larger or more reusable functionality that could be grouped together, like a set of custom fields, custom post types, or plugin integrations (e.g., WooCommerce payment gateways), then a ServiceProvider is a good choice. It helps you organize your code better and makes it easier to manage as your theme grows.

### Pros of Using ServiceProviders for Filters/Actions:

-   Better Organization: Especially as your project grows, keeping functionality organized inside service providers (with boot() and register()) helps.
-   Code Reusability: If you need to reuse or extend certain functionality, a service provider makes it easier.
-   Single Responsibility Principle: Each service provider can handle a single part of the functionality, so it can be more maintainable.

### Pros of Keeping Filters/Actions in filters.php:

-   Simplicity: For small, straightforward functionality, keeping filters and actions in filters.php is simple and fast.
-   Less Overhead: It can be quicker to implement and requires less boilerplate code (no need to create a service provider class for small tasks).

### Conclusion

-   For Small Theme-Specific Filters/Actions: Use filters.php.
-   For More Complex or Reusable Functionality: Consider using a ServiceProvider to organize your code in a more structured way.

## Other Examples of what to put in filters.php

```php
// app/filters.php
use Roots\Acorn\Application;

// Example: Add a custom class to the body tag
add_filter('body_class', function($classes) {
    $classes[] = 'custom-class';
    return $classes;
});

// Example: Modify the WordPress login page URL
add_filter('login_headerurl', function() {
    return home_url();  // Redirects the login page to your homepage
});

// Example: Add a custom action to WooCommerce checkout
add_action('woocommerce_checkout_update_order_meta', function($order_id) {
    if ($_POST['custom_field']) {
        update_post_meta($order_id, '_custom_field', sanitize_text_field($_POST['custom_field']));
    }
});

// Add a custom message after the product description
add_action('woocommerce_after_single_product_summary', function() {
    echo '<p class="custom-message">This is a custom message after the product description!</p>';
}, 20);  // '20' is the priority, which determines the order (default is 10)


// Add a custom field to the checkout page
add_action('woocommerce_checkout_fields', function($fields) {
    $fields['billing']['billing_custom_field'] = array(
        'label' => __('Custom Field', 'woocommerce'),
        'placeholder' => __('Enter something here', 'woocommerce'),
        'required' => false,
        'class' => array('form-row-wide'),
        'clear' => true,
    );
    return $fields;
});


// Add a custom message above the cart contents
add_action('woocommerce_before_cart', function() {
    echo '<p class="custom-promotion">Get 10% off when you buy two or more items!</p>';
});

// Add a custom message to the order received page
add_action('woocommerce_thankyou', function($order_id) {
    if ($order_id) {
        echo '<p class="thank-you-message">Thank you for your purchase! We appreciate your business.</p>';
    }
}, 10, 1);  // $order_id is passed to the callback function


// Display custom text before the product title in the product loop
add_action('woocommerce_shop_loop_item_title', function() {
    echo '<p class="custom-text">Special Offer!</p>';
}, 5);  // Priority is set to 5 so it runs before the product title


```

## if we'd like to move all actions into a seperate file, we create an actions.php and add it to the colletion inside of functions.php

```php
// /app
//   -myactions.php


// functions.php
collect(['setup', 'filters', 'myactions'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });
```
