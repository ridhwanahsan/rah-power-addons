<?php
/**
 * Custom code manager module.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs global custom CSS and JS.
 */
class rahad_Custom_Code_Module {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'rahad_output_custom_code' ), 95 );
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'rahad_output_custom_code' ), 95 );
	}

	/**
	 * Output inline CSS/JS if enabled.
	 *
	 * @return void
	 */
	public function rahad_output_custom_code() {
		$rahad_settings = get_option( 'rahad_custom_code_settings', array() );
		$rahad_settings = wp_parse_args(
			$rahad_settings,
			array(
				'rahad_enabled' => 0,
				'rahad_css'     => '',
				'rahad_js'      => '',
			)
		);

		if ( empty( $rahad_settings['rahad_enabled'] ) ) {
			return;
		}

		if ( ! empty( $rahad_settings['rahad_css'] ) ) {
			wp_enqueue_style( 'rahad_frontend' );
			wp_add_inline_style( 'rahad_frontend', $rahad_settings['rahad_css'] );
		}

		if ( ! empty( $rahad_settings['rahad_js'] ) ) {
			wp_enqueue_script( 'rahad_frontend' );
			wp_add_inline_script( 'rahad_frontend', $rahad_settings['rahad_js'], 'after' );
		}
	}

	/**
	 * Sanitize custom code settings.
	 *
	 * @param array<string,mixed> $rahad_payload Request payload.
	 * @return array<string,mixed>
	 */
	public static function rahad_sanitize_settings( $rahad_payload ) {
		$rahad_css = isset( $rahad_payload['rahad_css'] ) ? (string) $rahad_payload['rahad_css'] : '';
		$rahad_js  = isset( $rahad_payload['rahad_js'] ) ? (string) $rahad_payload['rahad_js'] : '';

		$rahad_css = preg_replace( '/<\/?style[^>]*>/i', '', $rahad_css );
		$rahad_js  = preg_replace( '/<\/?script[^>]*>/i', '', $rahad_js );
		$rahad_js  = str_replace( '<?php', '', $rahad_js );
		$rahad_css = str_replace( '<?php', '', $rahad_css );

		return array(
			'rahad_enabled' => ! empty( $rahad_payload['rahad_enabled'] ) ? 1 : 0,
			'rahad_css'     => trim( wp_unslash( $rahad_css ) ),
			'rahad_js'      => trim( wp_unslash( $rahad_js ) ),
		);
	}
}
