<?php
global $wpdb;

$table = $wpdb->prefix . 'kaba_appointments';

$results = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
?>

<div class="kaba-wrap">
  <h1 class="kaba-title">📅 Appointments</h1>

  <div class="kaba-card">
    <table id="kaba-appointments-table" class="kaba-table">

      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Service</th>
          <th>Mobile no.</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($results as $row): ?>
          <tr>
            <td><?php echo esc_html($row->name); ?></td>
            <td><?php echo esc_html($row->email); ?></td>
            <td><?php echo esc_html($row->service); ?></td>
            <td><?php echo esc_html($row->phone); ?></td>
            <td><?php echo esc_html($row->appointment_date); ?></td>
            <td><?php echo esc_html($row->appointment_time); ?></td>

            <td>
              <span class="kaba-badge kaba-<?php echo esc_attr($row->status); ?>">
                <?php echo esc_html($row->status); ?>
              </span>
            </td>

            <td>
              <button class="kaba-btn success kaba-action" data-id="<?php echo $row->id; ?>" data-action="approve">Approve</button>
              <button class="kaba-btn warning kaba-action" data-id="<?php echo $row->id; ?>" data-action="reject">Reject</button>
              <button class="kaba-btn danger kaba-delete" data-id="<?php echo $row->id; ?>">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
  </div>
</div>