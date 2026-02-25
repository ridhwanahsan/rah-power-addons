<?php
/**
 * Conditional display module.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds conditional visibility controls to Elementor elements.
 */
class rahad_Conditional_Display_Module {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'elementor/element/after_section_end', array( $this, 'rahad_register_visibility_controls' ), 10, 3 );
		add_action( 'elementor/frontend/element/before_render', array( $this, 'rahad_add_device_visibility_data' ) );

		add_filter( 'elementor/frontend/widget/should_render', array( $this, 'rahad_filter_should_render' ), 10, 2 );
		add_filter( 'elementor/frontend/section/should_render', array( $this, 'rahad_filter_should_render' ), 10, 2 );
		add_filter( 'elementor/frontend/column/should_render', array( $this, 'rahad_filter_should_render' ), 10, 2 );
		add_filter( 'elementor/frontend/container/should_render', array( $this, 'rahad_filter_should_render' ), 10, 2 );
	}

	/**
	 * Register visibility controls.
	 *
	 * @param Elementor\Element_Base $rahad_element Element instance.
	 * @param string                  $rahad_section_id Section ID.
	 * @return void
	 */
	public function rahad_register_visibility_controls( $rahad_element, $rahad_section_id ) {
		if ( 'section_advanced' !== $rahad_section_id ) {
			return;
		}

		$rahad_role_options = array();
		foreach ( wp_roles()->roles as $rahad_role_slug => $rahad_role_data ) {
			$rahad_role_options[ $rahad_role_slug ] = $rahad_role_data['name'];
		}

		$rahad_element->start_controls_section(
			'rahad_visibility_section',
			array(
				'label' => __( 'Rah Conditional Display', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$rahad_element->add_control(
			'rahad_visibility_enable',
			array(
				'label'        => __( 'Enable Conditions', 'rah-power-addons' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'rah-power-addons' ),
				'label_off'    => __( 'No', 'rah-power-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$rahad_element->add_control(
			'rahad_visibility_logged_state',
			array(
				'label'     => __( 'Login State', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'all',
				'options'   => array(
					'all'        => __( 'Show for Everyone', 'rah-power-addons' ),
					'logged_in'  => __( 'Logged In Users', 'rah-power-addons' ),
					'logged_out' => __( 'Logged Out Users', 'rah-power-addons' ),
				),
				'condition' => array(
					'rahad_visibility_enable' => 'yes',
				),
			)
		);

		$rahad_element->add_control(
			'rahad_visibility_device',
			array(
				'label'     => __( 'Device Visibility', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'all',
				'options'   => array(
					'all'     => __( 'All Devices', 'rah-power-addons' ),
					'desktop' => __( 'Desktop Only', 'rah-power-addons' ),
					'tablet'  => __( 'Tablet Only', 'rah-power-addons' ),
					'mobile'  => __( 'Mobile Only', 'rah-power-addons' ),
				),
				'condition' => array(
					'rahad_visibility_enable' => 'yes',
				),
			)
		);

		$rahad_element->add_control(
			'rahad_visibility_roles',
			array(
				'label'       => __( 'Allowed Roles', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => $rahad_role_options,
				'condition'   => array(
					'rahad_visibility_enable' => 'yes',
				),
			)
		);

		$rahad_element->end_controls_section();
	}

	/**
	 * Add device data attributes for frontend runtime checks.
	 *
	 * @param Elementor\Element_Base $rahad_element Element instance.
	 * @return void
	 */
	public function rahad_add_device_visibility_data( $rahad_element ) {
		$rahad_settings = $rahad_element->get_settings_for_display();

		if ( empty( $rahad_settings['rahad_visibility_enable'] ) ) {
			return;
		}

		if ( empty( $rahad_settings['rahad_visibility_device'] ) || 'all' === $rahad_settings['rahad_visibility_device'] ) {
			return;
		}

		$rahad_element->add_render_attribute( '_wrapper', 'data-rahad-device-rule', sanitize_key( $rahad_settings['rahad_visibility_device'] ) );
	}

	/**
	 * Determine if element should render.
	 *
	 * @param bool                  $rahad_should_render Current flag.
	 * @param Elementor\Element_Base $rahad_element Element.
	 * @return bool
	 */
	public function rahad_filter_should_render( $rahad_should_render, $rahad_element ) {
		if ( ! $rahad_should_render ) {
			return false;
		}

		$rahad_settings = $rahad_element->get_settings_for_display();

		if ( empty( $rahad_settings['rahad_visibility_enable'] ) ) {
			return true;
		}

		$rahad_logged_state = isset( $rahad_settings['rahad_visibility_logged_state'] ) ? $rahad_settings['rahad_visibility_logged_state'] : 'all';
		if ( 'logged_in' === $rahad_logged_state && ! is_user_logged_in() ) {
			return false;
		}
		if ( 'logged_out' === $rahad_logged_state && is_user_logged_in() ) {
			return false;
		}

		$rahad_roles = isset( $rahad_settings['rahad_visibility_roles'] ) && is_array( $rahad_settings['rahad_visibility_roles'] ) ? $rahad_settings['rahad_visibility_roles'] : array();
		if ( ! empty( $rahad_roles ) ) {
			if ( ! is_user_logged_in() ) {
				return false;
			}
			$rahad_user = wp_get_current_user();
			if ( empty( array_intersect( $rahad_user->roles, $rahad_roles ) ) ) {
				return false;
			}
		}

		$rahad_device_rule = isset( $rahad_settings['rahad_visibility_device'] ) ? $rahad_settings['rahad_visibility_device'] : 'all';
		if ( 'desktop' === $rahad_device_rule && wp_is_mobile() ) {
			return false;
		}
		if ( 'mobile' === $rahad_device_rule && ! wp_is_mobile() ) {
			return false;
		}

		return true;
	}
}
