<?php
if (!defined('ABSPATH')) exit;

class Kaba_AI
{
  public function init()
  {
    // AI module initialized
  }

  public function suggest_slot($slots)
  {
    return !empty($slots) ? $slots[0] : null;
  }
}
