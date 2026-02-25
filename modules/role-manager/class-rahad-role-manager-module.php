<?php
/**
 * Role manager module.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Controls which roles can use Elementor editor.
 */
class rahad_Role_Manager_Module {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'rahad_restrict_elementor_access' ) );
		add_filter( 'elementor/user_can_edit_post', array( $this, 'rahad_filter_user_can_edit_post' ), 10, 2 );
	}

	/**
	 * Restrict Elementor editing by role.
	 *
	 * @return void
	 */
	public function rahad_restrict_elementor_access() {
		if ( ! is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
			return;
		}

		$rahad_action = isset( $_GET['action'] ) ? sanitize_key( wp_unslash( $_GET['action'] ) ) : '';

		if ( 'elementor' !== $rahad_action ) {
			return;
		}

		if ( $this->rahad_current_user_allowed() ) {
			return;
		}

		wp_die(
			esc_html__( 'You are not allowed to use Elementor based on current Role Manager settings.', 'rah-power-addons' ),
			esc_html__( 'Access Denied', 'rah-power-addons' ),
			array( 'response' => 403 )
		);
	}

	/**
	 * Elementor capability filter.
	 *
	 * @param bool $rahad_can_edit Current decision.
	 * @return bool
	 */
	public function rahad_filter_user_can_edit_post( $rahad_can_edit ) {
		if ( ! $this->rahad_current_user_allowed() ) {
			return false;
		}

		return $rahad_can_edit;
	}

	/**
	 * Check if current role is allowed.
	 *
	 * @return bool
	 */
	private function rahad_current_user_allowed() {
		$rahad_settings = get_option( 'rahad_role_settings', array() );
		$rahad_settings = wp_parse_args(
			$rahad_settings,
			array(
				'rahad_allowed_roles' => array( 'administrator', 'editor' ),
			)
		);

		$rahad_allowed_roles = is_array( $rahad_settings['rahad_allowed_roles'] ) ? $rahad_settings['rahad_allowed_roles'] : array();
		$rahad_user          = wp_get_current_user();

		if ( ! $rahad_user || empty( $rahad_user->roles ) ) {
			return false;
		}

		foreach ( $rahad_user->roles as $rahad_role ) {
			if ( in_array( $rahad_role, $rahad_allowed_roles, true ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Sanitize role settings.
	 *
	 * @param array<string,mixed> $rahad_payload Payload.
	 * @return array<string,mixed>
	 */
	public static function rahad_sanitize_settings( $rahad_payload ) {
		$rahad_roles = wp_roles()->roles;
		$rahad_valid = array_keys( $rahad_roles );

		$rahad_allowed_roles = array();
		if ( isset( $rahad_payload['rahad_allowed_roles'] ) && is_array( $rahad_payload['rahad_allowed_roles'] ) ) {
			foreach ( $rahad_payload['rahad_allowed_roles'] as $rahad_role ) {
				$rahad_role = sanitize_key( $rahad_role );
				if ( in_array( $rahad_role, $rahad_valid, true ) ) {
					$rahad_allowed_roles[] = $rahad_role;
				}
			}
		}

		if ( empty( $rahad_allowed_roles ) ) {
			$rahad_allowed_roles = array( 'administrator' );
		}

		return array(
			'rahad_allowed_roles' => array_values( array_unique( $rahad_allowed_roles ) ),
		);
	}
}
