# Custom JavaScript Enqueue with Localization Example

This example demonstrates how to enqueue custom JavaScript files in WordPress, register scripts, localize data to be used in the scripts, and conditionally deregister scripts for specific pages. We will also show how to pass localized data from PHP to JavaScript files for use in your frontend.

### 1. Enqueuing Custom JavaScript in WordPress

In this example, we are going to enqueue two custom JavaScript files:

\_yo.js: A script that is registered and localized with an object in PHP. \_blah.js: A dependent script that relies on the \_yo.js script and accesses the localized object.

#### functions.php

```php
add_action('wp_enqueue_scripts', 'enqueue_custom_js');

function enqueue_custom_js() {

    // Register 'yo' JS (this will just register the script, not load it)
    wp_register_script('yo', get_template_directory_uri() . '_yo.js', [], '1.0', true);

    // Localize 'yo' JS (this will pass PHP data to the JS)
    wp_localize_script('yo', 'OBJECT_NAME', [
        'param1' => 'value1',
        'param2' => 'value2'
    ]);

    // Enqueue 'blah' JS (this will load the script and also the 'yo' script as a dependency)
    wp_enqueue_script('blah', get_template_directory_uri() . '_blah.js', ['yo'], '1.0', true);

    // Deregister 'yo' JS if the page is 'not-yo'
    if (is_page('not-yo')) wp_deregister_script('yo');
}
```

#### Breakdown:

##### Registering the Script:

```php
wp_register_script('yo', get_template_directory_uri() . '_yo.js', [], '1.0', true);
```

This registers the \_yo.js script without loading it yet.

##### Localizing the Script:

```php
wp_localize_script('yo', 'OBJECT_NAME', [ 'param1' => 'value1', 'param2' => 'value2' ]);
```

This will pass the PHP array to JavaScript as a global object, making OBJECT_NAME.param1 and OBJECT_NAME.param2 available in your scripts.

##### Enqueuing the Script:

```php
wp_enqueue_script('blah', get_template_directory_uri() . '_blah.js', ['yo'], '1.0', true);
```

This enqueues the \_blah.js script and makes \_yo.js a dependency, ensuring that \_yo.js loads first. Conditionally Deregistering the Script:

##### If the page is 'not-yo', we deregister the yo script to prevent it from loading.

```php
if (is_page('not-yo')) wp_deregister_script('yo');
```

---

### 2. JavaScript File

## \_yo.js

This is the script that contains the localized object.

```js
// Console the file name
console.log('file name:', __filename);

// Get the localized object
console.log('Localized Object: ', OBJECT_NAME);
```

#### In \_yo.js, you’ll see:

The file name is logged using \_\_filename, which is a Node.js feature but doesn't apply here in the browser. The localized object OBJECT_NAME is logged, which will show the values passed from PHP (param1 and param2).

---

## \_blah.js

This script is dependent on \_yo.js, and it can access the localized object if \_yo.js is loaded.

```js
console.log('file name:', __filename);

// Will be undefined as the object is not defined in this file but in the dependent file
console.log('Localized Object: ', OBJECT_NAME);
```

In \_blah.js, the localized object OBJECT_NAME will be logged if \_yo.js is loaded first. However, if \_yo.js isn't loaded (for example, if you're on the 'not-yo' page), the object will be undefined.

---

### 3. How the Example Works

##### When the page loads:

-   WordPress first checks if the page is not-yo.
-   If it’s not not-yo, it registers and localizes the script \_yo.js.
-   Then, it enqueues \_blah.js, which depends on \_yo.js.
-   The localized object OBJECT_NAME with properties param1 and param2 is passed from PHP to JavaScript, and both \_yo.js and \_blah.js can access it.
-   On the 'not-yo' page:

*   If you visit the page with the slug 'not-yo', \_yo.js will be deregistered and will not be loaded, meaning \_blah.js will load without access to the localized object OBJECT_NAME.

---

### 4. Key Functions Used

-   wp_register_script(): Registers a script but doesn't load it.
-   wp_localize_script(): Localizes a script with data, passing a JavaScript object to the script.
-   wp_enqueue_script(): Enqueues a script to be loaded on the page, allowing dependencies to be set.
-   wp_deregister_script(): Deregisters a script, preventing it from being loaded.

---

### 5. Conclusion

This example demonstrates how to manage custom JavaScript in WordPress with conditional loading, script dependencies, and localization. By localizing a script, you can pass dynamic PHP data to JavaScript and use it within the frontend.
