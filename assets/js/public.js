jQuery(document).ready(function ($) {
  $("#kaba-date").on("change", function () {
    let date = $(this).val();

    $("#kaba-time").html('<option value="">Loading...</option>');

    $.post(
      kaba_ajax.ajax_url,
      {
        action: "kaba_get_slots",
        date: date,
      },
      function (slots) {
        let options = '<option value="">Select Time</option>';

        if (slots.length === 0) {
          options = '<option value="">No slots available</option>';
        } else {
          slots.forEach(function (time) {
            options += `<option value="${time}">${time}</option>`;
          });
        }

        $("#kaba-time").html(options);
      },
    );
  });

  $("#kaba-booking-form").on("submit", function (e) {
    e.preventDefault();

    var form = $(this);
    var formData = form.serialize();

    $("#kaba-message").text("");

    $.post(
      kaba_ajax.ajax_url,
      formData + "&action=kaba_booking",
      function (response) {
        if (response.success) {
          $("#kaba-message").css("color", "green").text(response.data);

          // Reset form
          form[0].reset();

          // Reset time dropdown
          $("#kaba-time").html('<option value="">Select Time</option>');
        } else {
          $("#kaba-message").css("color", "red").text(response.data);
        }
      },
    );
  });
});
