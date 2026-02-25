<?php
/**
 * Accordion widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Accordion widget class.
 */
class rahad_Widget_Accordion extends rahad_Widget_Simple {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_slug() {
		return 'rahad_accordion';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_title() {
		return __( 'Accordion', 'rah-power-addons' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_icon() {
		return 'eicon-accordion';
	}
}
