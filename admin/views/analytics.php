<?php
global $wpdb;

$table = $wpdb->prefix . 'kaba_appointments';

// Bookings per service
$services = $wpdb->get_results("
    SELECT service, COUNT(*) as total 
    FROM $table 
    GROUP BY service
");
?>

<div class="kaba-analytics">
  <h1 class="kaba-title">📈 Analytics</h1>

  <div class="kaba-card">

    <h3 class="kaba-subtitle">Bookings by Service</h3>

    <table class="kaba-analytics-table">
      <thead>
        <tr>
          <th>Service</th>
          <th>Total Bookings</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($services as $s): ?>
          <tr>
            <td><?php echo esc_html($s->service); ?></td>
            <td><?php echo esc_html($s->total); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</div>