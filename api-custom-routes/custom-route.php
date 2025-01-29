<?php

function my_custom_api_routes() {
    // Register the custom route
    register_rest_route('my_namespace/v1', '/user-info/', array(
        'methods'  => 'GET',
        'callback' => 'my_user_info_function',
        'args'     => array(
            'user_id' => array(
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
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
