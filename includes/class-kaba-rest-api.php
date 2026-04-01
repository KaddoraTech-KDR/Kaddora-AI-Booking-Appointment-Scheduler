<?php
if (!defined('ABSPATH')) exit;

class Kaba_REST_API
{
  public function init()
  {
    add_action('rest_api_init', [$this, 'register_routes']);
  }

  public function register_routes()
  {

    register_rest_route('kaba/v1', '/appointments', [
      'methods' => 'GET',
      'callback' => [$this, 'get_appointments']
    ]);
  }

  public function get_appointments()
  {
    return ['message' => 'API working'];
  }
}
