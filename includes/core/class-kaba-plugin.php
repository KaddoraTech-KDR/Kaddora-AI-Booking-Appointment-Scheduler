<?php

if (!defined('ABSPATH')) {
  exit;
}

class Kaba_Plugin
{
  protected $admin;
  protected $public;

  protected $appointments;
  protected $ajax;
  protected $services;
  protected $staff;
  protected $customers;
  protected $automation;
  protected $ai;
  protected $analytics;

  public function __construct()
  {
    $this->load_dependencies();

    // Initialize modules
    $this->init_modules();

    // Initialize admin & public
    $this->init_admin();
    $this->init_public();

    // Hooks
    $this->define_hooks();
  }

  /**
   * Load required classes
   */
  private function load_dependencies()
  {
    // Modules
    $this->appointments = new Kaba_Appointments();
    $this->services     = new Kaba_Services();
    $this->staff        = new Kaba_Staff();
    $this->customers    = new Kaba_Customers();
    $this->automation   = new Kaba_Automation();
    $this->ai           = new Kaba_AI();
    $this->analytics    = new Kaba_Analytics();

    // // Integrations (optional init here if needed)
    $this->ajax = new Kaba_Ajax();
    // new Kaba_WooCommerce();
    // new Kaba_Google_Calendar();
    // new Kaba_Webhooks();
  }

  /**
   * Initialize modules
   */
  private function init_modules()
  {

    if (method_exists($this->appointments, 'init')) {
      $this->appointments->init();
    }

    if (method_exists($this->ajax, "init")) {
      $this->ajax->init();
    }

    if (method_exists($this->staff, 'init')) {
      $this->staff->init();
    }

    if (method_exists($this->customers, 'init')) {
      $this->customers->init();
    }

    if (method_exists($this->automation, 'init')) {
      $this->automation->init();
    }

    if (method_exists($this->ai, 'init')) {
      $this->ai->init();
    }

    if (method_exists($this->analytics, 'init')) {
      $this->analytics->init();
    }
  }

  /**
   * Initialize admin
   */
  private function init_admin()
  {
    if (is_admin()) {
      $this->admin = new Kaba_Admin();
    }
  }

  /**
   * Initialize public
   */
  private function init_public()
  {
    $this->public = new Kaba_Public();
  }

  /**
   * Define hooks
   */
  private function define_hooks()
  {
    // Enqueue Admin Assets
    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

    // Enqueue Public Assets
    add_action('wp_enqueue_scripts', array($this, 'enqueue_public_assets'));

    // Shortcode for booking form
    add_shortcode('kaba_booking_form', array($this, 'render_booking_form'));
  }

  /**
   * Enqueue Admin CSS/JS
   */
  public function enqueue_admin_assets()
  {
    wp_enqueue_style(
      'kaba-admin-css',
      KABA_PLUGIN_URL . 'assets/css/admin.css',
      array(),
      KABA_VERSION
    );

    wp_enqueue_script(
      'kaba-admin-js',
      KABA_PLUGIN_URL . 'assets/js/admin.js',
      array('jquery'),
      KABA_VERSION,
      true
    );
  }

  /**
   * Enqueue Public CSS/JS
   */
  public function enqueue_public_assets()
  {
    wp_enqueue_style(
      'kaba-public-css',
      KABA_PLUGIN_URL . 'assets/css/public.css',
      array(),
      KABA_VERSION
    );

    wp_enqueue_script(
      'kaba-public-js',
      KABA_PLUGIN_URL . 'assets/js/public.js',
      array('jquery'),
      KABA_VERSION,
      true
    );

    wp_localize_script(
      'kaba-public-js',
      'kaba_ajax',
      [
        'ajax_url' => admin_url('admin-ajax.php')
      ]
    );
  }

  /**
   * Render Booking Form (Shortcode)
   */
  public function render_booking_form()
  {

    ob_start();

    $template = KABA_PLUGIN_DIR . 'public/templates/booking-form.php';

    if (file_exists($template)) {
      include $template;
    } else {
      echo "<p>Booking form not found.</p>";
    }

    return ob_get_clean();
  }

  /**
   * Run plugin
   */
  public function run()
  {
    // Plugin execution starts here
  }
}
