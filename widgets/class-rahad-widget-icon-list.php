<?php
/**
 * Icon List widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon List widget class.
 */
class rahad_Widget_Icon_List extends rahad_Widget_Simple {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_slug() {
		return 'rahad_icon_list';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_title() {
		return __( 'Icon List', 'rah-power-addons' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_icon() {
		return 'eicon-icon-box';
	}
}
