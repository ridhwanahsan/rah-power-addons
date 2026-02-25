<?php
/**
 * Widget manager.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widget management service.
 */
class rahad_Widget_Manager {

	/**
	 * Widget registry.
	 *
	 * @var array<string,array<string,mixed>>
	 */
	private $rahad_widgets = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->rahad_widgets = $this->rahad_get_widget_map();
	}

	/**
	 * Return widget registry.
	 *
	 * @return array<string,array<string,mixed>>
	 */
	public function rahad_get_available_widgets() {
		return $this->rahad_widgets;
	}

	/**
	 * Get widget settings with defaults.
	 *
	 * @return array<string,bool>
	 */
	public function rahad_get_enabled_widgets() {
		$rahad_stored_settings = get_option( 'rahad_widget_settings', array() );
		$rahad_output          = array();

		foreach ( $this->rahad_widgets as $rahad_slug => $rahad_widget ) {
			if ( isset( $rahad_stored_settings[ $rahad_slug ] ) ) {
				$rahad_output[ $rahad_slug ] = (bool) $rahad_stored_settings[ $rahad_slug ];
			} else {
				$rahad_output[ $rahad_slug ] = true;
			}
		}

		return $rahad_output;
	}

	/**
	 * Check if widget is enabled.
	 *
	 * @param string $rahad_widget_slug Widget slug.
	 * @return bool
	 */
	public function rahad_is_widget_enabled( $rahad_widget_slug ) {
		$rahad_enabled_widgets = $this->rahad_get_enabled_widgets();
		return ! empty( $rahad_enabled_widgets[ $rahad_widget_slug ] );
	}

	/**
	 * Save widget toggle settings.
	 *
	 * @param array<string,mixed> $rahad_payload Payload from REST endpoint.
	 * @return array<string,bool>
	 */
	public function rahad_save_widget_settings( $rahad_payload ) {
		$rahad_sanitized = array();

		foreach ( $this->rahad_widgets as $rahad_slug => $rahad_widget ) {
			$rahad_sanitized[ $rahad_slug ] = ! empty( $rahad_payload[ $rahad_slug ] );
		}

		update_option( 'rahad_widget_settings', $rahad_sanitized, false );

		return $rahad_sanitized;
	}

	/**
	 * Return widget config.
	 *
	 * @return array<string,array<string,mixed>>
	 */
	private function rahad_get_widget_map() {
		return array(
			'rahad_banner'           => array(
				'rahad_title' => __( 'Banner', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Banner',
				'rahad_file'  => 'class-rahad-widget-banner.php',
			),
			'rahad_info_box'         => array(
				'rahad_title' => __( 'Info Box', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Info_Box',
				'rahad_file'  => 'class-rahad-widget-info-box.php',
			),
			'rahad_call_to_action'   => array(
				'rahad_title' => __( 'Call To Action', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Call_To_Action',
				'rahad_file'  => 'class-rahad-widget-call-to-action.php',
			),
			'rahad_tabs'             => array(
				'rahad_title' => __( 'Tabs', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Tabs',
				'rahad_file'  => 'class-rahad-widget-tabs.php',
			),
			'rahad_countdown'        => array(
				'rahad_title' => __( 'Countdown', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Countdown',
				'rahad_file'  => 'class-rahad-widget-countdown.php',
			),
			'rahad_team_members'     => array(
				'rahad_title' => __( 'Team Members', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Team_Members',
				'rahad_file'  => 'class-rahad-widget-team-members.php',
			),
			'rahad_accordion'        => array(
				'rahad_title' => __( 'Accordion', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Accordion',
				'rahad_file'  => 'class-rahad-widget-accordion.php',
			),
			'rahad_progress_bar'     => array(
				'rahad_title' => __( 'Progress Bar', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Progress_Bar',
				'rahad_file'  => 'class-rahad-widget-progress-bar.php',
			),
			'rahad_icon_list'        => array(
				'rahad_title' => __( 'Icon List', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Icon_List',
				'rahad_file'  => 'class-rahad-widget-icon-list.php',
			),
			'rahad_pricing_table'    => array(
				'rahad_title' => __( 'Pricing Table', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Pricing_Table',
				'rahad_file'  => 'class-rahad-widget-pricing-table.php',
			),
			'rahad_posts_grid'       => array(
				'rahad_title' => __( 'Posts Grid', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Posts_Grid',
				'rahad_file'  => 'class-rahad-widget-posts-grid.php',
			),
			'rahad_search_bar'       => array(
				'rahad_title' => __( 'Search Bar', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Search_Bar',
				'rahad_file'  => 'class-rahad-widget-search-bar.php',
			),
			'rahad_nav_menu'         => array(
				'rahad_title' => __( 'Nav Menu', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Nav_Menu',
				'rahad_file'  => 'class-rahad-widget-nav-menu.php',
			),
			'rahad_back_to_top'      => array(
				'rahad_title' => __( 'Back To Top', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Back_To_Top',
				'rahad_file'  => 'class-rahad-widget-back-to-top.php',
			),
			'rahad_dual_button'      => array(
				'rahad_title' => __( 'Dual Button', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Dual_Button',
				'rahad_file'  => 'class-rahad-widget-dual-button.php',
			),
			'rahad_card'             => array(
				'rahad_title' => __( 'Card', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Card',
				'rahad_file'  => 'class-rahad-widget-card.php',
			),
			'rahad_image_comparison' => array(
				'rahad_title' => __( 'Image Comparison', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Image_Comparison',
				'rahad_file'  => 'class-rahad-widget-image-comparison.php',
			),
			'rahad_flip_box'         => array(
				'rahad_title' => __( 'Flip Box', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Flip_Box',
				'rahad_file'  => 'class-rahad-widget-flip-box.php',
			),
			'rahad_magical_card'     => array(
				'rahad_title' => __( 'Magical Card', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Magical_Card',
				'rahad_file'  => 'class-rahad-widget-magical-card.php',
			),
			'rahad_magical_infobox'  => array(
				'rahad_title' => __( 'Magical Info Box', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Magical_Info_Box',
				'rahad_file'  => 'class-rahad-widget-magical-info-box.php',
			),
			'rahad_magical_progress'  => array(
				'rahad_title' => __( 'Magical Progress Bar', 'rah-power-addons' ),
				'rahad_class' => 'rahad_Widget_Magical_Progress',
				'rahad_file'  => 'class-rahad-widget-magical-progress.php',
			),
		);
	}
}
