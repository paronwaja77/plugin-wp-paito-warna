jQuery(document).ready(function ($) {
  // Update shortcode saat pasaran dipilih
  $("#paito-pasaran").change(function () {
    let pasaran = $(this).val();
    $("#paito-shortcode").val(`[paito_${pasaran}]`);
  });

  // Copy shortcode ke clipboard
  $("#copy-shortcode").click(function () {
    let input = $("#paito-shortcode");
    input.select();
    document.execCommand("copy");
    alert("Shortcode copied: " + input.val());
  });

  // Preview Paito
  $("#paito-preview-btn").click(function () {
    let pasaran = $("#paito-pasaran").val();

    $.ajax({
      url: paitoAjax.ajaxurl,
      type: "POST",
      data: {
        action: "paito_preview",
        nonce: paitoAjax.nonce,
        pasaran: pasaran,
      },
      beforeSend: function () {
        $("#paito-preview").html("<p>Loading...</p>");
      },
      success: function (response) {
        if (response.success) {
          $("#paito-preview").html(response.data.content);
          // Tampilkan modal
          var myModal = new bootstrap.Modal(document.getElementById("paitoPreviewModal"), {
            keyboard: false,
          });
          myModal.show();
        } else {
          $("#paito-preview").html("<p>Error: " + response.data.message + "</p>");
        }
      },
    });
  });
});
