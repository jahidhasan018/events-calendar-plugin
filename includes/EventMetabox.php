<?php
namespace Event_Calendar\Includes;

class EventMetabox {
    
    public function __construct() {
        // Add actions to handle metabox addition and data saving
        add_action('add_meta_boxes', array($this, 'add_event_meta_box'));
        add_action('save_post', array($this, 'save_event_meta'));
    }

    // Add metabox to events page in admin
    public function add_event_meta_box() {
        add_meta_box(
            'event_date_meta_box',         // Metabox ID
            __('Event Date', 'events-calendar'),  // Title
            array($this, 'render_event_date_meta_box'), // Callback function
            'events',                      // Post type
            'side',                        // Context
            'default'                      // Priority
        );
    }

    // Render the event date metabox
    public function render_event_date_meta_box($post) {
        // Retrieve the current value of the meta field
        $event_date = get_post_meta($post->ID, 'event_date', true);
        ?>
        <label for="event_date"><?php _e('Event Date:', 'events-calendar'); ?></label>
        <input class="large-text" type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" required />
        <?php
        // Add a nonce field for security
        wp_nonce_field('event_meta_nonce', 'event_meta_nonce');
    }

    // Save the event meta data
    public function save_event_meta($post_id) {
        // Check if nonce is set
        if (!isset($_POST['event_meta_nonce'])) {
            return;
        }

        // Verify the nonce for security
        if (!wp_verify_nonce($_POST['event_meta_nonce'], 'event_meta_nonce')) {
            return;
        }

        // Check if this is an autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save the meta field value
        if (isset($_POST['event_date'])) {
            update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
        }
    }
}
