<?php
/**
 * Performance module.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tracks widget usage and performance settings.
 */
class rahad_Performance_Module {

	/**
	 * Widget manager.
	 *
	 * @var rahad_Widget_Manager
	 */
	private $rahad_widget_manager;

	/**
	 * Constructor.
	 *
	 * @param rahad_Widget_Manager $rahad_widget_manager Widget manager.
	 */
	public function __construct( $rahad_widget_manager ) {
		$this->rahad_widget_manager = $rahad_widget_manager;

		add_action( 'elementor/editor/after_save', array( $this, 'rahad_track_widget_usage' ), 10, 2 );
	}

	/**
	 * Read performance settings.
	 *
	 * @return array<string,mixed>
	 */
	public function rahad_get_performance_settings() {
		$rahad_defaults = array(
			'rahad_lazy_load_assets' => 1,
			'rahad_enable_gsap'      => 1,
			'rahad_icon_system'      => 1,
		);
		$rahad_stored   = get_option( 'rahad_performance_settings', array() );

		return wp_parse_args( $rahad_stored, $rahad_defaults );
	}

	/**
	 * Persist performance settings.
	 *
	 * @param array<string,mixed> $rahad_payload Performance payload.
	 * @return array<string,mixed>
	 */
	public function rahad_update_performance_settings( $rahad_payload ) {
		$rahad_sanitized = array(
			'rahad_lazy_load_assets' => ! empty( $rahad_payload['rahad_lazy_load_assets'] ) ? 1 : 0,
			'rahad_enable_gsap'      => ! empty( $rahad_payload['rahad_enable_gsap'] ) ? 1 : 0,
			'rahad_icon_system'      => ! empty( $rahad_payload['rahad_icon_system'] ) ? 1 : 0,
		);

		update_option( 'rahad_performance_settings', $rahad_sanitized, false );

		return $rahad_sanitized;
	}

	/**
	 * Save used widget list for post.
	 *
	 * @param int                $rahad_post_id Elementor post ID.
	 * @param array<string,mixed> $rahad_editor_data Elementor data.
	 * @return void
	 */
	public function rahad_track_widget_usage( $rahad_post_id, $rahad_editor_data ) {
		$rahad_post_id = absint( $rahad_post_id );

		if ( ! $rahad_post_id || ! current_user_can( 'edit_post', $rahad_post_id ) ) {
			return;
		}

		$rahad_available_widget_slugs = array_keys( $this->rahad_widget_manager->rahad_get_available_widgets() );
		$rahad_used_widgets           = $this->rahad_collect_widgets_from_editor_data( $rahad_editor_data, $rahad_available_widget_slugs );
		$rahad_used_widgets           = array_values( array_unique( $rahad_used_widgets ) );

		update_post_meta( $rahad_post_id, 'rahad_used_widgets', $rahad_used_widgets );

		$rahad_has_animations = $this->rahad_collect_animation_usage( $rahad_editor_data );
		update_post_meta( $rahad_post_id, 'rahad_used_animations', $rahad_has_animations ? 1 : 0 );
	}

	/**
	 * Recursively collect widget slugs.
	 *
	 * @param mixed                $rahad_elements Element set.
	 * @param array<int,string>    $rahad_available_widget_slugs Known widget names.
	 * @return array<int,string>
	 */
	private function rahad_collect_widgets_from_editor_data( $rahad_elements, $rahad_available_widget_slugs ) {
		$rahad_found = array();

		if ( ! is_array( $rahad_elements ) ) {
			return $rahad_found;
		}

		foreach ( $rahad_elements as $rahad_element ) {
			if ( ! is_array( $rahad_element ) ) {
				continue;
			}

			if ( ! empty( $rahad_element['widgetType'] ) && in_array( $rahad_element['widgetType'], $rahad_available_widget_slugs, true ) ) {
				$rahad_found[] = sanitize_key( $rahad_element['widgetType'] );
			}

			if ( ! empty( $rahad_element['elements'] ) && is_array( $rahad_element['elements'] ) ) {
				$rahad_found = array_merge(
					$rahad_found,
					$this->rahad_collect_widgets_from_editor_data( $rahad_element['elements'], $rahad_available_widget_slugs )
				);
			}
		}

		return $rahad_found;
	}

	/**
	 * Check whether animation settings are used.
	 *
	 * @param mixed $rahad_elements Element set.
	 * @return bool
	 */
	private function rahad_collect_animation_usage( $rahad_elements ) {
		if ( ! is_array( $rahad_elements ) ) {
			return false;
		}

		foreach ( $rahad_elements as $rahad_element ) {
			if ( ! is_array( $rahad_element ) ) {
				continue;
			}

			if ( ! empty( $rahad_element['settings']['rahad_animation_enable'] ) ) {
				return true;
			}

			if ( ! empty( $rahad_element['elements'] ) && $this->rahad_collect_animation_usage( $rahad_element['elements'] ) ) {
				return true;
			}
		}

		return false;
	}
}
