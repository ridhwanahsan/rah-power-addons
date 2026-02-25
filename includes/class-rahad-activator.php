<?php
/**
 * Activation/deactivation routines.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin activator.
 */
class rahad_Activator {

	/**
	 * Activate plugin.
	 *
	 * @return void
	 */
	public static function rahad_activate() {
		$rahad_widget_defaults = array(
			'rahad_banner'           => 1,
			'rahad_info_box'         => 1,
			'rahad_call_to_action'   => 1,
			'rahad_tabs'             => 1,
			'rahad_countdown'        => 1,
			'rahad_team_members'     => 1,
			'rahad_accordion'        => 1,
			'rahad_progress_bar'     => 1,
			'rahad_icon_list'        => 1,
			'rahad_pricing_table'    => 1,
			'rahad_posts_grid'       => 1,
			'rahad_search_bar'       => 1,
			'rahad_nav_menu'         => 1,
			'rahad_back_to_top'      => 1,
			'rahad_dual_button'      => 1,
			'rahad_card'             => 1,
			'rahad_image_comparison' => 1,
			'rahad_flip_box'         => 1,
		);

		add_option( 'rahad_widget_settings', $rahad_widget_defaults );
		add_option(
			'rahad_performance_settings',
			array(
				'rahad_lazy_load_assets' => 1,
				'rahad_enable_gsap'      => 1,
				'rahad_icon_system'      => 1,
			)
		);
		add_option(
			'rahad_custom_code_settings',
			array(
				'rahad_enabled' => 0,
				'rahad_css'     => '',
				'rahad_js'      => '',
			)
		);
		add_option(
			'rahad_role_settings',
			array(
				'rahad_allowed_roles' => array( 'administrator', 'editor' ),
			)
		);
		add_option(
			'rahad_header_footer_settings',
			array(
				'rahad_header_template_id' => 0,
				'rahad_footer_template_id' => 0,
			)
		);
		add_option(
			'rahad_animation_settings',
			array(
				'rahad_enabled'  => 1,
				'rahad_duration' => 0.8,
				'rahad_ease'     => 'power2.out',
			)
		);

		flush_rewrite_rules();
	}

	/**
	 * Deactivate plugin.
	 *
	 * @return void
	 */
	public static function rahad_deactivate() {
		flush_rewrite_rules();
	}
}
