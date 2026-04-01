<?php
if (!defined("ABSPATH")) exit;

class Kaba_Services
{
  public function get_services()
  {
    global $wpdb;
    $table = $wpdb->prefix . 'kaba_services';
    return $wpdb->get_results("SELECT * FROM $table");
  }
}
