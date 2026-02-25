<?php
/**
 * Admin menu and dashboard renderer.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin menu manager.
 */
class rahad_Admin_Menu {

	/**
	 * Main plugin reference.
	 *
	 * @var rahad_Plugin
	 */
	private $rahad_plugin;

	/**
	 * Constructor.
	 *
	 * @param rahad_Plugin $rahad_plugin Plugin singleton.
	 */
	public function __construct( $rahad_plugin ) {
		$this->rahad_plugin = $rahad_plugin;

		add_action( 'admin_menu', array( $this, 'rahad_register_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'rahad_enqueue_admin_assets' ) );
	}

	/**
	 * Register plugin pages.
	 *
	 * @return void
	 */
	public function rahad_register_admin_menu() {
		add_menu_page(
			__( 'Rah Power Addons', 'rah-power-addons' ),
			__( 'Rah Power Addons', 'rah-power-addons' ),
			'manage_options',
			'rahad_dashboard',
			array( $this, 'rahad_render_dashboard_page' ),
			'dashicons-admin-plugins',
			58
		);

		add_submenu_page(
			'rahad_dashboard',
			__( 'Dashboard', 'rah-power-addons' ),
			__( 'Dashboard', 'rah-power-addons' ),
			'manage_options',
			'rahad_dashboard',
			array( $this, 'rahad_render_dashboard_page' )
		);

		add_submenu_page(
			'rahad_dashboard',
			__( 'Header Footer Builder', 'rah-power-addons' ),
			__( 'Header Footer Builder', 'rah-power-addons' ),
			'manage_options',
			'edit.php?post_type=rahad_template'
		);
	}

	/**
	 * Enqueue admin script/style.
	 *
	 * @param string $rahad_hook_suffix Admin page hook.
	 * @return void
	 */
	public function rahad_enqueue_admin_assets( $rahad_hook_suffix ) {
		if ( 'toplevel_page_rahad_dashboard' !== $rahad_hook_suffix ) {
			return;
		}

		// Check if build files exist
		$rahad_css_file = rahad_PLUGIN_PATH . 'build/admin-dashboard.css';
		$rahad_js_file  = rahad_PLUGIN_PATH . 'build/admin-dashboard.js';
		
		// Only enqueue if build files exist
		if ( file_exists( $rahad_css_file ) && file_exists( $rahad_js_file ) ) {
			$rahad_asset_file = rahad_PLUGIN_PATH . 'build/admin-dashboard.asset.php';
			$rahad_asset_data = array(
				'dependencies' => array( 'wp-element', 'wp-components', 'wp-api-fetch', 'wp-i18n' ),
				'version'      => rahad_PLUGIN_VERSION,
			);

			if ( file_exists( $rahad_asset_file ) ) {
				$rahad_asset_data = require $rahad_asset_file;
			}

			wp_enqueue_style(
				'rahad_admin_dashboard',
				rahad_PLUGIN_URL . 'build/admin-dashboard.css',
				array( 'wp-components' ),
				rahad_PLUGIN_VERSION
			);

			wp_enqueue_script(
				'rahad_admin_dashboard',
				rahad_PLUGIN_URL . 'build/admin-dashboard.js',
				$rahad_asset_data['dependencies'],
				$rahad_asset_data['version'],
				true
			);

			wp_localize_script(
				'rahad_admin_dashboard',
				'rahadAdminData',
				array(
					'rahad_rest_url'        => esc_url_raw( rest_url( 'rahad/v1' ) ),
					'rahad_nonce'           => wp_create_nonce( 'wp_rest' ),
					'rahad_dashboard_data'  => $this->rahad_plugin->rahad_get_dashboard_data(),
					'rahad_elementor_active' => did_action( 'elementor/loaded' ),
				)
			);
		} else {
			// Fallback: Show simple admin notice if build files are missing
			add_action( 'admin_notices', array( $this, 'rahad_build_missing_notice' ) );
		}
	}

	/**
	 * Show notice about missing build files.
	 *
	 * @return void
	 */
	public function rahad_build_missing_notice() {
		?>
		<div class="notice notice-warning">
			<p>
				<?php
				printf(
					/* translators: %s: Build command */
					esc_html__( 'Rah Power Addons: Admin dashboard build files are missing. Please run %s to generate them.', 'rah-power-addons' ),
					'<code>npm run build</code>'
				);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Render dashboard root.
	 *
	 * @return void
	 */
	public function rahad_render_dashboard_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap rahad-dashboard-wrap">
			<h1><?php echo esc_html__( 'Rah Power Addons for Elementor', 'rah-power-addons' ); ?></h1>
			<div id="rahad-admin-dashboard-root"></div>
			<noscript>
				<p><?php echo esc_html__( 'JavaScript is required for the React dashboard.', 'rah-power-addons' ); ?></p>
			</noscript>
		</div>
		<?php
	}
}
