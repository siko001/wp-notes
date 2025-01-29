<?php

add_action('wp_enqueue_scripts', 'enqueue_custom_js');

function enqueue_custom_js() {

    // Register yo JS (this will just register the script, not load it)
    wp_register_script('yo', get_template_directory_uri() . '_yo.js', [], '1.0', true);

    // handle(needs to be the same as the js file being localized), object name, Object Data
    wp_localize_script('yo', 'OBJECT_NAME', [
        'param1' => 'value1',
        'param2' => 'value2'
    ]);

    // Enqueue custom JS (this will load the script and also the yo script as a dependency)
    wp_enqueue_script('blah', get_template_directory_uri() . '_blah.js', ['yo'], '1.0', true);

    //   // Deregister yo JS (if the page is 'not-yo')
    if (is_page('not-yo')) wp_deregister_script('yo');
}
