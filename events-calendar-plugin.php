<?php

/*
Plugin Name: Events Calendar
Plugin URI:  https://github.com/jahidhasan018/events-calendar
Version:     1.0
Author:      Jahid
Author URI:  https://jahiddev.com
Text Domain: events-calendar
Domain Path: /languages
Description: The Events Calendar plugin simplifies event management on your website. Easily create, edit, and display events with customizable details.
License:     GPL2
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('EVP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('EVP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('EVP_ADMIN_DIR', EVP_PLUGIN_URL . 'assets/admin');
define('EVP_PUBLIC_DIR', EVP_PLUGIN_URL . 'assets/public');
define('EVP_VERSION', '1.0');

// Include Composer autoloader if it exists
if (file_exists(EVP_PLUGIN_DIR . 'vendor/autoload.php')) {
    require_once(EVP_PLUGIN_DIR . 'vendor/autoload.php');
}

// Check if the class does not already exist to avoid redeclaration
if (!class_exists('EventsCalendarPlugin')) {
    class EventsCalendarPlugin {

        // Constructor of the class
        public function __construct() {
            // Register activation hook
            $this->register_activation_hook();

            // Add a filter to include a custom single event template
            add_filter('template_include', array($this, 'custom_single_event_template'));
        }

        // Method to register the activation hook
        public function register_activation_hook() {
            $activation_handler = new Event_Calendar\Includes\ActivationHandler();
            register_activation_hook(__FILE__, array($activation_handler, 'activate'));
        }

        // Method to include a custom template for single events
        public function custom_single_event_template($template) {
            if (is_singular('events')) {
                $template = EVP_PLUGIN_DIR . 'templates/events-single.php';
            }
            return $template;
        }
    }

    // Instantiate the plugin class
    new EventsCalendarPlugin();
}
