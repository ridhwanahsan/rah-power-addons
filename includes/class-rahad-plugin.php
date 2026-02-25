<?php
/**
 * Main plugin bootstrap class.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
class rahad_Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var rahad_Plugin|null
	 */
	private static $rahad_instance = null;

	/**
	 * Widget manager instance.
	 *
	 * @var rahad_Widget_Manager
	 */
	private $rahad_widget_manager;

	/**
	 * Performance module instance.
	 *
	 * @var rahad_Performance_Module
	 */
	private $rahad_performance_module;

	/**
	 * Get singleton.
	 *
	 * @return rahad_Plugin
	 */
	public static function rahad_get_instance() {
		if ( null === self::$rahad_instance ) {
			self::$rahad_instance = new self();
		}

		return self::$rahad_instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->rahad_include_files();
		$this->rahad_register_hooks();
	}

	/**
	 * Include plugin files.
	 *
	 * @return void
	 */
	private function rahad_include_files() {
		require_once rahad_PLUGIN_PATH . 'includes/class-rahad-admin-notices.php';
		require_once rahad_PLUGIN_PATH . 'includes/class-rahad-widget-manager.php';
		require_once rahad_PLUGIN_PATH . 'includes/class-rahad-assets-manager.php';
		require_once rahad_PLUGIN_PATH . 'admin/class-rahad-admin-menu.php';
		require_once rahad_PLUGIN_PATH . 'admin/class-rahad-admin-rest.php';
		require_once rahad_PLUGIN_PATH . 'modules/performance/class-rahad-performance-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/custom-code/class-rahad-custom-code-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/role-manager/class-rahad-role-manager-module.php';
		require_once rahad_PLUGIN_PATH . 'widgets/class-rahad-elementor-widget-loader.php';
		require_once rahad_PLUGIN_PATH . 'modules/header-footer/class-rahad-header-footer-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/template-library/class-rahad-template-library-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/conditional-display/class-rahad-conditional-display-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/custom-css/class-rahad-custom-css-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/animations/class-rahad-animations-module.php';
	}

	/**
	 * Register primary hooks.
	 *
	 * @return void
	 */
	private function rahad_register_hooks() {
		add_action( 'init', array( $this, 'rahad_load_textdomain' ) );
		add_action( 'plugins_loaded', array( $this, 'rahad_boot_plugin' ), 20 );
	}

	/**
	 * Load translations.
	 *
	 * @return void
	 */
	public function rahad_load_textdomain() {
		load_plugin_textdomain( 'rah-power-addons', false, dirname( rahad_PLUGIN_BASENAME ) . '/languages' );
	}

	/**
	 * Initialize services.
	 *
	 * @return void
	 */
	public function rahad_boot_plugin() {
		// Always create admin menu first - even if Elementor is not installed
		$this->rahad_widget_manager     = new rahad_Widget_Manager();
		$this->rahad_performance_module = new rahad_Performance_Module( $this->rahad_widget_manager );

		new rahad_Admin_Menu( $this );

		if ( version_compare( PHP_VERSION, rahad_MIN_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( 'rahad_Admin_Notices', 'rahad_php_version_notice' ) );
			return;
		}

		new rahad_Assets_Manager( $this->rahad_widget_manager, $this->rahad_performance_module );
		new rahad_Custom_Code_Module();
		new rahad_Role_Manager_Module();
		new rahad_Admin_Rest( $this->rahad_widget_manager, $this->rahad_performance_module );

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( 'rahad_Admin_Notices', 'rahad_elementor_missing_notice' ) );
			return;
		}

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, rahad_MIN_ELEMENTOR_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( 'rahad_Admin_Notices', 'rahad_elementor_version_notice' ) );
			return;
		}

		new rahad_Elementor_Widget_Loader( $this->rahad_widget_manager );
		new rahad_Header_Footer_Module();
		new rahad_Template_Library_Module();
		new rahad_Conditional_Display_Module();
		new rahad_Custom_CSS_Module();
		new rahad_Animations_Module();
	}

	/**
	 * Get dashboard bootstrap payload.
	 *
	 * @return array<string,mixed>
	 */
	public function rahad_get_dashboard_data() {
		$rahad_available_widgets = $this->rahad_widget_manager ? $this->rahad_widget_manager->rahad_get_available_widgets() : array();
		$rahad_enabled_widgets   = $this->rahad_widget_manager ? $this->rahad_widget_manager->rahad_get_enabled_widgets() : array();

		return array(
			'rahad_widgets' => array(
				'rahad_available' => $rahad_available_widgets,
				'rahad_enabled'   => $rahad_enabled_widgets,
			),
			'rahad_settings' => array(
				'rahad_performance'   => get_option( 'rahad_performance_settings', array() ),
				'rahad_custom_code'   => get_option( 'rahad_custom_code_settings', array() ),
				'rahad_role_manager'  => get_option( 'rahad_role_settings', array() ),
				'rahad_header_footer' => get_option( 'rahad_header_footer_settings', array() ),
				'rahad_animations'    => get_option( 'rahad_animation_settings', array() ),
			),
			'rahad_stats'    => array(
				'rahad_total_widgets'   => count( $rahad_available_widgets ),
				'rahad_enabled_widgets' => count( array_filter( $rahad_enabled_widgets ) ),
				'rahad_templates'       => (int) wp_count_posts( 'rahad_template' )->publish,
			),
		);
	}

	/**
	 * Get widget manager.
	 *
	 * @return rahad_Widget_Manager|null
	 */
	public function rahad_get_widget_manager() {
		return $this->rahad_widget_manager;
	}

	/**
	 * Get performance module.
	 *
	 * @return rahad_Performance_Module|null
	 */
	public function rahad_get_performance_module() {
		return $this->rahad_performance_module;
	}
}
