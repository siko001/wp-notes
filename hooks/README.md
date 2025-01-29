# WordPress Actions & Filters with Parameters

## Overview

In WordPress, actions and filters allow you to hook into WordPress's core functionality to run custom code at specific points during the execution of WordPress. These hooks can also pass data, which allows you to customize behavior dynamically.

-   Actions (do_action() / add_action()): These allow you to run functions at specific points, with optional parameters passed along.
-   Filters (apply_filters() / add_filter()): These allow you to modify data before it is returned or displayed, with the ability to modify the content dynamically.

##### Action Hook Example:

Let's break this down and understand how actions work when passing optional parameters.

### 1. Using Actions (do_action() and add_action())

## do_action() — Trigger an Action

do_action() is used to trigger an action hook at a specific point in the code. You can also pass data through it to be received by the hooked functions.

### Example: Triggering an Action with Parameters

```php
// Trigger the action with optional parameters
do_action('my_custom_action', 'Optional Text Here');
```

This will trigger any functions hooked to 'my_custom_action'. In this case, 'Optional Text Here' will be passed as a parameter.

## add_action() — Hook a Function to an Action

add_action() is used to hook a function to a specific action, meaning that when the action is triggered, your custom function will run. You can also pass additional arguments to the hooked function.

#### Example: Adding a Custom Function to an Action Hook

```php

// Hook function to 'my_custom_action'
add_action('my_custom_action', 'my_custom_function', 10, 1);

function my_custom_function($text) {
    echo 'Here is the custom text: ' . $text;
}
```

### Breakdown:

## Triggering the Action (do_action()):

do_action('my_custom_action', 'Optional Text Here'); triggers the action hook 'my_custom_action', passing 'Optional Text Here' as a parameter.

## Hooking a Function to the Action (add_action()):

-   add_action('my_custom_action', 'my_custom_function', 10, 1); hooks my_custom_function() to 'my_custom_action'.
-   The function my_custom_function() accepts a parameter ($text) which is passed when the action is triggered.
-   The 10 refers to the priority (how early or late the function runs in relation to other functions hooked to the same action).
-   The 1 indicates the number of arguments the hooked function expects (in this case, just one — $text).

##### Result:

When do_action('my_custom_action', 'Optional Text Here'); is triggered, it will call my_custom_function() with the parameter 'Optional Text Here' and the output will be:

```js
Here is the custom text: Optional Text Here
```

---

### 2. Filters (apply_filters() and add_filter())

Filters allow you to modify data before it’s used or displayed.

-   apply_filters() — Trigger a Filter
-   apply_filters() is used to apply a filter hook to modify a value, passing it to the functions hooked to it.

##### Example: Triggering a Filter

```php
// Apply the filter with a parameter
$modified_text = apply_filters('my_custom_filter', 'Initial Text');
echo $modified_text;

// output: Initial Text
```

This triggers the filter and passes 'Initial Text' to the hooked functions as a variable.

-   add_filter() — Hook a Function to a Filter
-   add_filter() is used to hook a function to a specific filter. The function modifies the data before it's used or returned.

##### Example: Adding a Custom Filter Function

```php
// Hook function to 'my_custom_filter'
add_filter('my_custom_filter', 'modify_text', 10, 1);

function modify_text($text) {
    return $text . ' - Modified by the filter!';
}

// Output: Initial Text - Modified by the filter!
```

if another filter is added to my_custom_filter the new variable text passed will be 'Initial Text - Modified by the filter!'

##### Breakdown:

Applying the Filter (apply_filters()): apply_filters('my_custom_filter', 'Initial Text') triggers the filter 'my_custom_filter', passing 'Initial Text' as a parameter.

Hooking a Function to the Filter (add_filter()): add_filter('my_custom_filter', 'modify_text', 10, 1); hooks the modify_text() function to 'my_custom_filter'.

The function modify_text() accepts a parameter ($text) and modifies it.

##### Result:

When apply_filters('my_custom_filter', 'Initial Text') is called, it will pass 'Initial Text' through the modify_text() function, which appends ' - Modified by the filter!' to it.

##### The final output will be:

```js
Initial Text - Modified by the filter!
```

---

### 3. Multiple Functions with Actions and Filters

You can hook multiple functions to the same action or filter. These functions will execute in the order they were added (priority).

#### Example: Multiple Functions for an Action

```php

add_action('wp_footer', 'footer_function_one');
add_action('wp_footer', 'footer_function_two');

function footer_function_one() {
    echo 'Footer Function One';
}

function footer_function_two() {
    echo 'Footer Function Two';
}
```

#### This will output:

```js
Footer Function One
Footer Function Two
```

#### Example: Multiple Functions for a Filter

```php

add_filter('the_content', 'content_filter_one');
add_filter('the_content', 'content_filter_two');

function content_filter_one($content) {
    return $content . ' - Filter One Applied';
}

function content_filter_two($content) {
    return $content . ' - Filter Two Applied';
}
```

If you apply the filter to some content, the output will be:

```js
This is the original content. - Filter One Applied - Filter Two Applied
```

#### Full Example: Using Both Actions and Filters

##### Example with Action and Filter Together

```php
// Action Hook: Do something when the action is triggered
add_action('my_custom_action', 'my_action_function', 10, 1);

function my_action_function($message) {
    $message = apply_filters('modify_message', $message);  // Modify message via filter
    echo $message;
}

// Filter Hook: Modify the message content
add_filter('modify_message', 'customize_message', 10, 1);

function customize_message($message) {
    return $message . ' - Modified by Filter!';
}

// Triggering the Action
do_action('my_custom_action', 'Hello from Action');
```

#### Output:

```js
Hello from Action - Modified by Filter!
```

### Breakdown:

-   Action Hook: my_custom_action is triggered with a message parameter ('Hello from Action').
-   Filter Hook: The message passed through the action is modified by the modify_message filter.
-   Final Output: The message is altered by both the action and filter.

---

## Conclusion

Actions are used to add custom functions at specific points in WordPress’s execution. Filters are used to modify data before it is displayed or returned.
