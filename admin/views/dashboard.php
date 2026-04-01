<?php
global $wpdb;

$table = $wpdb->prefix . 'kaba_appointments';

// =======================
// STATS
// =======================
$total = $wpdb->get_var("SELECT COUNT(*) FROM $table");
$approved = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status='approved'");
$pending = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status='pending'");
$rejected = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status='rejected'");

// =======================
// TODAY BOOKINGS
// =======================
$today = date('Y-m-d');

$today_count = $wpdb->get_var($wpdb->prepare(
  "SELECT COUNT(*) FROM $table WHERE appointment_date = %s",
  $today
));

// =======================
// RECENT BOOKINGS
// =======================
$recent = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC LIMIT 5");

// =======================
// TOP SERVICES
// =======================
$services = $wpdb->get_results("
    SELECT service, COUNT(*) as total 
    FROM $table 
    GROUP BY service 
    ORDER BY total DESC 
    LIMIT 3
");
?>

<div class="kaba-dashboard">

  <h1 class="kaba-title">📊 Dashboard</h1>

  <!-- ======================= -->
  <!-- STAT CARDS -->
  <!-- ======================= -->
  <div class="kaba-stats">

    <div class="kaba-stat-card total">
      <span class="kaba-stat-title">Total</span>
      <h2 class="kaba-stat-value"><?php echo $total; ?></h2>
    </div>

    <div class="kaba-stat-card approved">
      <span class="kaba-stat-title">Approved</span>
      <h2 class="kaba-stat-value"><?php echo $approved; ?></h2>
    </div>

    <div class="kaba-stat-card pending">
      <span class="kaba-stat-title">Pending</span>
      <h2 class="kaba-stat-value"><?php echo $pending; ?></h2>
    </div>

    <div class="kaba-stat-card rejected">
      <span class="kaba-stat-title">Rejected</span>
      <h2 class="kaba-stat-value"><?php echo $rejected; ?></h2>
    </div>

    <div class="kaba-stat-card today">
      <span class="kaba-stat-title">Today</span>
      <h2 class="kaba-stat-value"><?php echo $today_count; ?></h2>
    </div>

  </div>

  <!-- ======================= -->
  <!-- GRID SECTION -->
  <!-- ======================= -->
  <div class="kaba-dashboard-grid">

    <!-- TOP SERVICES -->
    <div class="kaba-card">
      <h2 class="kaba-subtitle">🔥 Top Services</h2>

      <ul class="kaba-service-list">
        <?php foreach ($services as $s): ?>
          <li class="kaba-service-item">
            <span class="kaba-service-name">
              <?php echo esc_html($s->service); ?>
            </span>
            <span class="kaba-service-count">
              <?php echo $s->total; ?> bookings
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- RECENT BOOKINGS -->
    <div class="kaba-card">
      <h2 class="kaba-subtitle">🕒 Recent Bookings</h2>

      <table class="kaba-dashboard-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Service</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($recent as $r): ?>
            <tr>
              <td><?php echo esc_html($r->name); ?></td>
              <td><?php echo esc_html($r->service); ?></td>
              <td><?php echo esc_html($r->appointment_date); ?></td>
              <td>
                <span class="kaba-badge kaba-<?php echo esc_attr($r->status); ?>">
                  <?php echo esc_html($r->status); ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>

  </div>

</div>