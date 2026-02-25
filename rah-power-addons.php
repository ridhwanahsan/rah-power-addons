<?php
/**
 * Plugin Name: Rah Power Addons for Elementor
 * Plugin URI:  https://example.com/rah-power-addons
 * Description: Advanced widgets, header footer builder, template library, animations, conditional display, and developer tools for Elementor users.
 * Version:     1.0.0
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Author:      Ridhwan Ahsan
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: rah-power-addons
 * Domain Path: /languages
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Rah Power Addons Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class RahPowerAddons {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var RahPowerAddons The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return RahPowerAddons An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		// Define constants first
		$this->define_constants();

		// Load basic files that don't require Elementor
		$this->load_basic_files();

		// Setup WordPress hooks
		$this->setup_hooks();

		// Load Elementor-dependent features
		if ( did_action( 'elementor/loaded' ) ) {
			add_action( 'plugins_loaded', array( $this, 'init' ) );
		}
	}

	/**
	 * Define Constants
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_constants() {
		if ( ! defined( 'rahad_PLUGIN_VERSION' ) ) {
			define( 'rahad_PLUGIN_VERSION', ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : self::VERSION );
		}

		if ( ! defined( 'rahad_PLUGIN_FILE' ) ) {
			define( 'rahad_PLUGIN_FILE', __FILE__ );
		}

		if ( ! defined( 'rahad_PLUGIN_BASENAME' ) ) {
			define( 'rahad_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		}

		if ( ! defined( 'rahad_PLUGIN_PATH' ) ) {
			define( 'rahad_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		}

		if ( ! defined( 'rahad_PLUGIN_URL' ) ) {
			define( 'rahad_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'rahad_MIN_PHP_VERSION' ) ) {
			define( 'rahad_MIN_PHP_VERSION', self::MINIMUM_PHP_VERSION );
		}

		if ( ! defined( 'rahad_MIN_ELEMENTOR_VERSION' ) ) {
			define( 'rahad_MIN_ELEMENTOR_VERSION', self::MINIMUM_ELEMENTOR_VERSION );
		}
	}

	/**
	 * Load plugin textdomain
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'rah-power-addons', false, dirname( rahad_PLUGIN_BASENAME ) . '/languages' );
	}

	/**
	 * Setup WordPress hooks
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function setup_hooks() {
		// Load text domain at init hook
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Register activation/deactivation hooks
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
	}

	/**
	 * Load basic files that don't require Elementor
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_basic_files() {
		// Admin notice - load this first and unconditionally
		require_once rahad_PLUGIN_PATH . 'includes/class-rahad-admin-notices.php';

		// Initialize admin notice
		new rahad_Admin_Notices();

		// Admin menu - load unconditionally
		require_once rahad_PLUGIN_PATH . 'admin/class-rahad-admin-menu.php';
		new rahad_Admin_Menu( $this );

		// Widget manager - needed for admin
		require_once rahad_PLUGIN_PATH . 'includes/class-rahad-widget-manager.php';
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor is loaded.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {
		// Check minimum Elementor version
		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Load all Elementor-dependent files
		$this->load_elementor_files();

		// Initialize classes
		$this->initialize_classes();

		// Setup Elementor hooks
		$this->setup_elementor_hooks();
	}

	/**
	 * Load Elementor-dependent files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_elementor_files() {
		// Widget manager (reinitialize with all widgets)
		$this->rahad_widget_manager = new rahad_Widget_Manager();

		// Performance module
		require_once rahad_PLUGIN_PATH . 'includes/class-rahad-assets-manager.php';
		require_once rahad_PLUGIN_PATH . 'modules/performance/class-rahad-performance-module.php';
		$this->rahad_performance_module = new rahad_Performance_Module( $this->rahad_widget_manager );

		// Admin REST API
		require_once rahad_PLUGIN_PATH . 'admin/class-rahad-admin-rest.php';
		new rahad_Admin_Rest( $this->rahad_widget_manager, $this->rahad_performance_module );

		// Modules
		require_once rahad_PLUGIN_PATH . 'modules/custom-code/class-rahad-custom-code-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/role-manager/class-rahad-role-manager-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/header-footer/class-rahad-header-footer-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/template-library/class-rahad-template-library-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/conditional-display/class-rahad-conditional-display-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/custom-css/class-rahad-custom-css-module.php';
		require_once rahad_PLUGIN_PATH . 'modules/animations/class-rahad-animations-module.php';

		// Widget loader
		require_once rahad_PLUGIN_PATH . 'widgets/class-rahad-elementor-widget-loader.php';
	}

	/**
	 * Initialize required classes
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function initialize_classes() {
		new rahad_Assets_Manager( $this->rahad_widget_manager, $this->rahad_performance_module );
		new rahad_Custom_Code_Module();
		new rahad_Role_Manager_Module();
		new rahad_Elementor_Widget_Loader( $this->rahad_widget_manager );
		new rahad_Header_Footer_Module();
		new rahad_Template_Library_Module();
		new rahad_Conditional_Display_Module();
		new rahad_Custom_CSS_Module();
		new rahad_Animations_Module();
	}

	/**
	 * Setup Elementor-specific hooks
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function setup_elementor_hooks() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_new_category' ) );
	}

	/**
	 * Register new Elementor categories
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param object $elements_manager Elementor elements manager
	 */
	public function register_new_category( $elements_manager ) {
		$elements_manager->add_category(
			'rahad_widgets',
			array(
				'title' => __( 'Rah Power Addons', 'rah-power-addons' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Admin notice for minimum Elementor version
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		?>
		<div class="notice notice-error">
			<p>
				<?php
				echo sprintf(
					/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
					esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'rah-power-addons' ),
					'<strong>' . esc_html__( 'Rah Power Addons', 'rah-power-addons' ) . '</strong>',
					'<strong>' . esc_html__( 'Elementor', 'rah-power-addons' ) . '</strong>',
					rahad_MIN_ELEMENTOR_VERSION
				);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Get dashboard bootstrap payload.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array<string,mixed>
	 */
	public function rahad_get_dashboard_data() {
		$rahad_available_widgets = isset( $this->rahad_widget_manager ) ? $this->rahad_widget_manager->rahad_get_available_widgets() : array();
		$rahad_enabled_widgets    = isset( $this->rahad_widget_manager ) ? $this->rahad_widget_manager->rahad_get_enabled_widgets() : array();

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
	 * Plugin activation
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function activate() {
		// Include activator and run activation
		require_once rahad_PLUGIN_PATH . 'includes/class-rahad-activator.php';
		rahad_Activator::rahad_activate();
	}

	/**
	 * Plugin deactivation
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function deactivate() {
		require_once rahad_PLUGIN_PATH . 'includes/class-rahad-activator.php';
		rahad_Activator::rahad_deactivate();
	}
}

RahPowerAddons::instance();
