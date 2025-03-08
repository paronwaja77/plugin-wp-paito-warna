<?php
/*
Plugin Name: Paito Warna
Description: Plugin untuk menampilkan Paito Warna dari sumber eksternal.
Version: 1.0
Author: Paron Waja
Author URI: http://datahklotto.info/
License: GPL2
*/

defined('ABSPATH') || exit; // Mencegah akses langsung ke file

// Path dasar plugin
define('PAITO_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PAITO_PLUGIN_URL', plugin_dir_url(__FILE__));

// Memuat semua file yang diperlukan dengan pengecekan
$includes = [
'includes/class-paito-admin.php',
'includes/class-paito-display.php',
'includes/pasaran/class-hk.php',
'includes/pasaran/class-sgp.php',
'includes/pasaran/class-sdy.php',
];

foreach ($includes as $file) {
$file_path = PAITO_PLUGIN_PATH . $file;
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    error_log("File tidak ditemukan: " . $file);
}
}

// folder custom
require_once plugin_dir_path(__FILE__) . 'includes/paito-custom-settings.php';


// **Pastikan hanya membuat instance Paito_Admin jika belum ada**
if (class_exists('Paito_Admin') && !isset($GLOBALS['paito_admin_instance'])) {
$GLOBALS['paito_admin_instance'] = new Paito_Admin();
}

// Fungsi yang dijalankan saat plugin diaktifkan
function paito_warna_activate() {
// Bisa menambahkan pengaturan default jika diperlukan
update_option('paito_warna_activated', time());
}
register_activation_hook(__FILE__, 'paito_warna_activate');

// Fungsi yang dijalankan saat plugin dinonaktifkan
function paito_warna_deactivate() {
delete_option('paito_warna_activated');
}
register_deactivation_hook(__FILE__, 'paito_warna_deactivate');

// Fungsi untuk memuat default CSS dari file style.css dan custom CSS dari database
function paito_custom_css() {
    // 1. Memuat default CSS dari file style.css
    wp_enqueue_style(
        'paito-default-style', // Handle (nama unik untuk CSS)
        plugins_url('assets/css/style.css', __FILE__) // Path ke file CSS
    );
    
    // 2. Memuat custom CSS dari database
    $custom_css = get_option('paito_custom_css', '');
    if (!empty($custom_css)) {
        // Tambahkan custom CSS sebagai inline style
        wp_add_inline_style('paito-default-style', $custom_css);
    }
    }
    // Hook ke wp_enqueue_scripts untuk memuat CSS
    add_action('wp_enqueue_scripts', 'paito_custom_css');

    function my_plugin_enqueue_scripts() {
        // Deregister the default jQuery bundled with WordPress
        wp_deregister_script('jquery');
    
        // Register jQuery from CDN
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), '3.4.1', true);
      
        // Enqueue jQuery
        wp_enqueue_script('jquery');
         // Memuat script.js dari folder assets/js
    wp_enqueue_script(
        'my-plugin-script', // Handle unik untuk script
        plugins_url('assets/js/script.js', __FILE__), // Path ke file script.js
        array('jquery'), // Dependensi (jQuery sebagai contoh)
        '1.0', // Versi script
        true // Load script di footer (true) atau header (false)
    );
    }
    add_action('wp_enqueue_scripts', 'my_plugin_enqueue_scripts');

    
?>