<?php

if (!defined('ABSPATH')) exit;

class Kaba_Activator
{
  public static function activate()
  {
    require_once KABA_PLUGIN_DIR . 'includes/core/class-kaba-db.php';
    Kaba_DB::create_tables();
  }
}
