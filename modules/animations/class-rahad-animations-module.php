<?php
/**
 * Animation controls module.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds global animation controls to Elementor elements.
 */
class rahad_Animations_Module {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'elementor/element/after_section_end', array( $this, 'rahad_register_animation_controls' ), 10, 3 );
		add_action( 'elementor/frontend/element/before_render', array( $this, 'rahad_apply_animation_attributes' ) );
	}

	/**
	 * Register animation controls.
	 *
	 * @param Elementor\Element_Base $rahad_element Element.
	 * @param string                  $rahad_section_id Section ID.
	 * @return void
	 */
	public function rahad_register_animation_controls( $rahad_element, $rahad_section_id ) {
		if ( 'section_advanced' !== $rahad_section_id ) {
			return;
		}

		$rahad_element->start_controls_section(
			'rahad_animation_section',
			array(
				'label' => __( 'Rah Global Animation', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$rahad_element->add_control(
			'rahad_animation_enable',
			array(
				'label'        => __( 'Enable Animation', 'rah-power-addons' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'rah-power-addons' ),
				'label_off'    => __( 'No', 'rah-power-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$rahad_element->add_control(
			'rahad_animation_type',
			array(
				'label'     => __( 'Animation Type', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'fade_up',
				'options'   => array(
					'fade_up'    => __( 'Fade Up', 'rah-power-addons' ),
					'fade_down'  => __( 'Fade Down', 'rah-power-addons' ),
					'slide_left' => __( 'Slide Left', 'rah-power-addons' ),
					'slide_right'=> __( 'Slide Right', 'rah-power-addons' ),
					'zoom_in'    => __( 'Zoom In', 'rah-power-addons' ),
				),
				'condition' => array(
					'rahad_animation_enable' => 'yes',
				),
			)
		);

		$rahad_element->add_control(
			'rahad_animation_duration',
			array(
				'label'     => __( 'Duration (s)', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 0.8,
				'min'       => 0.1,
				'max'       => 10,
				'step'      => 0.1,
				'condition' => array(
					'rahad_animation_enable' => 'yes',
				),
			)
		);

		$rahad_element->add_control(
			'rahad_animation_delay',
			array(
				'label'     => __( 'Delay (s)', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 0,
				'min'       => 0,
				'max'       => 10,
				'step'      => 0.1,
				'condition' => array(
					'rahad_animation_enable' => 'yes',
				),
			)
		);

		$rahad_element->end_controls_section();
	}

	/**
	 * Apply animation data attributes.
	 *
	 * @param Elementor\Element_Base $rahad_element Element.
	 * @return void
	 */
	public function rahad_apply_animation_attributes( $rahad_element ) {
		$rahad_global_settings = get_option( 'rahad_animation_settings', array() );
		$rahad_global_enabled  = ! empty( $rahad_global_settings['rahad_enabled'] );

		if ( ! $rahad_global_enabled ) {
			return;
		}

		$rahad_settings = $rahad_element->get_settings_for_display();
		if ( empty( $rahad_settings['rahad_animation_enable'] ) ) {
			return;
		}

		$rahad_animation_type = isset( $rahad_settings['rahad_animation_type'] ) ? sanitize_key( $rahad_settings['rahad_animation_type'] ) : 'fade_up';
		$rahad_duration       = isset( $rahad_settings['rahad_animation_duration'] ) ? (float) $rahad_settings['rahad_animation_duration'] : 0.8;
		$rahad_delay          = isset( $rahad_settings['rahad_animation_delay'] ) ? (float) $rahad_settings['rahad_animation_delay'] : 0;
		$rahad_ease           = ! empty( $rahad_global_settings['rahad_ease'] ) ? sanitize_text_field( $rahad_global_settings['rahad_ease'] ) : 'power2.out';

		$rahad_element->add_render_attribute( '_wrapper', 'data-rahad-animation', '1' );
		$rahad_element->add_render_attribute( '_wrapper', 'data-rahad-animation-type', $rahad_animation_type );
		$rahad_element->add_render_attribute( '_wrapper', 'data-rahad-animation-duration', (string) $rahad_duration );
		$rahad_element->add_render_attribute( '_wrapper', 'data-rahad-animation-delay', (string) $rahad_delay );
		$rahad_element->add_render_attribute( '_wrapper', 'data-rahad-animation-ease', $rahad_ease );
	}
}
