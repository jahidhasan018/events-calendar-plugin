<?php

namespace Event_Calendar\Includes;

class RegisterScript {

    public function __construct() {
        // Hook to enqueue admin scripts
        add_action('admin_enqueue_scripts', array($this, 'evp_events_admin_scripts'));
        // Hook to enqueue public scripts
        add_action('wp_enqueue_scripts', array($this, 'evp_events_public_scripts'));
    }

    // Method to enqueue admin scripts
    public function evp_events_admin_scripts($hook_suffix) {
        // Enqueue admin styles only on the events calendar admin page
        if ($hook_suffix === 'events_page_events-calendar') {
            wp_enqueue_style('admin-style', EVP_ADMIN_DIR . '/css/style.css', [], EVP_VERSION, 'all');
        }
    }

    // Method to enqueue public scripts
    public function evp_events_public_scripts() {
        // Enqueue public styles for all pages
        wp_enqueue_style('public-style', EVP_PUBLIC_DIR . '/css/style.css', [], EVP_VERSION, 'all');
    }
}
