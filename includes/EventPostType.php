<?php
namespace Event_Calendar\Includes;

class EventPostType {

    public function __construct() {
        // Register the custom post type
        $this->register();
        
        // Flush rewrite rules to ensure the custom post type's permalinks are registered properly
        flush_rewrite_rules();
    }

    // Method to register the 'events' custom post type
    public function register() {
        $labels = [
            "name"                  => esc_html__( "Events", "events-calendar" ),
            "singular_name"         => esc_html__( "Event", "events-calendar" ),
            "menu_name"             => esc_html__( "Events", "events-calendar" ),
            "all_items"             => esc_html__( "All Events", "events-calendar" ),
            "add_new"               => esc_html__( "Add New", "events-calendar" ),
            "add_new_item"          => esc_html__( "Add New Event", "events-calendar" ),
            "edit_item"             => esc_html__( "Edit Event", "events-calendar" ),
            "new_item"              => esc_html__( "New Event", "events-calendar" ),
            "view_item"             => esc_html__( "View Event", "events-calendar" ),
            "view_items"            => esc_html__( "View Events", "events-calendar" ),
            "search_items"          => esc_html__( "Search Events", "events-calendar" ),
            "not_found"             => esc_html__( "No Events found", "events-calendar" ),
            "not_found_in_trash"    => esc_html__( "No Events found in trash", "events-calendar" ),
            "parent"                => esc_html__( "Parent Event:", "events-calendar" ),
            "featured_image"        => esc_html__( "Featured image for this Event", "events-calendar" ),
            "set_featured_image"    => esc_html__( "Set featured image for this Event", "events-calendar" ),
            "remove_featured_image" => esc_html__( "Remove featured image for this Event", "events-calendar" ),
            "use_featured_image"    => esc_html__( "Use as featured image for this Event", "events-calendar" ),
            "archives"              => esc_html__( "Event archives", "events-calendar" ),
            "insert_into_item"      => esc_html__( "Insert into Event", "events-calendar" ),
            "uploaded_to_this_item" => esc_html__( "Upload to this Event", "events-calendar" ),
            "filter_items_list"     => esc_html__( "Filter Events list", "events-calendar" ),
            "items_list_navigation" => esc_html__( "Events list navigation", "events-calendar" ),
            "items_list"            => esc_html__( "Events list", "events-calendar" ),
            "attributes"            => esc_html__( "Events attributes", "events-calendar" ),
            "name_admin_bar"        => esc_html__( "Event", "events-calendar" ),
            "item_published"        => esc_html__( "Event published", "events-calendar" ),
            "item_published_privately" => esc_html__( "Event published privately.", "events-calendar" ),
            "item_reverted_to_draft"   => esc_html__( "Event reverted to draft.", "events-calendar" ),
            "item_trashed"          => esc_html__( "Event trashed.", "events-calendar" ),
            "item_scheduled"        => esc_html__( "Event scheduled", "events-calendar" ),
            "item_updated"          => esc_html__( "Event updated.", "events-calendar" ),
            "parent_item_colon"     => esc_html__( "Parent Event:", "events-calendar" ),
        ];

        $args = [
            "label"                 => esc_html__( "Events", "events-calendar" ),
            "labels"                => $labels,
            "description"           => "",
            "public"                => true,
            "publicly_queryable"    => true,
            "show_ui"               => true,
            "has_archive"           => true,
            "show_in_menu"          => true,
            "show_in_nav_menus"     => true,
            "delete_with_user"      => false,
            "exclude_from_search"   => false,
            "capability_type"       => "post",
            "hierarchical"          => false,
            "can_export"            => true,
            "rewrite"               => ["slug" => "events", "with_front" => true],
            "query_var"             => true,
            "menu_position"         => 50,
            "menu_icon"             => "dashicons-calendar-alt",
            "supports"              => ["title", "editor", "thumbnail", "author"],
        ];

        // Register the custom post type
        register_post_type("events", $args);
    }
}
