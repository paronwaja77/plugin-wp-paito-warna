<?php
if (!defined('ABSPATH')) {
    exit; // Mencegah akses langsung ke file
}

class Paito_Admin {
    private $pasaran_list = [
        'hk'  => 'Hongkong',
        'sgp' => 'Singapore',
        'sdy' => 'Sydney'
    ];

    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_ajax_paito_preview', [$this, 'handle_ajax_preview']);
    }

    // **Cek apakah menu sudah ditambahkan agar tidak duplikasi**
    public function add_admin_menu() {
        global $menu;
        foreach ($menu as $item) {
            if ($item[2] === 'paito-warna') {
                return; // **Hentikan jika menu sudah ada**
            }
        }

        add_menu_page(
            'Paito Warna',
            'Paito Warna',
            'manage_options',
            'paito-warna',
            [$this, 'admin_page_content'],
            'dashicons-chart-bar',
            20
        );
    }

    // Memuat CSS dan JS untuk halaman admin
    public function enqueue_admin_assets($hook) {
        // Memuat CSS dan JS hanya di halaman admin plugin ini
        if ($hook !== 'toplevel_page_paito-warna') {
            return;
        }
    
        // Memuat Bootstrap CSS
        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', [], '5.3.0');
    
        // Memuat Bootstrap JS
        wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.3.0', true);
    
        // Memuat CSS kustom
        wp_enqueue_style('paito-admin-style', plugin_dir_url(__FILE__) . '../assets/css/admin-style.css', [], '1.0.0');
        wp_enqueue_style('preview-style', plugin_dir_url(__FILE__) . '../assets/css/preview-style.css', [], '1.0.0');
    
        // Memuat JS kustom
        wp_enqueue_script('paito-admin-script', plugin_dir_url(__FILE__) . '../assets/js/admin-script.js', ['jquery'], '1.0.0', true);
    
        // Localize script untuk AJAX
        wp_localize_script('paito-admin-script', 'paitoAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('paito_nonce')
        ]);
    }
    // Konten halaman admin
    public function admin_page_content() {
        ?>
      <div class="wrap">
    <h1>Paito Warna Togel</h1>
    <div class="row">
        <!-- Kolom Kiri: Paito Settings -->
        <div class="col-md-6">
            <div class="paito-settings">
                <!-- Tombol Preview, Close, dan Shortcode -->
                <div style="display: flex; align-items: center; gap: 10px; margin-top: 20px;">
    <!-- Pilihan Pasaran -->
    <label for="paito-pasaran">Pilih Paito:</label>
    <select id="paito-pasaran">
        <?php foreach ($this->pasaran_list as $key => $label) : ?>
            <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
    </select>
    <button id="paito-preview-btn" class="button button-primary">Preview</button>
    <input type="text" id="paito-shortcode" class="button button-secondary" value="[paito_hk]" readonly style="width: 200px;">
    <button id="copy-shortcode" class="button">Copy</button>
</div>

<!-- Deskripsi Pasaran -->
<div id="pasaran-description" style="margin-top: 20px; padding: 10px; background-color: #f9f9f9; border-radius: 5px;">
    <p>Pilih pasaran untuk melihat deskripsi.</p>
</div>

<script>
    jQuery(document).ready(function ($) {
        const descriptions = {
            'hk': 'Pasaran Hongkong adalah pasaran togel yang paling populer di Asia. Hasil keluaran biasanya diumumkan setiap hari pukul 23.00 WIB.',
            'sgp': 'Pasaran Singapore adalah pasaran togel resmi yang dijalankan oleh Singapore Pools. Hasil keluaran diumumkan setiap hari pukul 17.40 WIB.',
            'sdy': 'Pasaran Sydney adalah pasaran togel dari Australia. Hasil keluaran diumumkan setiap hari pukul 13.50 WIB.'
        };

        $('#paito-pasaran').change(function () {
            const pasaran = $(this).val();
            $('#pasaran-description').html(`<p>${descriptions[pasaran]}</p>`);
        });

        // Trigger change event untuk menampilkan deskripsi awal
        $('#paito-pasaran').trigger('change');
    });
</script>
<div class="card mt-4 shadow-sm">

<h3 class="mt-4 mb-3">Fitur Plugin:</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">1. Pilih pasaran togel dari dropdown.</li>
                        <li class="list-group-item">2. Gunakan shortcode yang dihasilkan untuk menampilkan data di halaman atau post.</li>
                        <li class="list-group-item">3. TKlik "Preview" untuk melihat tampilan data sebelum dipublikasikan.</li>
                    </ul>
                   
                    </div>
            </div>
        </div>

        <!-- Kolom Kanan: About Me -->
        <div class="col-md-6">
            <div class="card mt-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">About Me & Plugin</h2>
                    <p class="card-text">Halo! Saya adalah pengembang plugin <strong>Paito Warna Togel</strong>. Plugin ini dirancang untuk membantu Anda menampilkan data togel dengan mudah dan menarik.</p>
                    
                    <h5 class="mt-4">Fitur Plugin:</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">✅ Menampilkan data togel dari berbagai pasaran (Hongkong, Singapore, Sydney).</li>
                        <li class="list-group-item">✅ Shortcode mudah digunakan untuk embedding ke halaman atau post.</li>
                        <li class="list-group-item">✅ Tampilan responsif dan user-friendly.</li>
                        <li class="list-group-item">✅ Dukungan AJAX untuk preview data tanpa reload halaman.</li>
                    </ul>

                    <p class="card-text mt-4">Jika Anda memiliki pertanyaan atau masukan, silakan hubungi saya di <a href="http://datahklotto.info" target="_blank">data hk lotto</a>.</p>
                </div>
            </div>
        </div>
    </div> <!-- Tutup .row -->
    <div class="alert alert-primary p-1 mt-5" role="alert">
    <div class="text-center"> Fitur hanya bisa di gunakan saat sudah di masukan kedalam post.
    </div>
    </div>
</div> <!-- Tutup .wrap -->

<!-- Modal untuk Preview Paito -->
<div class="modal fade" id="paitoPreviewModal" tabindex="-1" aria-labelledby="paitoPreviewModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paitoPreviewModalLabel">Preview Paito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="paito-preview">
                <!-- Konten preview akan dimuat di sini -->
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <?php

    }
    // Handle AJAX untuk preview paito
    public function handle_ajax_preview() {
        check_ajax_referer('paito_nonce', 'nonce');

        $pasaran = isset($_POST['pasaran']) ? sanitize_text_field($_POST['pasaran']) : '';

        if (!$pasaran || !array_key_exists($pasaran, $this->pasaran_list)) {
            wp_send_json_error(['message' => 'Pasaran tidak valid!']);
        }

        if (!class_exists('Paito_Display')) {
            wp_send_json_error(['message' => 'Class Paito_Display tidak ditemukan!']);
        }

        $paito_display = new Paito_Display();
        $output = '';

        if ($pasaran == 'hk') {
            $output = $paito_display->display_paito_hk();
        } elseif ($pasaran == 'sgp') {
            $output = $paito_display->display_paito_sgp();
        } elseif ($pasaran == 'sdy') {
            $output = $paito_display->display_paito_sdy();
        }

        wp_send_json_success(['content' => $output]);
    }
}

// **Pastikan hanya membuat instance jika belum ada**
if (!isset($GLOBALS['paito_admin_instance'])) {
    $GLOBALS['paito_admin_instance'] = new Paito_Admin();
}
?>