<?php
class Paito_Scraper {
    public static function get_table($url) {
        $response = wp_remote_get($url);
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return false;
        }

        $html = wp_remote_retrieve_body($response);
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        $table = $xpath->query('//table')->item(0); // Ambil tabel pertama
        
        if (!$table) {
            return false;
        }
        
        return $dom->saveHTML($table);
    }
}
?>
