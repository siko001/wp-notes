<?php

/**
 * Plugin Name: Custom Cron Job
 * Description: Custom Cron Job when a user visits the site.
 * Version: 1.0
 */

/**
 * Add new time interval for cron job.
 *
 * Here we are adding 1 minite cron job.
 *
 * @param array $schedules
 * @return void
 * 
 * 
 * DEFAULTS
 * hourly 
 * twicedaily
 * daily
 * weekly
 * 
 */

// Add new time interval for cron job
function custom_every_minute_schedule($schedules) {
    // add a 'everyminute' schedule to the existing set
    $schedules['everyminute'] = array(
        'interval' => 60,
        'display'  => __('Custom Every Minute', 'nm-core'),
    );
    return $schedules;
}

// Add custom time interval to cron job
add_filter('cron_schedules', 'custom_every_minute_schedule');



/**
 * Scedule cron job.
 *
 * @return void
 */
function custom_core_activate() {
    if (! wp_next_scheduled('custom_every_minute_event')) :
        wp_schedule_event(time(), 'everyminute', 'custom_every_minute_event');
    endif;
}

// Schedule cron job on plugin activation
register_activation_hook(__FILE__, 'custom_core_activate');


// Add action to the cron job event hook 
add_action('custom_every_minute_event', 'custom_every_minute_cronjob');

/**
 * Do whatever you want to do in the cron job.
 */
function custom_every_minute_cronjob() {
    error_log(date('Y-m-d H:i:s', time()));
    add_option('custom_crone_run_at', date('Y-m-d H:i:s', time()));
}


/**
 * Clear cron scedular.
 *
 * @return void
 */

// Clear cron scedular on plugin deactivation
function custom_deactivation() {
    wp_clear_scheduled_hook('custom_every_minute_event');
}

// Clear cron scedular on plugin deactivation
register_deactivation_hook(__FILE__, 'custom_deactivation');
