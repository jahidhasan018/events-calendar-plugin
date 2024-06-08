<?php
namespace Event_Calendar\Includes;

use Event_Calendar\Includes\Shortcodes\EventCalendar;
use Event_Calendar\Includes\RegisterScript;
use Event_Calendar\Includes\Admin\AdminPageCalendar;

class ActivationHandler {

    // Constructor method
    public function __construct() {
        // Add action to initialize the plugin
        add_action('init', array($this, 'init'));
    }

    // WordPress init hook callback
    public function init() {
        // Register custom post types, metaboxes, columns, and scripts
        new EventPostType();
        new EventMetabox();
        new EventCustomColumn();
        new RegisterScript();

        // Register admin page and shortcodes
        new AdminPageCalendar();
        new EventCalendar();
    }

    // Activate method
    public static function activate() {
        
    }
}
