<?php
if (!defined("ABSPATH")) exit;

class Kaba_DB
{

  public static function create_tables()
  {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    // Appointments table
    $appointments_table = $wpdb->prefix . 'kaba_appointments';

    $sql1 = "CREATE TABLE $appointments_table (
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(100),
            phone VARCHAR(20),
            service VARCHAR(100),
            appointment_date DATE,
            appointment_time TIME,
            status VARCHAR(20) DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset_collate;";

    // Service table
    $services_table = $wpdb->prefix . 'kaba_services';

    $sql2 = "CREATE TABLE $services_table (
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            price FLOAT DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta($sql1);
    dbDelta($sql2);

    self::insert_default_services();
  }

  // DEFAULT SERVICES INSERT
  private static function insert_default_services()
  {
    global $wpdb;

    $table = $wpdb->prefix . 'kaba_services';

    // Check if already exists
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table");

    if ($count == 0) {
      $wpdb->insert($table, ['name' => 'Consultation']);
      $wpdb->insert($table, ['name' => 'Support']);
    }
  }
}
