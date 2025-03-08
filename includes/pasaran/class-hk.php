<?php
class Paito_HK {
    private $url = 'https://angkanet3.com/paito-warna-hongkong-pools/';

    public function get_data() {
        $response = wp_remote_get($this->url);
        if (is_wp_error($response)) {
            return false;
        }

        $html = wp_remote_retrieve_body($response);
        return $this->parse_data($html);
    }

    private function parse_data($html) {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        $xpath = new DOMXPath($dom);
        $rows = $xpath->query('//table/tbody/tr');

        $data = [];
        foreach ($rows as $row) {
            $cells = $xpath->query('./td', $row);
            $rowData = [];
            foreach ($cells as $cell) {
                $rowData[] = trim($cell->textContent);
            }
            if (!empty($rowData)) {
                $data[] = $rowData;
            }
        }

        return $data;
    }
}
?>
