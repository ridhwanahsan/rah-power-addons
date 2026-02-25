<?php
/**
 * Magical Info Box widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;

/**
 * Magical Info Box widget class.
 */
class rahad_Widget_Magical_Info_Box extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'rahad_magical_infobox';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Rah Magical Info Box', 'rah-power-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'info', 'services', 'box', 'icon', 'magical' );
	}

	/**
	 * Register widget controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Register content controls.
	 *
	 * @return void
	 */
	function register_content_controls() {

		$this->start_controls_section(
			'rahad_mginfo_icon_section',
			array(
				'label' => __( 'Icon or Image', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_mginfo_use_icon',
			array(
				'label'     => __( 'Show Icon or image?', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'rah-power-addons' ),
				'label_off' => __( 'No', 'rah-power-addons' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'rahad_mginfo_main_icon_position',
			array(
				'label'     => __( 'Icon position', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'top'         => __( 'Top', 'rah-power-addons' ),
					'title-left'  => __( 'Title Left', 'rah-power-addons' ),
					'title-right' => __( 'Title Right', 'rah-power-addons' ),
					'left'        => __( 'Left', 'rah-power-addons' ),
					'right'       => __( 'Right', 'rah-power-addons' ),
				),
				'default'   => 'top',
				'toggle'    => false,
				'condition' => array(
					'rahad_mginfo_use_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_icon_alignment',
			array(
				'label'     => __( 'Icon Alignment', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'rah-power-addons' ),
						'icon'  => 'fas fa-long-arrow-alt-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'rah-power-addons' ),
						'icon'  => 'fas fa-arrows-alt',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'rah-power-addons' ),
						'icon'  => 'fas fa-long-arrow-alt-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'condition' => array(
					'rahad_mginfo_main_icon_position' => 'top',
				),
				'selectors' => array(
					'{{WRAPPER}} .rahad-mgicon-area' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_icon_type',
			array(
				'label'     => __( 'Icon Type', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'icon'  => array(
						'title' => __( 'Icon', 'rah-power-addons' ),
						'icon'  => 'fas fa-info',
					),
					'image' => array(
						'title' => __( 'Image', 'rah-power-addons' ),
						'icon'  => 'far fa-image',
					),
				),
				'default'   => 'icon',
				'toggle'    => true,
				'condition' => array(
					'rahad_mginfo_use_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_type_selected_icon',
			array(
				'label'      => __( 'Choose Icon', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'    => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'condition'  => array(
					'rahad_mginfo_icon_type'   => 'icon',
					'rahad_mginfo_use_icon'    => 'yes',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_type_image',
			array(
				'label'   => __( 'Choose Image', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'rahad_mginfo_icon_type' => 'image',
					'rahad_mginfo_use_icon'  => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'rahad_mginfo_thumbnail',
				'default'   => 'medium_large',
				'separator' => 'none',
				'exclude'  => array(
					'full',
					'custom',
					'large',
					'shop_catalog',
					'shop_single',
					'shop_thumbnail',
				),
				'condition' => array(
					'rahad_mginfo_icon_type' => 'image',
					'rahad_mginfo_use_icon'  => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mginfo_text_section',
			array(
				'label' => __( 'Title and description', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_mginfo_title',
			array(
				'label'       => __( 'Title', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __( 'Magical info box title', 'rah-power-addons' ),
				'default'     => __( 'Magical info box title', 'rah-power-addons' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'rahad_mginfo_title_tag',
			array(
				'label'   => __( 'Title HTML Tag', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default' => 'h2',
			)
		);

		$this->add_control(
			'rahad_mginfo_desc',
			array(
				'label'       => __( 'Description', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'input_type'  => 'text',
				'placeholder' => __( 'Magical info box description goes here.', 'rah-power-addons' ),
				'default'     => __( 'Magical info box description goes here.', 'rah-power-addons' ),
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_title_align',
			array(
				'label'   => __( 'Alignment', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => __( 'Left', 'rah-power-addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'rah-power-addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'rah-power-addons' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mg_info_badge',
			array(
				'label' => __( 'Badge', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_info_badge_use',
			array(
				'label'     => __( 'Use Badge?', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'rah-power-addons' ),
				'label_off' => __( 'No', 'rah-power-addons' ),
				'default'   => '',
			)
		);

		$this->add_control(
			'rahad_badge_text',
			array(
				'label'       => __( 'Badge Text', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __( 'Badge Text', 'rah-power-addons' ),
				'default'     => __( 'Badge', 'rah-power-addons' ),
				'condition'   => array(
					'rahad_info_badge_use' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_badge_position',
			array(
				'label'     => __( 'Badge Position', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left-top'     => array(
						'title' => __( 'Left Top', 'rah-power-addons' ),
						'icon'  => 'fas fa-arrow-up',
					),
					'left-bottom'  => array(
						'title' => __( 'Left Bottom', 'rah-power-addons' ),
						'icon'  => 'fas fa-arrow-down',
					),
					'right-top'    => array(
						'title' => __( 'Right Top', 'rah-power-addons' ),
						'icon'  => 'fas fa-arrow-up',
					),
					'right-bottom' => array(
						'title' => __( 'Right Bottom', 'rah-power-addons' ),
						'icon'  => 'fas fa-arrow-right',
					),
				),
				'default'   => 'right-top',
				'toggle'    => false,
				'condition' => array(
					'rahad_info_badge_use' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mginfo_button_section',
			array(
				'label' => __( 'Button', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_mginfo_use_btn',
			array(
				'label'     => __( 'Use button', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'rah-power-addons' ),
				'label_off' => __( 'No', 'rah-power-addons' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'rahad_mginfo_btntitle',
			array(
				'label'       => __( 'Button Title', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __( 'Button Text', 'rah-power-addons' ),
				'default'     => __( 'Read More', 'rah-power-addons' ),
				'condition'   => array(
					'rahad_mginfo_use_btn' => 'yes',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_btn_link',
			array(
				'label'       => __( 'Button Link', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'rah-power-addons' ),
				'default'     => array(
					'url' => '#',
				),
				'separator' => 'before',
				'condition' => array(
					'rahad_mginfo_use_btn' => 'yes',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_usebtn_icon',
			array(
				'label'     => __( 'Use icon', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'rah-power-addons' ),
				'label_off' => __( 'No', 'rah-power-addons' ),
				'default'   => 'no',
			)
		);

		$this->add_control(
			'rahad_mginfo_btn_selected_icon',
			array(
				'label'      => __( 'Choose Icon', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::ICONS,
				'default'    => array(
					'value'   => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				),
				'condition'  => array(
					'rahad_mginfo_usebtn_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_icon_position',
			array(
				'label'     => __( 'Button Icon Position', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'  => array(
						'title' => __( 'Left', 'rah-power-addons' ),
						'icon'  => 'fas fa-arrow-left',
					),
					'right' => array(
						'title' => __( 'Right', 'rah-power-addons' ),
						'icon'  => 'fas fa-arrow-right',
					),
				),
				'default'   => 'right',
				'toggle'    => false,
				'condition' => array(
					'rahad_mginfo_usebtn_icon' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register style controls.
	 *
	 * @return void
	 */
	protected function register_style_controls() {

		$this->start_controls_section(
			'rahad_mginfo_box_style',
			array(
				'label' => __( 'Box Basic Style', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_min_height',
			array(
				'label'      => __( 'Box Minimum Height', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infobox' => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_box_padding',
			array(
				'label'      => __( 'Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infobox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'rahad_mginfo_box_border',
				'selector' => '{{WRAPPER}} .rahad-mg-infobox',
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infobox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'rahad_mginfo_box_block_shadow',
				'selector' => '{{WRAPPER}} .rahad-mg-infobox',
			)
		);

		$this->add_control(
			'rahad_mginfo_box_bg_color',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-infobox' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mginfo_icon_style',
			array(
				'label'     => __( 'Icon Or Image', 'rah-power-addons' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'rahad_mginfo_use_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_icon_size',
			array(
				'label'      => __( 'Icon Size', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 300,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infobox-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-infobox-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'rahad_mginfo_icon_type' => 'icon',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_icon_spacing',
			array(
				'label'      => __( 'Bottom Spacing', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infobox-icon' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_icon_color',
			array(
				'label'     => __( 'Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-infobox-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rahad-mg-infobox-icon svg' => 'fill: {{VALUE}}',
				),
				'condition' => array(
					'rahad_mginfo_icon_type' => 'icon',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mginfo_content_style',
			array(
				'label' => __( 'Title and description', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_content_padding',
			array(
				'label'      => __( 'Content padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infobox-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_title_spacing',
			array(
				'label'      => __( 'Bottom Spacing', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infobox-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_title_color',
			array(
				'label'     => __( 'Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-infobox-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_mginfo_title_typography',
				'selector' => '{{WRAPPER}} .rahad-mg-infobox-title',
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_description_spacing',
			array(
				'label'      => __( 'Description Bottom Spacing', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infobox-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_description_color',
			array(
				'label'     => __( 'Description Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} p.rahad-mg-infobox-desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_mginfo_description_typography',
				'selector' => '{{WRAPPER}} p.rahad-mg-infobox-desc',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mginfo_btn_style_section',
			array(
				'label' => __( 'Button', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'rahad_mginfo_btn_padding',
			array(
				'label'      => __( 'Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infolink' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_mginfo_btn_typography',
				'selector' => '{{WRAPPER}} .rahad-mg-infolink',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'rahad_mginfo_btn_border',
				'selector' => '{{WRAPPER}} .rahad-mg-infolink',
			)
		);

		$this->add_control(
			'rahad_mginfo_btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-infolink' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'rahad_infobox_btn_tabs' );

		$this->start_controls_tab(
			'rahad_mginfo_btn_normal_style',
			array(
				'label' => __( 'Normal', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_mginfo_btn_color',
			array(
				'label'     => __( 'Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-infolink'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .rahad-mg-infolink i'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .rahad-mg-infolink svg'    => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_btn_bg_color',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-infolink' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'rahad_mginfo_btn_hover_style',
			array(
				'label' => __( 'Hover', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_mginfo_btn_hcolor',
			array(
				'label'     => __( 'Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-infolink:hover, {{WRAPPER}} .rahad-mg-infolink:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rahad-mg-infolink:hover i, {{WRAPPER}} .rahad-mg-infolink:focus i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rahad-mg-infolink:hover svg, {{WRAPPER}} .rahad-mg-infolink:focus svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rahad_mginfo_btn_hbg_color',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-infolink:hover, {{WRAPPER}} .rahad-mg-infolink:focus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$use_icon          = $this->get_settings( 'rahad_mginfo_use_icon' );
		$icon_type        = $this->get_settings( 'rahad_mginfo_icon_type' );
		$title            = $this->get_settings( 'rahad_mginfo_title' );
		$title_tag        = $this->get_settings( 'rahad_mginfo_title_tag' );
		$desc             = $this->get_settings( 'rahad_mginfo_desc' );
		$use_btn          = $this->get_settings( 'rahad_mginfo_use_btn' );
		$btntitle         = $this->get_settings( 'rahad_mginfo_btntitle' );
		$btn_link         = $this->get_settings( 'rahad_mginfo_btn_link' );
		$usebtn_icon      = $this->get_settings( 'rahad_mginfo_usebtn_icon' );
		$icon_position    = $this->get_settings( 'rahad_mginfo_icon_position' );
		$main_icon_position = $this->get_settings( 'rahad_mginfo_main_icon_position' );

		$this->add_inline_editing_attributes( 'rahad_mginfo_title', 'basic' );
		$this->add_render_attribute( 'rahad_mginfo_title', 'class', 'rahad-mg-infobox-title' );

		$this->add_inline_editing_attributes( 'rahad_mginfo_desc' );
		$this->add_render_attribute( 'rahad_mginfo_desc', 'class', 'rahad-mg-infobox-desc' );

		$this->add_render_attribute( 'rahad_mginfo_btntitle', 'class', 'rahad-mg-btn-text' );
		$this->add_render_attribute( 'rahad_mginfo_btntitle', 'class', 'rahad-mg-infolink' );
		$this->add_render_attribute( 'rahad_mginfo_btntitle', 'href', esc_url( $btn_link['url'] ) );

		if ( ! empty( $btn_link['is_external'] ) ) {
			$this->add_render_attribute( 'rahad_mginfo_btntitle', 'target', '_blank' );
		}
		if ( ! empty( $btn_link['nofollow'] ) ) {
			$this->set_render_attribute( 'rahad_mginfo_btntitle', 'rel', 'nofollow' );
		}
		?>

		<div class="rahad-mg-infobox rahad-mg-infobox-ps-<?php echo esc_attr( $main_icon_position ); ?>">
			<div class="rahad-mg-infobox-inner">
				<?php
				if ( $use_icon == 'yes' && ( $main_icon_position != 'title-left' && $main_icon_position != 'title-right' ) ) {
					$this->rahad_icon_output();
				}
				?>

				<div class="rahad-mg-infobox-text">
					<div class="rahad-mg-infobox-title-wrap">
						<?php
						if ( $use_icon == 'yes' && ( $main_icon_position === 'title-left' || $main_icon_position === 'title-right' ) ) {
							$this->rahad_icon_output();
						}
						if ( $title ) :
							printf(
								'<%1$s %2$s>%3$s</%1$s>',
								esc_html( $title_tag ),
								$this->get_render_attribute_string( 'rahad_mginfo_title' ),
								esc_html( $title )
							);
						endif;
						?>
					</div>
					<?php if ( $desc ) : ?>
						<p <?php $this->print_render_attribute_string( 'rahad_mginfo_desc' ); ?>><?php echo wp_kses_post( $desc ); ?></p>
					<?php endif; ?>

					<?php if ( $use_btn ) : ?>
						<?php if ( $usebtn_icon == 'yes' ) : ?>
							<a <?php echo $this->get_render_attribute_string( 'rahad_mginfo_btntitle' ); ?>>
								<?php if ( $icon_position == 'left' ) : ?>
									<?php \Elementor\Icons_Manager::render_icon( $settings['rahad_mginfo_btn_selected_icon'], array( 'class' => 'left', 'aria-hidden' => 'true' ) ); ?>
								<?php endif; ?>
								<span><?php echo esc_html( $btntitle ); ?></span>
								<?php if ( $icon_position == 'right' ) : ?>
									<?php \Elementor\Icons_Manager::render_icon( $settings['rahad_mginfo_btn_selected_icon'], array( 'class' => 'right', 'aria-hidden' => 'true' ) ); ?>
								<?php endif; ?>
							</a>
						<?php else : ?>
							<a <?php echo $this->get_render_attribute_string( 'rahad_mginfo_btntitle' ); ?>><?php echo esc_html( $btntitle ); ?></a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $settings['rahad_info_badge_use'] ) : ?>
				<span class="rahad-mgc-badge rahad-mgcb-<?php echo esc_attr( $settings['rahad_badge_position'] ); ?>"><?php echo esc_html( $settings['rahad_badge_text'] ); ?></span>
			<?php endif; ?>
		</div>

		<?php
	}

	/**
	 * Icon output helper.
	 *
	 * @return void
	 */
	public function rahad_icon_output() {
		$settings   = $this->get_settings_for_display();
		$icon_type = $this->get_settings( 'rahad_mginfo_icon_type' );
		?>
		<div class="rahad-mgicon-area">
			<?php if ( $icon_type == 'image' ) : ?>
				<figure class="rahad-mg-infobox-img">
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'rahad_mginfo_thumbnail', 'rahad_mginfo_type_image' ); ?>
				</figure>
			<?php else : ?>
				<div class="rahad-mg-infobox-icon">
					<?php \Elementor\Icons_Manager::render_icon( $settings['rahad_mginfo_type_selected_icon'], array( 'aria-hidden' => 'true' ) ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
		<#
			var settings = settings;
			var use_icon = settings.rahad_mginfo_use_icon;
			var icon_type = settings.rahad_mginfo_icon_type;
			var title = settings.rahad_mginfo_title;
			var title_tag = settings.rahad_mginfo_title_tag;
			var desc = settings.rahad_mginfo_desc;
			var use_btn = settings.rahad_mginfo_use_btn;
			var btntitle = settings.rahad_mginfo_btntitle;
			var btn_link = settings.rahad_mginfo_btn_link;
			var usebtn_icon = settings.rahad_mginfo_usebtn_icon;
			var icon_position = settings.rahad_mginfo_icon_position;
			var main_icon_position = settings.rahad_mginfo_main_icon_position;

			view.addInlineEditingAttributes('rahad_mginfo_title', 'basic');
			view.addRenderAttribute('rahad_mginfo_title', 'class', 'rahad-mg-infobox-title');

			view.addInlineEditingAttributes('rahad_mginfo_desc');
			view.addRenderAttribute('rahad_mginfo_desc', 'class', 'rahad-mg-infobox-desc');

			view.addRenderAttribute('rahad_mginfo_btntitle', 'class', 'rahad-mg-btn-text');
			view.addRenderAttribute('rahad_mginfo_btntitle', 'class', 'rahad-mg-infolink');
			view.addRenderAttribute('rahad_mginfo_btntitle', 'href', btn_link.url);

			if (btn_link.is_external) {
				view.addRenderAttribute('rahad_mginfo_btntitle', 'target', '_blank');
			}
			if (btn_link.nofollow) {
				view.addRenderAttribute('rahad_mginfo_btntitle', 'rel', 'nofollow');
			}

			var iconHTML = elementor.helpers.renderIcon(view, settings.rahad_mginfo_type_selected_icon, { 'aria-hidden': true }, 'i', 'object');
		#>

		<div class="rahad-mg-infobox rahad-mg-infobox-ps-{{ main_icon_position }}">
			<div class="rahad-mg-infobox-inner">
				<# if (use_icon === 'yes' && (main_icon_position !== 'title-left' && main_icon_position !== 'title-right')) { #>
					<div class="rahad-mgicon-area">
						<# if (icon_type === 'image') { #>
							<figure class="rahad-mg-infobox-img"><img src="{{ settings.rahad_mginfo_type_image.url }}" /></figure>
						<# } else { #>
							<div class="rahad-mg-infobox-icon">{{{ iconHTML.value }}}</div>
						<# } #>
					</div>
				<# } #>

				<div class="rahad-mg-infobox-text">
					<div class="rahad-mg-infobox-title-wrap">
						<# if (use_icon === 'yes' && (main_icon_position === 'title-left' || main_icon_position === 'title-right')) { #>
							<div class="rahad-mgicon-area">
								<# if (icon_type === 'image') { #>
									<figure class="rahad-mg-infobox-img"><img src="{{ settings.rahad_mginfo_type_image.url }}" /></figure>
								<# } else { #>
									<div class="rahad-mg-infobox-icon">{{{ iconHTML.value }}}</div>
								<# } #>
							</div>
						<# } #>
						<# if (title) { #>
							<{{{ title_tag }}} {{{ view.getRenderAttributeString( 'rahad_mginfo_title' ) }}}>{{{ title }}}</{{{ title_tag }}}>
						<# } #>
					</div>
					<# if (desc) { #>
						<p {{{ view.getRenderAttributeString( 'rahad_mginfo_desc' ) }}}>{{{ desc }}}</p>
					<# } #>
					<# if (use_btn) { #>
						<# if (usebtn_icon === 'yes') { #>
							<a {{{ view.getRenderAttributeString( 'rahad_mginfo_btntitle' ) }}}>
								<# if (icon_position === 'left') { #>
									{{{ iconHTML.value }}}
								<# } #>
								<span>{{{ btntitle }}}</span>
								<# if (icon_position === 'right') { #>
									{{{ iconHTML.value }}}
								<# } #>
							</a>
						<# } else { #>
							<a {{{ view.getRenderAttributeString( 'rahad_mginfo_btntitle' ) }}}>{{{ btntitle }}}</a>
						<# } #>
					<# } #>
				</div>
			</div>
			<# if (settings.rahad_info_badge_use) { #>
				<span class="rahad-mgc-badge rahad-mgcb-{{ settings.rahad_badge_position }}">{{{ settings.rahad_badge_text }}}</span>
			<# } #>
		</div>
		<?php
	}
}
