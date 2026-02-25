<?php
/**
 * Pricing Table widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pricing Table widget class.
 */
class rahad_Widget_Pricing_Table extends rahad_Widget_Simple {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_slug() {
		return 'rahad_pricing_table';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_title() {
		return __( 'Pricing Table', 'rah-power-addons' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_icon() {
		return 'eicon-price-table';
	}
}
