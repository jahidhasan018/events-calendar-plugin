<?php

namespace Event_Calendar\Includes\Admin;

class AdminPageCalendar {

    public function __construct() {
        // Add action to register the submenu page
        add_action('admin_menu', array($this, 'add_events_submenu_page'));
    }

    // Method to add the events submenu page
    public function add_events_submenu_page() {        
        add_submenu_page( 
            'edit.php?post_type=events',  // Parent slug
            'Events Calendar',            // Page title
            'Events Calendar',            // Menu title
            'manage_options',             // Capability
            'events-calendar',            // Menu slug
            array($this, 'display_event_calendar') // Callback function
        );
    }

    // Method to display the event calendar
    public function display_event_calendar() {
        // Get the current month and year
        $month = date('n');
        $year = date('Y');

        // Check if the "next" or "previous" button was clicked and update month/year
        if (isset($_GET['month']) && isset($_GET['year'])) {
            $month = sanitize_text_field($_GET['month']);
            $year = sanitize_text_field($_GET['year']);
        }

        // Get the number of days in the month
        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Get the first day of the month
        $firstDay = date('N', strtotime($year . '-' . $month . '-01'));

        // Get the previous month and year
        $prevMonth = $month - 1;
        $prevYear = $year;
        if ($prevMonth < 1) {
            $prevMonth = 12;
            $prevYear--;
        }

        // Get the next month and year
        $nextMonth = $month + 1;
        $nextYear = $year;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }

        // Get published events from the 'events' post type
        $args = array(
            'post_type'      => 'events',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );

        $all_events = get_posts($args);
        $events = [];

        // Organize events by date
        foreach ($all_events as $event) {
            $date = get_post_meta($event->ID, 'event_date', true);
            $title = $event->post_title;
            $event_id = $event->ID;

            // If the date key doesn't exist, create a new array
            if (!isset($events[$date])) {
                $events[$date] = array(array('title' => $title, 'id' => $event_id));
            } else {
                // Append the event to the existing date array
                $events[$date][] = array('title' => $title, 'id' => $event_id);
            }
        }

        // Display the event calendar
        ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title(); ?></h2>
            <div class="evp-nav">
                <a href="edit.php?post_type=events&page=events-calendar&month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>" class="evp-btn">&#8249; <?php esc_html_e( 'Prev', 'events-calendar' ); ?></a>

                <span class="evp-month-year">
                    <?php echo date('F Y', strtotime($year . '-' . $month . '-01')); ?>
                </span>

                <a href="edit.php?post_type=events&page=events-calendar&month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>" class="evp-btn"><?php esc_html_e( 'Next', 'events-calendar' ); ?> &#8250;</a>
            </div>

            <div class="evp-calendar">
                <!-- Print day headers -->
                <div class="evp-day-header"><?php esc_html_e( 'Sun', 'events-calendar' ); ?></div>
                <div class="evp-day-header"><?php esc_html_e( 'Mon', 'events-calendar' ); ?></div>
                <div class="evp-day-header"><?php esc_html_e( 'Tue', 'events-calendar' ); ?></div>
                <div class="evp-day-header"><?php esc_html_e( 'Wed', 'events-calendar' ); ?></div>
                <div class="evp-day-header"><?php esc_html_e( 'Thu', 'events-calendar' ); ?></div>
                <div class="evp-day-header"><?php esc_html_e( 'Fri', 'events-calendar' ); ?></div>
                <div class="evp-day-header"><?php esc_html_e( 'Sat', 'events-calendar' ); ?></div>

                <?php
                // Print blank cells before the first day of the month
                for ($i = 1; $i < $firstDay; $i++) {
                    echo '<div class="evp-day"></div>';
                }

                // Print days of the month
                for ($day = 1; $day <= $numDays; $day++) {
                    $currentDate = date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));
                    echo '<div class="evp-day">' . $day;

                    // Add events for the corresponding day
                    if (array_key_exists($currentDate, $events)) {
                        foreach ($events[$currentDate] as $event) {
                            echo '<a class="evp-event" href="' . get_permalink($event['id']) . '">' . esc_html($event['title']) . '</a>';
                        }
                    }

                    echo '</div>';
                }

                // Print remaining blank cells after the last day of the month
                $remainingCells = 7 - (($numDays + $firstDay - 1) % 7);
                if ($remainingCells < 7) {
                    for ($i = 0; $i < $remainingCells; $i++) {
                        echo '<div class="evp-day"></div>';
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }
}
