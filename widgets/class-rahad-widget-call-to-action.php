<?php
/**
 * Call To Action widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Call To Action widget class.
 */
class rahad_Widget_Call_To_Action extends rahad_Widget_Simple {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_slug() {
		return 'rahad_call_to_action';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_title() {
		return __( 'Call To Action', 'rah-power-addons' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_icon() {
		return 'eicon-call-to-action';
	}
}
