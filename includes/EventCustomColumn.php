<?php

namespace Event_Calendar\Includes;

use DateTime;

class EventCustomColumn {

    public function __construct() {
        // Add filters and actions to manage custom columns
        add_filter('manage_events_posts_columns', array($this, 'set_event_date_columns'));
        add_action('manage_events_posts_custom_column', array($this, 'event_date_column_data'), 10, 2);
    }

    // Method to set custom columns for the 'events' post type
    public function set_event_date_columns($columns) {
        // Remove default columns
        unset($columns['date']);
        unset($columns['author']);

        // Add custom columns
        $columns['event_date'] = __('Event Date', 'events-calendar');
        $columns['author'] = __('Created By', 'events-calendar');
        $columns['date'] = __('Published Date', 'events-calendar');
        return $columns;
    }

    // Method to populate custom column data
    public function event_date_column_data($column, $post_id) {
        if ($column == 'event_date') {
            // Get the event date from post meta
            $event_date = get_post_meta($post_id, 'event_date', true);

            // Convert the event date string to a DateTime object
            $event_date_time = DateTime::createFromFormat('Y-m-d', $event_date);

            // Check if event_date_time is valid
            if ($event_date_time) {
                // Format the event date
                $formatted_date = $event_date_time->format('l, F j, Y');
                
                // Get the current date
                $current_date = new DateTime();

                // Check if the event date is in the past (expired)
                if ($event_date_time < $current_date) {
                    // Display the event date with an "Expired" label in red color
                    $expired_text = __('Expired', 'events-calendar');
                    echo "<strong style=\"color: red;\">{$formatted_date} - {$expired_text}</strong>";
                } else {
                    // Display the event date
                    echo '<strong>' . $formatted_date . '</strong>';
                }
            } else {
                // Handle invalid event date
                echo __('Invalid date', 'events-calendar');
            }
        }
    }
}
