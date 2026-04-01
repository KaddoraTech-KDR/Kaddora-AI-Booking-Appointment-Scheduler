<?php
global $wpdb;

$table = $wpdb->prefix . 'kaba_appointments';

// Unique customers (email based)
$customers = $wpdb->get_results("
    SELECT name, email, phone, COUNT(*) as total_bookings
    FROM $table
    GROUP BY email
");
?>

<div class="kaba-customers">
  <h1 class="kaba-title">👥 Customers</h1>

  <div class="kaba-card">

    <table class="kaba-customers-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Total Bookings</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($customers as $c): ?>
          <tr>
            <td><?php echo esc_html($c->name); ?></td>
            <td><?php echo esc_html($c->email); ?></td>
            <td><?php echo esc_html($c->phone); ?></td>
            <td>
              <span class="kaba-count">
                <?php echo esc_html($c->total_bookings); ?>
              </span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</div>