<?php
class Paito_Display {
    public function __construct() {
        add_shortcode('paito_hk', [$this, 'display_paito_hk']);
        add_shortcode('paito_sgp', [$this, 'display_paito_sgp']);
        add_shortcode('paito_sdy', [$this, 'display_paito_sdy']);
    }

    public function display_paito_hk() {
        ob_start();
        include plugin_dir_path(__FILE__) . '../templates/table-hk.php';
        return ob_get_clean();
    }

    public function display_paito_sgp() {
        ob_start();
        include plugin_dir_path(__FILE__) . '../templates/table-sgp.php';
        return ob_get_clean();
    }

    public function display_paito_sdy() {
        ob_start();
        include plugin_dir_path(__FILE__) . '../templates/table-sdy.php';
        return ob_get_clean();
    }
}

new Paito_Display();