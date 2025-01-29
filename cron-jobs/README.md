# Custom Cron Job Plugin

## Description
This WordPress plugin adds a custom cron job that runs every minute. It logs the execution time and stores it as an option in the WordPress database.

### Features
* Adds a custom cron schedule (every minute)
* Registers a scheduled event on plugin activation
* Executes a function every minute
* Logs execution time
* Clears scheduled event on plugin deactivation

### Default WordPress Cron Schedules
WordPress provides the following default cron schedules:

* hourly
* twicedaily
* daily
* weekly

This plugin adds a custom schedule everyminute that runs every 60 seconds.

---

## Installation
Upload the plugin folder to the /wp-content/plugins/ directory.

Activate the plugin through the "Plugins" menu in WordPress.

The cron job will be automatically scheduled on activation.

### How It Works

##### 1. Adding a Custom Cron Schedule

The cron_schedules filter is used to add a custom time interval:

```php
function custom_every_minute_schedule($schedules) {
    $schedules['everyminute'] = array(
        'interval' => 60,
        'display'  => __('Custom Every Minute', 'nm-core'),
    );
    return $schedules;
}
add_filter('cron_schedules', 'custom_every_minute_schedule');
```

##### 2. Scheduling the Cron Job on Activation

When the plugin is activated, wp_schedule_event() ensures the cron job is scheduled:
```php
function custom_core_activate() {
    if (! wp_next_scheduled('custom_every_minute_event')) {
        wp_schedule_event(time(), 'everyminute', 'custom_every_minute_event');
    }
}
register_activation_hook(__FILE__, 'custom_core_activate');
```

#### 3. Hooking a Function to the Cron Job
The function custom_every_minute_cronjob() will be executed every minute:

```php
add_action('custom_every_minute_event', 'custom_every_minute_cronjob');

function custom_every_minute_cronjob() {
    error_log(date('Y-m-d H:i:s', time()));
    add_option('custom_crone_run_at', date('Y-m-d H:i:s', time()));
}
```

#### 4. Clearing the Cron Job on Deactivation
When the plugin is deactivated, wp_clear_scheduled_hook() removes the scheduled event:
```php
function custom_deactivation() {
    wp_clear_scheduled_hook('custom_every_minute_event');
}
register_deactivation_hook(__FILE__, 'custom_deactivation');
```

### Testing the Cron Job

* Activate the plugin.
* Wait a minute and check the error log (debug.log) for a timestamp.
* Alternatively, check the WordPress options table for custom_crone_run_at.

### Notes
WordPress cron jobs are triggered by site visitors. If no one visits the site, the cron job may not execute exactly on schedule.
To ensure accurate execution, consider setting up a real server-side cron job to trigger wp-cron.php.

### Uninstalling
To remove all traces of the plugin, delete it from the WordPress plugins menu. The cron job will be cleared on deactivation automatically.