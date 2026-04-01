<?php

if (!defined('ABSPATH')) exit;

class Kaba_Admin
{

  public function __construct()
  {
    $this->load_menu();
  }

  private function load_menu()
  {
    new Kaba_Admin_Menu();
  }
}
