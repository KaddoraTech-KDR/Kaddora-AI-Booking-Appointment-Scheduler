<?php
if (!defined('ABSPATH')) exit;

class Kaba_Ajax
{

  public function init()
  {
    add_action('wp_ajax_kaba_booking', [$this, 'handle_booking']);
    add_action('wp_ajax_nopriv_kaba_booking', [$this, 'handle_booking']);
    add_action('wp_ajax_kaba_update_status', [$this, 'update_status']);
    add_action('wp_ajax_kaba_get_appointments', [$this, 'get_appointments']);
    add_action('wp_ajax_kaba_get_slots', [$this, 'get_slots']);
    add_action('wp_ajax_nopriv_kaba_get_slots', [$this, 'get_slots']);
  }

  // handle_booking
  public function handle_booking()
  {
    global $wpdb;
    $table = $wpdb->prefix . 'kaba_appointments';

    $name  = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $service = sanitize_text_field($_POST['service']);

    $date = sanitize_text_field($_POST['appointment_date']);
    $time = sanitize_text_field($_POST['appointment_time']);

    $exists = $wpdb->get_var($wpdb->prepare(
      "SELECT COUNT(*) FROM $table WHERE appointment_date = %s AND appointment_time = %s",
      $date,
      $time
    ));

    if ($exists > 0) {
      wp_send_json_error("This time slot is already booked!");
    }

    $wpdb->insert($table, [
      'name' => $name,
      'email' => $email,
      'phone' => $phone,
      'service' => $service,
      'appointment_date' => $date,
      'appointment_time' => $time,
      'status' => 'pending'
    ]);

    wp_send_json_success("Booking successful!");
  }

  // update_status
  public function update_status()
  {
    global $wpdb;
    $table = $wpdb->prefix . 'kaba_appointments';

    $id = intval($_POST['id']);
    $type = sanitize_text_field($_POST['type']);

    if ($type == 'approve') {
      $wpdb->update($table, ['status' => 'approved'], ['id' => $id]);
    }

    if ($type == 'reject') {
      $wpdb->update($table, ['status' => 'rejected'], ['id' => $id]);
    }

    if ($type == 'delete') {
      $wpdb->delete($table, ['id' => $id]);
    }

    wp_send_json_success();
  }

  // get_appointments
  public function get_appointments()
  {
    global $wpdb;

    $table = $wpdb->prefix . 'kaba_appointments';
    $data = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");

    wp_send_json($data);
  }

  // get_slots
  public function get_slots()
  {
    global $wpdb;
    $table = $wpdb->prefix . 'kaba_appointments';

    $date = sanitize_text_field($_POST['date']);

    // Fixed slots
    $all_slots = [
      '10:00:00',
      '11:00:00',
      '12:00:00',
      '13:00:00',
      '14:00:00',
    ];

    // Get booked slots
    $booked = $wpdb->get_col($wpdb->prepare(
      "SELECT appointment_time FROM $table WHERE appointment_date = %s",
      $date
    ));

    // Available = remove booked
    $available = array_diff($all_slots, $booked);

    wp_send_json($available);
  }
}
