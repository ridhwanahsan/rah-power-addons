<?php
/**
 * REST API endpoints for dashboard settings.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin REST controller.
 */
class rahad_Admin_Rest {

	/**
	 * Widget manager.
	 *
	 * @var rahad_Widget_Manager
	 */
	private $rahad_widget_manager;

	/**
	 * Performance module.
	 *
	 * @var rahad_Performance_Module
	 */
	private $rahad_performance_module;

	/**
	 * Constructor.
	 *
	 * @param rahad_Widget_Manager     $rahad_widget_manager Widget manager.
	 * @param rahad_Performance_Module $rahad_performance_module Performance module.
	 */
	public function __construct( $rahad_widget_manager, $rahad_performance_module ) {
		$this->rahad_widget_manager     = $rahad_widget_manager;
		$this->rahad_performance_module = $rahad_performance_module;

		add_action( 'rest_api_init', array( $this, 'rahad_register_routes' ) );
	}

	/**
	 * Register REST routes.
	 *
	 * @return void
	 */
	public function rahad_register_routes() {
		register_rest_route(
			'rahad/v1',
			'/settings',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'rahad_get_settings' ),
					'permission_callback' => array( $this, 'rahad_manage_options_permission' ),
				),
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'rahad_update_settings' ),
					'permission_callback' => array( $this, 'rahad_manage_options_permission' ),
				),
			)
		);

		register_rest_route(
			'rahad/v1',
			'/system-info',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'rahad_get_system_info' ),
				'permission_callback' => array( $this, 'rahad_manage_options_permission' ),
			)
		);

		register_rest_route(
			'rahad/v1',
			'/recommended-plugins',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'rahad_get_recommended_plugins' ),
				'permission_callback' => array( $this, 'rahad_manage_options_permission' ),
			)
		);
	}

	/**
	 * Permission callback.
	 *
	 * @return bool
	 */
	public function rahad_manage_options_permission() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Get dashboard settings.
	 *
	 * @return WP_REST_Response
	 */
	public function rahad_get_settings() {
		$rahad_templates = get_posts(
			array(
				'post_type'      => 'rahad_template',
				'post_status'    => array( 'publish', 'draft' ),
				'posts_per_page' => 200,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		$rahad_template_options = array();
		foreach ( $rahad_templates as $rahad_template ) {
			$rahad_template_options[] = array(
				'rahad_id'    => (int) $rahad_template->ID,
				'rahad_title' => $rahad_template->post_title ? $rahad_template->post_title : __( '(no title)', 'rah-power-addons' ),
				'rahad_url'   => get_edit_post_link( $rahad_template->ID, 'raw' ),
			);
		}

		return rest_ensure_response(
			array(
				'rahad_widgets' => array(
					'rahad_available' => $this->rahad_widget_manager->rahad_get_available_widgets(),
					'rahad_enabled'   => $this->rahad_widget_manager->rahad_get_enabled_widgets(),
				),
				'rahad_settings' => array(
					'rahad_performance'   => $this->rahad_performance_module->rahad_get_performance_settings(),
					'rahad_custom_code'   => get_option( 'rahad_custom_code_settings', array() ),
					'rahad_role_manager'  => get_option( 'rahad_role_settings', array() ),
					'rahad_header_footer' => get_option( 'rahad_header_footer_settings', array() ),
					'rahad_animations'    => get_option( 'rahad_animation_settings', array() ),
				),
				'rahad_templates' => $rahad_template_options,
			)
		);
	}

	/**
	 * Update dashboard settings.
	 *
	 * @param WP_REST_Request $rahad_request Request object.
	 * @return WP_REST_Response|WP_Error
	 */
	public function rahad_update_settings( WP_REST_Request $rahad_request ) {
		$rahad_nonce = (string) $rahad_request->get_header( 'x_wp_nonce' );
		if ( ! wp_verify_nonce( $rahad_nonce, 'wp_rest' ) ) {
			return new WP_Error( 'rahad_invalid_nonce', __( 'Invalid nonce.', 'rah-power-addons' ), array( 'status' => 403 ) );
		}

		$rahad_params = $rahad_request->get_json_params();
		if ( ! is_array( $rahad_params ) ) {
			$rahad_params = array();
		}

		if ( isset( $rahad_params['rahad_widgets'] ) && is_array( $rahad_params['rahad_widgets'] ) ) {
			$this->rahad_widget_manager->rahad_save_widget_settings( $rahad_params['rahad_widgets'] );
		}

		if ( isset( $rahad_params['rahad_performance'] ) && is_array( $rahad_params['rahad_performance'] ) ) {
			$this->rahad_performance_module->rahad_update_performance_settings( $rahad_params['rahad_performance'] );
		}

		if ( isset( $rahad_params['rahad_custom_code'] ) && is_array( $rahad_params['rahad_custom_code'] ) ) {
			$rahad_custom_code = rahad_Custom_Code_Module::rahad_sanitize_settings( $rahad_params['rahad_custom_code'] );
			update_option( 'rahad_custom_code_settings', $rahad_custom_code, false );
		}

		if ( isset( $rahad_params['rahad_role_manager'] ) && is_array( $rahad_params['rahad_role_manager'] ) ) {
			$rahad_role_settings = rahad_Role_Manager_Module::rahad_sanitize_settings( $rahad_params['rahad_role_manager'] );
			update_option( 'rahad_role_settings', $rahad_role_settings, false );
		}

		if ( isset( $rahad_params['rahad_animations'] ) && is_array( $rahad_params['rahad_animations'] ) ) {
			$rahad_animations = array(
				'rahad_enabled'  => ! empty( $rahad_params['rahad_animations']['rahad_enabled'] ) ? 1 : 0,
				'rahad_duration' => isset( $rahad_params['rahad_animations']['rahad_duration'] ) ? (float) $rahad_params['rahad_animations']['rahad_duration'] : 0.8,
				'rahad_ease'     => isset( $rahad_params['rahad_animations']['rahad_ease'] ) ? sanitize_text_field( wp_unslash( $rahad_params['rahad_animations']['rahad_ease'] ) ) : 'power2.out',
			);
			update_option( 'rahad_animation_settings', $rahad_animations, false );
		}

		if ( isset( $rahad_params['rahad_header_footer'] ) && is_array( $rahad_params['rahad_header_footer'] ) ) {
			$rahad_header_footer = array(
				'rahad_header_template_id' => isset( $rahad_params['rahad_header_footer']['rahad_header_template_id'] ) ? absint( $rahad_params['rahad_header_footer']['rahad_header_template_id'] ) : 0,
				'rahad_footer_template_id' => isset( $rahad_params['rahad_header_footer']['rahad_footer_template_id'] ) ? absint( $rahad_params['rahad_header_footer']['rahad_footer_template_id'] ) : 0,
			);
			update_option( 'rahad_header_footer_settings', $rahad_header_footer, false );
		}

		return $this->rahad_get_settings();
	}

	/**
	 * Provide system information.
	 *
	 * @return WP_REST_Response
	 */
	public function rahad_get_system_info() {
		$rahad_system_info = array(
			'rahad_wordpress_version' => get_bloginfo( 'version' ),
			'rahad_php_version'       => PHP_VERSION,
			'rahad_elementor_version' => defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : __( 'Not Active', 'rah-power-addons' ),
			'rahad_memory_limit'      => ini_get( 'memory_limit' ),
			'rahad_site_url'          => site_url(),
			'rahad_plugin_version'    => rahad_PLUGIN_VERSION,
		);

		return rest_ensure_response( $rahad_system_info );
	}

	/**
	 * Recommended plugin list.
	 *
	 * @return WP_REST_Response
	 */
	public function rahad_get_recommended_plugins() {
		return rest_ensure_response(
			array(
				array(
					'rahad_name'        => 'Elementor',
					'rahad_slug'        => 'elementor',
					'rahad_description' => __( 'Core page builder dependency.', 'rah-power-addons' ),
				),
				array(
					'rahad_name'        => 'WPForms Lite',
					'rahad_slug'        => 'wpforms-lite',
					'rahad_description' => __( 'Lightweight form builder for CTA widgets.', 'rah-power-addons' ),
				),
				array(
					'rahad_name'        => 'LiteSpeed Cache',
					'rahad_slug'        => 'litespeed-cache',
					'rahad_description' => __( 'Caching and frontend optimization.', 'rah-power-addons' ),
				),
			)
		);
	}
}
