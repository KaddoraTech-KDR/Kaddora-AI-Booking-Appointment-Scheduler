<?php
if (!defined("ABSPATH")) exit;

class Kaba_Appointments
{
  public function init()
  {
    add_action("init", array($this, "handle_booking_form"));
  }

  // handle_booking_form
  public function handle_booking_form()
  {
    if (!isset($_POST['kaba_submit_booking'])) {
      return;
    }

    $name  = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $service = sanitize_text_field($_POST['service']);
    $date = sanitize_text_field($_POST['appointment_date']);
    $time = sanitize_text_field($_POST['appointment_time']);

    if (empty($name) || empty($email)) {
      wp_die("Name & Email are required");
    }

    global $wpdb;
    $table = $wpdb->prefix . "kaba_appointments";

    $wpdb->insert(
      $table,
      array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'service' => $service,
        'appointment_date' => $date,
        'appointment_time' => $time,
        'status' => 'pending'
      ),
      array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    $this->send_booking_email($email, $name, $date, $time);

    wp_redirect(add_query_arg('booking', 'success', wp_get_referer()));
    exit;
  }

  // send_booking_email
  private function send_booking_email($email, $name, $date, $time)
  {

    $subject = "Appointment Confirmation";

    $message = "Hi $name,\n\n";
    $message .= "Your appointment is booked successfully.\n";
    $message .= "Date: $date\n";
    $message .= "Time: $time\n\n";
    $message .= "Thank you.";

    wp_mail($email, $subject, $message);
  }
}
