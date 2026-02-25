<?php
/**
 * Template library module.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles template library operations.
 */
class rahad_Template_Library_Module {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'rahad_register_template_routes' ) );
	}

	/**
	 * Register template library routes.
	 *
	 * @return void
	 */
	public function rahad_register_template_routes() {
		register_rest_route(
			'rahad/v1',
			'/template-library',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'rahad_get_templates' ),
					'permission_callback' => array( $this, 'rahad_template_permission' ),
				),
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'rahad_import_template' ),
					'permission_callback' => array( $this, 'rahad_template_permission' ),
				),
			)
		);

		register_rest_route(
			'rahad/v1',
			'/template-library/(?P<id>\d+)',
			array(
				'methods'             => WP_REST_Server::DELETABLE,
				'callback'            => array( $this, 'rahad_delete_template' ),
				'permission_callback' => array( $this, 'rahad_template_permission' ),
			)
		);
	}

	/**
	 * Permissions.
	 *
	 * @return bool
	 */
	public function rahad_template_permission() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Get template list.
	 *
	 * @return WP_REST_Response
	 */
	public function rahad_get_templates() {
		$rahad_posts = get_posts(
			array(
				'post_type'      => 'rahad_template',
				'post_status'    => array( 'publish', 'draft' ),
				'posts_per_page' => 200,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		$rahad_output = array();

		foreach ( $rahad_posts as $rahad_post ) {
			$rahad_output[] = array(
				'rahad_id'           => (int) $rahad_post->ID,
				'rahad_title'        => $rahad_post->post_title,
				'rahad_status'       => $rahad_post->post_status,
				'rahad_type'         => get_post_meta( $rahad_post->ID, 'rahad_template_type', true ),
				'rahad_edit_url'     => get_edit_post_link( $rahad_post->ID, 'raw' ),
				'rahad_modified_date' => mysql2date( 'Y-m-d H:i:s', $rahad_post->post_modified, false ),
			);
		}

		return rest_ensure_response( $rahad_output );
	}

	/**
	 * Import template into local library.
	 *
	 * @param WP_REST_Request $rahad_request REST request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function rahad_import_template( WP_REST_Request $rahad_request ) {
		$rahad_nonce = (string) $rahad_request->get_header( 'x_wp_nonce' );
		if ( ! wp_verify_nonce( $rahad_nonce, 'wp_rest' ) ) {
			return new WP_Error( 'rahad_invalid_nonce', __( 'Invalid nonce.', 'rah-power-addons' ), array( 'status' => 403 ) );
		}

		$rahad_title         = sanitize_text_field( (string) $rahad_request->get_param( 'rahad_title' ) );
		$rahad_content       = wp_kses_post( (string) $rahad_request->get_param( 'rahad_content' ) );
		$rahad_template_type = sanitize_key( (string) $rahad_request->get_param( 'rahad_template_type' ) );
		$rahad_elementor_data = $rahad_request->get_param( 'rahad_elementor_data' );

		if ( empty( $rahad_title ) ) {
			$rahad_title = __( 'Imported Template', 'rah-power-addons' );
		}

		if ( ! in_array( $rahad_template_type, array( 'header', 'footer', 'section' ), true ) ) {
			$rahad_template_type = 'section';
		}

		$rahad_template_id = wp_insert_post(
			array(
				'post_type'    => 'rahad_template',
				'post_title'   => $rahad_title,
				'post_content' => $rahad_content,
				'post_status'  => 'draft',
			)
		);

		if ( is_wp_error( $rahad_template_id ) ) {
			return $rahad_template_id;
		}

		update_post_meta( $rahad_template_id, 'rahad_template_type', $rahad_template_type );

		if ( ! empty( $rahad_elementor_data ) ) {
			if ( is_array( $rahad_elementor_data ) ) {
				$rahad_elementor_data = wp_json_encode( $rahad_elementor_data );
			}
			update_post_meta( $rahad_template_id, '_elementor_data', wp_slash( (string) $rahad_elementor_data ) );
			update_post_meta( $rahad_template_id, '_elementor_edit_mode', 'builder' );
		}

		return rest_ensure_response(
			array(
				'rahad_success'     => true,
				'rahad_template_id' => (int) $rahad_template_id,
				'rahad_edit_url'    => get_edit_post_link( $rahad_template_id, 'raw' ),
			)
		);
	}

	/**
	 * Delete template by ID.
	 *
	 * @param WP_REST_Request $rahad_request REST request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function rahad_delete_template( WP_REST_Request $rahad_request ) {
		$rahad_nonce = (string) $rahad_request->get_header( 'x_wp_nonce' );
		if ( ! wp_verify_nonce( $rahad_nonce, 'wp_rest' ) ) {
			return new WP_Error( 'rahad_invalid_nonce', __( 'Invalid nonce.', 'rah-power-addons' ), array( 'status' => 403 ) );
		}

		$rahad_template_id = absint( $rahad_request->get_param( 'id' ) );
		if ( ! $rahad_template_id || 'rahad_template' !== get_post_type( $rahad_template_id ) ) {
			return new WP_Error( 'rahad_invalid_template', __( 'Invalid template ID.', 'rah-power-addons' ), array( 'status' => 400 ) );
		}

		wp_trash_post( $rahad_template_id );

		return rest_ensure_response(
			array(
				'rahad_success' => true,
			)
		);
	}
}
