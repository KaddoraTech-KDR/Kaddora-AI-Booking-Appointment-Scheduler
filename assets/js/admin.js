jQuery(document).ready(function ($) {
  // ===============================
  // APPROVE / REJECT (LIVE UPDATE)
  // ===============================
  $(document).on("click", ".kaba-action", function () {
    let btn = $(this);
    let id = btn.data("id");
    let type = btn.data("action");

    $.post(
      ajaxurl,
      {
        action: "kaba_update_status",
        id: id,
        type: type,
      },
      function (res) {
        if (res.success) {
          let row = btn.closest("tr");
          let statusCell = row.find("td:nth-child(7) span");

          // REMOVE OLD CLASSES
          statusCell.removeClass("kaba-approved kaba-pending kaba-rejected");

          // APPLY NEW STATUS
          if (type === "approve") {
            statusCell.text("approved");
            statusCell.addClass("kaba-approved");
          }

          if (type === "reject") {
            statusCell.text("rejected");
            statusCell.addClass("kaba-rejected");
          }
        }
      },
    );
  });

  // ===============================
  // DELETE (NO RELOAD)
  // ===============================
  $(document).on("click", ".kaba-delete", function () {
    if (!confirm("Delete?")) return;

    let btn = $(this);
    let id = btn.data("id");

    $.post(
      ajaxurl,
      {
        action: "kaba_update_status",
        id: id,
        type: "delete",
      },
      function (res) {
        if (res.success) {
          btn.closest("tr").fadeOut(200, function () {
            $(this).remove();
          });
        }
      },
    );
  });

  // ===============================
  // AUTO REFRESH (FIXED)
  // ===============================
  setInterval(function () {
    $.post(ajaxurl, { action: "kaba_get_appointments" }, function (data) {
      let rows = "";

      data.forEach(function (row) {
        rows += `<tr>
          <td>${row.name}</td>
          <td>${row.email}</td>
          <td>${row.service}</td>
          <td>${row.phone}</td>
          <td>${row.appointment_date}</td>
          <td>${row.appointment_time}</td>

          <td>
            <span class="kaba-badge kaba-${row.status}">
              ${row.status}
            </span>
          </td>

          <td>
            <button class="kaba-btn success kaba-action" data-id="${row.id}" data-action="approve">
              Approve
            </button>

            <button class="kaba-btn warning kaba-action" data-id="${row.id}" data-action="reject">
              Reject
            </button>

            <button class="kaba-btn danger kaba-delete" data-id="${row.id}">
              Delete
            </button>
          </td>
        </tr>`;
      });

      $("#kaba-appointments-table tbody").html(rows);
    });
  }, 5000);
});
