<?php
/**
 * Card widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Card widget class.
 */
class rahad_Widget_Card extends rahad_Widget_Simple {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_slug() {
		return 'rahad_card';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_title() {
		return __( 'Card', 'rah-power-addons' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_icon() {
		return 'eicon-post';
	}
}
