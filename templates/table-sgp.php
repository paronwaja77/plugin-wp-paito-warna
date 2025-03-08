<?php
$paito = new Paito_SGP();
$data = $paito->get_data();

if (!$data || !is_array($data)) {
    echo "<p>Gagal mengambil data Paito Singapore.</p>";
    return;
}

// Tambahkan menu pemilih warna
?>
<div class="colormenu" id="colormenu">            
    <fieldset id="color-selector">
        <button id="btnSubmit">RESET</button>
        <div class="color" style="background:red;" data-color="red"></div>
        <div class="color" style="background:#8e44ad;" data-color="#8e44ad"></div>
        <div class="color" style="background:#0a9344;" data-color="#0a9344"></div>
        <div class="color" style="background:#f39c12;" data-color="#f39c12"></div>
        <div class="color" style="background:#3498db;" data-color="#3498db"></div>
        <div class="color" style="background:#1abc9c;" data-color="#1abc9c"></div>
        <div class="color" style="background:#d35400;" data-color="#d35400"></div>
        <div class="color" style="background:#114edf;" data-color="#114edf"></div>
        <div class="color eraser" data-color="eraser">Brush</div>
    </fieldset>        
</div>

<!-- Tampilkan tabel Paito Hongkong -->
<?php
echo "<table id='tabel-paito' border='1'>";
echo "<thead><tr>
            <th colspan='5' data-full='Senin' data-short='Sen'></th>
            <th colspan='5' data-full='Rabu' data-short='Rab'></th>
            <th colspan='5' data-full='Kamis' data-short='Kam'></th>
            <th colspan='5' data-full='Sabtu' data-short='Sab'></th>
            <th colspan='5' data-full='Minggu' data-short='Min'></th>
      </tr></thead>";
echo "<tbody>";

foreach ($data as $row) {
    if (!is_array($row)) {
        continue; // Skip jika bukan array
    }

    echo "<tr>";
    foreach ($row as $index => $cell) {
        if (is_array($cell)) {
            $cell = implode(',', $cell); // Gabungkan array ke string jika perlu
        }
        $class = ($index % 5 == 4) ? 'gitx' : 'git'; // Setiap 5 kolom, class berubah
        echo "<td class='$class'>" . esc_html($cell) . "</td>";
    }
    echo "</tr>";
}

echo "</tbody></table>";
?>
 <form id="myForm">
        <input maxlength="1" placeholder="as" class="cari" type="text" id="asc">
        <input maxlength="1" placeholder="kop" class="cari" type="text" id="kopc">
        <input maxlength="1" placeholder="kep" class="cari" type="text" id="kepalac">
        <input maxlength="1" placeholder="ekr" class="cari" type="text" id="ekorc">
        <input id="rb" type="button" class="btn" value="Reset"/>
    </form>