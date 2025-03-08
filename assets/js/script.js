$(document).ready(function () {
  let selectedColor = null; // Tidak ada warna yang dipilih secara default
  let eraseMode = false; // Mode penghapus

  // Pilih warna
  $(".color").click(function () {
    let color = $(this).attr("data-color");

    if (color === "eraser") {
      eraseMode = true;
      selectedColor = null;
    } else {
      selectedColor = color;
      eraseMode = false;
    }

    $(".color").removeClass("selected");
    $(this).addClass("selected");
  });

  // Klik sel tabel untuk mewarnai atau menghapus
  $("#tabel-paito td").click(function () {
    if (eraseMode) {
      $(this).removeAttr("style");
    } else if (selectedColor) {
      $(this).css("background", selectedColor);
    }
  });

  // Tombol "Clear" untuk menghapus semua warna dari tabel
  $("#btnSubmit").click(function () {
    $("#tabel-paito td").removeAttr("style");
  });
});

//fixed
$(document).ready(function () {
  var colormenu = $(".colormenu");
  var offsetTop = colormenu.offset().top; // Ambil posisi awal dari .colormenu

  $(window).scroll(function () {
    if ($(window).scrollTop() > offsetTop) {
      colormenu.addClass("fixed");
    } else {
      colormenu.removeClass("fixed");
    }
  });
});

// Fungsi untuk menerapkan warna berdasarkan input
function applyClass(inputId, columnIndex, classPrefix) {
  let inputValue = $.trim($(inputId).val()).toUpperCase(); // Ambil input & ubah ke huruf besar

  $(".git").each(function (index) {
    if (index % 4 === columnIndex - 1) {
      // Pilih kolom yang sesuai
      let cellText = $(this).text().trim().toUpperCase();

      // Hapus kelas warna sebelumnya
      $(this).removeClass(function (index, className) {
        return (className.match(/(a|c|k|e)\d+/g) || []).join(" ");
      });

      // Tambahkan kelas warna jika cocok
      if (inputValue.length > 0 && cellText === inputValue) {
        $(this).addClass(classPrefix + inputValue);
      }
    }
  });
}

// Event listener untuk input
$("#asc").on("input", function () {
  applyClass("#asc", 1, "a");
});

$("#kopc").on("input", function () {
  applyClass("#kopc", 2, "c");
});

$("#kepalac").on("input", function () {
  applyClass("#kepalac", 3, "k");
});

$("#ekorc").on("input", function () {
  applyClass("#ekorc", 4, "e");
});

// Fungsi Reset Form
$("#rb").on("click", function () {
  $("#myForm")[0].reset(); // Reset input form
  $(".git").removeClass(function (index, className) {
    return (className.match(/(a|c|k|e)\d+/g) || []).join(" ");
  });
});
