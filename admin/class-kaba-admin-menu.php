<?php

/**
 * Admin Menu Class
 *
 * Creates WordPress admin menu pages for
 * Kaddora AI Booking & Appointment Scheduler.
 *
 * @package KaddoraAIBookingAppointmentScheduler
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('KABA_Admin_Menu')) {

	class KABA_Admin_Menu
	{

		/**
		 * Menu slug.
		 *
		 * @var string
		 */
		protected $menu_slug = 'kaba-dashboard';

		/**
		 * Constructor.
		 */
		public function __construct()
		{
			add_action('admin_menu', array($this, 'register_admin_menu'));
		}

		/**
		 * Register plugin admin menu and submenu pages.
		 *
		 * @return void
		 */
		public function register_admin_menu()
		{

			$capability = 'manage_options';

			add_menu_page(
				__('Kaddora Booking Scheduler', 'kaddora-ai-booking-appointment-scheduler'),
				__('Kaddora Booking', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				$this->menu_slug,
				array($this, 'render_dashboard_page'),
				'dashicons-calendar-alt',
				26
			);

			add_submenu_page(
				$this->menu_slug,
				__('Dashboard', 'kaddora-ai-booking-appointment-scheduler'),
				__('Dashboard', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				$this->menu_slug,
				array($this, 'render_dashboard_page')
			);

			add_submenu_page(
				$this->menu_slug,
				__('Appointments', 'kaddora-ai-booking-appointment-scheduler'),
				__('Appointments', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				'kaba-appointments',
				array($this, 'render_appointments_page')
			);

			add_submenu_page(
				$this->menu_slug,
				__('Services', 'kaddora-ai-booking-appointment-scheduler'),
				__('Services', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				'kaba-services',
				array($this, 'render_services_page')
			);

			add_submenu_page(
				$this->menu_slug,
				__('Staff', 'kaddora-ai-booking-appointment-scheduler'),
				__('Staff', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				'kaba-staff',
				array($this, 'render_staff_page')
			);

			add_submenu_page(
				$this->menu_slug,
				__('Customers', 'kaddora-ai-booking-appointment-scheduler'),
				__('Customers', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				'kaba-customers',
				array($this, 'render_customers_page')
			);

			add_submenu_page(
				$this->menu_slug,
				__('Automations', 'kaddora-ai-booking-appointment-scheduler'),
				__('Automations', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				'kaba-automations',
				array($this, 'render_automations_page')
			);

			add_submenu_page(
				$this->menu_slug,
				__('Analytics', 'kaddora-ai-booking-appointment-scheduler'),
				__('Analytics', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				'kaba-analytics',
				array($this, 'render_analytics_page')
			);

			add_submenu_page(
				$this->menu_slug,
				__('Settings', 'kaddora-ai-booking-appointment-scheduler'),
				__('Settings', 'kaddora-ai-booking-appointment-scheduler'),
				$capability,
				'kaba-settings',
				array($this, 'render_settings_page')
			);
		}

		/**
		 * Render dashboard page.
		 *
		 * @return void
		 */
		public function render_dashboard_page()
		{
			$this->load_view('dashboard.php', __('Dashboard file not found.', 'kaddora-ai-booking-appointment-scheduler'));
		}

		/**
		 * Render appointments page.
		 *
		 * @return void
		 */
		public function render_appointments_page()
		{
			$this->load_view('appointments.php', __('Appointments file not found.', 'kaddora-ai-booking-appointment-scheduler'));
		}

		/**
		 * Render services page.
		 *
		 * @return void
		 */
		public function render_services_page()
		{
			$this->load_view('services.php', __('Services file not found.', 'kaddora-ai-booking-appointment-scheduler'));
		}

		/**
		 * Render staff page.
		 *
		 * @return void
		 */
		public function render_staff_page()
		{
			$this->load_view('staff.php', __('Staff file not found.', 'kaddora-ai-booking-appointment-scheduler'));
		}

		/**
		 * Render customers page.
		 *
		 * @return void
		 */
		public function render_customers_page()
		{
			$this->load_view('customers.php', __('Customers file not found.', 'kaddora-ai-booking-appointment-scheduler'));
		}

		/**
		 * Render automations page.
		 *
		 * @return void
		 */
		public function render_automations_page()
		{
			$this->load_view('automations.php', __('Automations file not found.', 'kaddora-ai-booking-appointment-scheduler'));
		}

		/**
		 * Render analytics page.
		 *
		 * @return void
		 */
		public function render_analytics_page()
		{
			$this->load_view('analytics.php', __('Analytics file not found.', 'kaddora-ai-booking-appointment-scheduler'));
		}

		/**
		 * Render settings page.
		 *
		 * @return void
		 */
		public function render_settings_page()
		{
			$this->load_view('settings.php', __('Settings file not found.', 'kaddora-ai-booking-appointment-scheduler'));
		}

		/**
		 * Load admin view file safely.
		 *
		 * @param string $file          File name.
		 * @param string $fallback_text Fallback message.
		 * @return void
		 */
		protected function load_view($file, $fallback_text = '')
		{

			$view_path = trailingslashit(KABA_PLUGIN_DIR) . 'admin/views/' . $file;

			echo '<div class="wrap kaba-admin-wrap">';

			if (file_exists($view_path)) {
				include $view_path;
			} else {
				echo '<h1>' . esc_html__('Kaddora AI Booking & Appointment Scheduler', 'kaddora-ai-booking-appointment-scheduler') . '</h1>';
				echo '<div class="notice notice-warning"><p>' . esc_html($fallback_text) . '</p></div>';
			}

			echo '</div>';
		}
	}
}
