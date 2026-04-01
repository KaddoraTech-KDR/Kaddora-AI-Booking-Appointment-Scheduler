<?php

/**
 * Plugin Name: Kaddora AI Booking & Appointment Scheduler
 * Description: AI-powered booking and appointment scheduling system for WordPress.
 * Version: 1.0.0
 * Author: Kaddora
 * Text Domain: kaddora-ai-booking
 */

if (!defined('ABSPATH')) {
  exit;
}

// ========================================
// DEFINE CONSTANTS
// ========================================
define('KABA_VERSION', '1.0.0');
define('KABA_PLUGIN_FILE', __FILE__);
define('KABA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('KABA_PLUGIN_URL', plugin_dir_url(__FILE__));

// ========================================
// LOAD CORE FILES
// ========================================
require_once KABA_PLUGIN_DIR . 'includes/core/class-kaba-plugin.php';
require_once KABA_PLUGIN_DIR . 'includes/core/class-kaba-db.php';
require_once KABA_PLUGIN_DIR . 'includes/core/class-kaba-helper.php';

// ========================================
// LOAD ADMIN FILES
// ========================================
if (is_admin()) {
  require_once KABA_PLUGIN_DIR . 'admin/class-kaba-admin.php';
  require_once KABA_PLUGIN_DIR . 'admin/class-kaba-admin-menu.php';
}

// ========================================
// LOAD PUBLIC FILES
// ========================================
require_once KABA_PLUGIN_DIR . 'public/class-kaba-public.php';

// ========================================
// LOAD MODULES
// ========================================
require_once KABA_PLUGIN_DIR . 'includes/modules/class-kaba-appointments.php';
require_once KABA_PLUGIN_DIR . 'includes/modules/class-kaba-services.php';
require_once KABA_PLUGIN_DIR . 'includes/modules/class-kaba-staff.php';
require_once KABA_PLUGIN_DIR . 'includes/modules/class-kaba-customers.php';
require_once KABA_PLUGIN_DIR . 'includes/modules/class-kaba-automation.php';
require_once KABA_PLUGIN_DIR . 'includes/modules/class-kaba-ai.php';
require_once KABA_PLUGIN_DIR . 'includes/modules/class-kaba-analytics.php';

// ========================================
// LOAD INTEGRATIONS
// ========================================
require_once KABA_PLUGIN_DIR . 'includes/integrations/class-kaba-woocommerce.php';
require_once KABA_PLUGIN_DIR . 'includes/integrations/class-kaba-google-calendar.php';
require_once KABA_PLUGIN_DIR . 'includes/integrations/class-kaba-webhooks.php';
require_once KABA_PLUGIN_DIR . "includes/class-kaba-ajax.php";

// ========================================
// ACTIVATION & DEACTIVATION
// ========================================
register_activation_hook(__FILE__, 'kaba_activate_plugin');
register_deactivation_hook(__FILE__, 'kaba_deactivate_plugin');

function kaba_activate_plugin()
{
  require_once KABA_PLUGIN_DIR . 'includes/class-kaba-activator.php';
  Kaba_Activator::activate();
}

function kaba_deactivate_plugin()
{
  require_once KABA_PLUGIN_DIR . 'includes/class-kaba-deactivator.php';
  Kaba_Deactivator::deactivate();
}

// ========================================
// INITIALIZE PLUGIN
// ========================================

function kaba_run_plugin()
{
  $plugin = new Kaba_Plugin();
  $plugin->run();
}

kaba_run_plugin();
