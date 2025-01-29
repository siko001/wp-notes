# Custom API Routes in WordPress

### Overview

WordPress provides a REST API to create custom API endpoints. This is helpful when you need to interact with WordPress data via HTTP requests (GET, POST, PUT, DELETE) from external applications or even within the same WordPress site.

##### In this guide, you'll learn how to create custom API routes and interact with them.

### How to Create Custom API Routes in WordPress

#### Steps:

-   Register a Custom API Route
-   Create a Callback Function for the Route
-   Handle the API Request and Return Data
-   Test the Route

1. Register a Custom API Route To add a custom API route, use the register_rest_route function. This function registers a new route under a specific namespace and sets the callback function to handle requests to that route.

#### Example:

```php

function my_custom_api_routes() {
    register_rest_route('my_namespace/v1', '/hello/', array(
        'methods'  => 'GET',
        'callback' => 'my_hello_world_function',
    ));
}
add_action('rest_api_init', 'my_custom_api_routes');
```

#### In the example above:

my_namespace/v1: This is the namespace for your API routes. It's a good practice to namespace your routes to avoid conflicts.

/hello/: This is the custom endpoint for the API route. The complete URL for this route will be https://yoursite.com/wp-json/my_namespace/v1/hello/.

'methods' => 'GET': Specifies the HTTP method this route supports (GET, POST, PUT, DELETE). 'callback' => 'my_hello_world_function': The function that will be called when this route is accessed.

2. Create a Callback Function for the Route The callback function handles the request and prepares the data that will be returned to the user. The response should be in the form of a WP_REST_Response or a simple array.

#### Example:

```php

function my_hello_world_function(WP_REST_Request $request) {
    return new WP_REST_Response('Hello, world!', 200);
}
```

#### In this example:

The my_hello_world_function callback function will return a simple "Hello, world!" message as the response.

WP_REST_Response('Hello, world!', 200) creates a response object with the message and an HTTP status code 200 (OK).

3. Handle the API Request and Return Data You can customize your callback function to handle incoming parameters and return more complex data. WordPress supports both GET and POST methods.

For example, if you wanted to receive a user ID via the request and return that user’s data:

#### Example:

```php

function my_user_info_function(WP_REST_Request $request) {
    $user_id = $request->get_param('user_id'); // Retrieve 'user_id' parameter
    $user = get_user_by('ID', $user_id);

    if ($user) {
        return new WP_REST_Response(array(
            'ID' => $user->ID,
            'name' => $user->display_name,
            'email' => $user->user_email,
        ), 200);
    }

    return new WP_REST_Response('User not found', 404);
}
```

#### In this example:

The user_id is passed as a query parameter (e.g., ?user_id=1).

The function retrieves the user data using get_user_by and returns it as a JSON response.

4. Test the Route To test the custom API route:

Access the route via the browser or a tool like Postman:

```bash
https://yoursite.com/wp-json/my_namespace/v1/hello/
```

Test the route with parameters:

For example, to test the user info route:

```bash
https://yoursite.com/wp-json/my_namespace/v1/user-info/?user_id=1
```

#### Check the response:

The response will be a JSON object containing the user data if the user exists, or an error message if the user is not found.

## Full Example Code

Here’s the full example of creating a simple API route that retrieves user data based on a user ID:

```php
function my_custom_api_routes() {
    // Register the custom route
    register_rest_route('my_namespace/v1', '/user-info/', array(
        'methods'  => 'GET',
        'callback' => 'my_user_info_function',
        'args'     => array(
            'user_id' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
    ));
}
add_action('rest_api_init', 'my_custom_api_routes');

// Callback function for the /user-info/ route
function my_user_info_function(WP_REST_Request $request) {
    $user_id = $request->get_param('user_id');
    $user = get_user_by('ID', $user_id);

    if ($user) {
        return new WP_REST_Response(array(
            'ID' => $user->ID,
            'name' => $user->display_name,
            'email' => $user->user_email,
        ), 200);
    }

    return new WP_REST_Response('User not found', 404);
}
```

---

### Conclusion

By following these steps, you can easily create custom API routes in WordPress to expose data, handle requests, and build more dynamic and interactive applications.

#### Summary of Steps:

-   Use register_rest_route to define a custom route and namespace.
-   Create a callback function to handle the request and return the response.
-   Optionally, validate incoming request parameters and handle different HTTP methods (GET, POST).
-   Test the custom API endpoint using tools like Postman or directly in the browser.

