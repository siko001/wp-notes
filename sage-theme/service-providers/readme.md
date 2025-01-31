## Service Providers
A Service Provider in Sage is just a class where you register and boot things for your theme or plugin. It’s a central point for setting up everything that needs to be loaded when WordPress starts. Think of it as a manager that organizes how your code gets loaded and when.

```php
namespace App\Providers;

use Roots\Acorn\ServiceProvider;

class MyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register services or bind things into the container
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Run any setup or functionality when Sage boots
    }
}
```

-   Register: This is where you register things like custom functionality.
-   -   Anything that extends or interacts directly with WordPress Core (like CPTs, taxonomies, options pages, or custom WooCommerce actions/filters) goes in register().

-   Boot: This is where things actually run once everything is set up.
-   -   Anything that hooks into actions/filters or executes logic (like setting up ACF fields, custom hooks, or adding WooCommerce custom functionality that runs after everything is booted) goes in boot().

#### Why Use It?

-   Organize your code: Keeps things clean and structured.
-   Automatic loading: Once registered, it’s automatically loaded by Sage—no need to manually include files.
-   Lazy loading: You can load only what you need when needed (performance boost).
-   Scalability: It’s easy to add new features by simply creating new providers without cluttering the codebase.

A Service Provider in Sage is just a class where you register functionality (like ACF fields, WooCommerce customizations, etc.). Sage loads it for you automatically when the theme boots, keeping your code organized, scalable, and clean.

### Example creating custom payment gateway for woocommerce

-   1️⃣ Create a service provider (e.g., CustomPaymentServiceProvider.php).
-   2️⃣ Inside boot(), register all WooCommerce hooks and filters.
-   3️⃣ Register the provider in config/app.php, so Sage loads it.

```php
namespace App\Providers;

use Roots\Acorn\ServiceProvider;

class CustomPaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_filter('woocommerce_payment_gateways', function ($gateways) {
            $gateways[] = 'WC_Gateway_Custom'; // Register your custom gateway class
            return $gateways;
        });

        add_action('plugins_loaded', function () {
            require_once get_template_directory() . '/woocommerce/gateways/class-wc-gateway-custom.php';
        });
    }
}
```

##### config/app.php

```php
'providers' => [
    App\Providers\CustomPaymentServiceProvider::class,
]
```

### Example of creating CPT, taxonomy and fields using ACF

```php
namespace App\Providers;

use Roots\Acorn\ServiceProvider;
use function Roots\acf\acf_add_local_field_group;

class ACFServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register a Custom Post Type (CPT)
        $this->register_cpt();

        // Register a Custom Taxonomy
        $this->register_taxonomy();

        // Register Options Page
        $this->register_options_page();
    }

    public function boot()
    {
        // Add fields to ACF for different locations

        // Location 1: Fields for the Custom Post Type
        acf_add_local_field_group([
            'key' => 'group_cpt_fields',
            'title' => 'Custom Post Type Fields',
            'fields' => [
                [
                    'key' => 'field_cpt_text',
                    'label' => 'Text Field for CPT',
                    'name' => 'cpt_text_field',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_cpt_image',
                    'label' => 'Image Field for CPT',
                    'name' => 'cpt_image_field',
                    'type' => 'image',
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'custom_post',
                    ]
                ]
            ],
        ]);

        // Location 2: Fields for the Taxonomy
        acf_add_local_field_group([
            'key' => 'group_taxonomy_fields',
            'title' => 'Taxonomy Fields',
            'fields' => [
                [
                    'key' => 'field_taxonomy_description',
                    'label' => 'Description for Taxonomy',
                    'name' => 'taxonomy_description',
                    'type' => 'textarea',
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'custom_taxonomy',
                    ]
                ]
            ],
        ]);

        // Location 3: Fields for the Options Page
        acf_add_local_field_group([
            'key' => 'group_options_page_fields',
            'title' => 'Options Page Fields',
            'fields' => [
                [
                    'key' => 'field_option_color',
                    'label' => 'Color Option',
                    'name' => 'option_color',
                    'type' => 'color_picker',
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme_options',
                    ]
                ]
            ],
        ]);

        // Location 4: Fields for the Block
        acf_add_local_field_group([
            'key' => 'group_block_fields',
            'title' => 'Block Fields',
            'fields' => [
                [
                    'key' => 'field_block_text',
                    'label' => 'Text Field for Block',
                    'name' => 'block_text_field',
                    'type' => 'text',
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/custom_block',
                    ]
                ]
            ],
        ]);

        // Location 5: Fields for a specific Page
        acf_add_local_field_group([
            'key' => 'group_page_fields',
            'title' => 'Page Fields',
            'fields' => [
                [
                    'key' => 'field_page_text',
                    'label' => 'Text Field for Page',
                    'name' => 'page_text_field',
                    'type' => 'text',
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'page',
                        'operator' => '==',
                        'value' => '123',  // Page ID
                    ]
                ]
            ],
        ]);
    }

    private function register_cpt()
    {
        // Register Custom Post Type
        $args = [
            'label' => 'Custom Posts',
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
        ];
        register_post_type('custom_post', $args);
    }

    private function register_taxonomy()
    {
        // Register Custom Taxonomy
        $args = [
            'label' => 'Custom Taxonomy',
            'public' => true,
            'show_in_rest' => true,
            'hierarchical' => true,
        ];
        register_taxonomy('custom_taxonomy', 'custom_post', $args);
    }

    private function register_options_page()
    {
        // Register an Options Page for ACF
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Theme Options',
                'menu_title' => 'Theme Options',
                'menu_slug' => 'theme_options',
                'capability' => 'edit_posts',
                'redirect' => false,
            ]);
        }
    }
}
```
