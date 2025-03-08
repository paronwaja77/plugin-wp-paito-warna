<?php
if (!defined('ABSPATH')) {
    exit; // Mencegah akses langsung ke file
}

class Paito_Custom_Settings {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_custom_settings_menu']);
        add_action('admin_init', [$this, 'register_custom_settings']);
    }

    // Tambahkan submenu untuk Custom Settings
    public function add_custom_settings_menu() {
        add_submenu_page(
            'paito-warna', // Parent slug
            'Custom Settings', // Page title
            'Custom Settings', // Menu title
            'manage_options', // Capability
            'paito-custom-settings', // Menu slug
            [$this, 'custom_settings_page_content'] // Callback function
        );
    }

    // Register settings untuk Custom CSS dan Custom Head
    public function register_custom_settings() {
        // Register setting untuk Custom CSS
        register_setting(
            'paito_custom_settings_group', // Group name
            'paito_custom_css', // Option name
            [
                'type' => 'string',
                'sanitize_callback' => 'wp_strip_all_tags', // Sanitize input
                'default' => ''
            ]
        );

        // Tambahkan section untuk Custom CSS
        add_settings_section(
            'paito_custom_css_section', // Section ID
            'Custom CSS', // Section title
            [$this, 'custom_css_section_callback'], // Callback
            'paito-custom-settings' // Page slug
        );

        // Tambahkan field untuk Custom CSS
        add_settings_field(
            'paito_custom_css_field', // Field ID
            'Custom CSS Code', // Field title
            [$this, 'custom_css_field_callback'], // Callback
            'paito-custom-settings', // Page slug
            'paito_custom_css_section' // Section ID
        );


    }

    // Callback untuk section Custom CSS
    public function custom_css_section_callback() {
        echo '<p>Masukkan kode CSS khusus Anda di sini. Kode ini akan ditambahkan ke halaman depan situs.</p>';
    }

    // Callback untuk field Custom CSS
    public function custom_css_field_callback() {
        $custom_css = get_option('paito_custom_css', '');
        echo '<textarea name="paito_custom_css" rows="10" cols="50" class="large-text">' . esc_textarea($custom_css) . '</textarea>';
    }

    // Konten halaman Custom Settings
    public function custom_settings_page_content() {
        ?>
        <div class="wrap">
            <h1>Custom Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('paito_custom_settings_group'); // Group name
                do_settings_sections('paito-custom-settings'); // Page slug
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

}

// Inisialisasi class Custom Settings
if (!isset($GLOBALS['paito_custom_settings_instance'])) {
    $GLOBALS['paito_custom_settings_instance'] = new Paito_Custom_Settings();
}