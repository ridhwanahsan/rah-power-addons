<?php
/**
 * Magical Card widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;

/**
 * Magical Card widget class.
 */
class rahad_Widget_Magical_Card extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'rahad_magical_card';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Rah Magical Card', 'rah-power-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image-box';
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
		return array( 'card', 'image', 'grid', 'box', 'magical' );
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
			'rahad_mg_img_section',
			array(
				'label' => __( 'Card Image', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_mg_card_img_show',
			array(
				'label'     => __( 'Show Image?', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'rah-power-addons' ),
				'label_off' => __( 'No', 'rah-power-addons' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'rahad_mg_card_img',
			array(
				'label'   => __( 'Choose Image', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'rahad_mg_card_img_show' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail',
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
					'rahad_mg_card_img_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'rahad_mg_img_position',
			array(
				'label'     => __( 'Image position', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'  => array(
						'title' => __( 'Left', 'rah-power-addons' ),
						'icon'  => 'eicon-arrow-left',
					),
					'top'   => array(
						'title' => __( 'Top', 'rah-power-addons' ),
						'icon'  => 'eicon-arrow-up',
					),
					'right' => array(
						'title' => __( 'Right', 'rah-power-addons' ),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'default'        => 'top',
				'toggle'         => false,
				'prefix_class'   => 'rahad-mg-card-img-',
				'style_transfer' => true,
				'condition'      => array(
					'rahad_mg_card_img_show' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mg_card_content',
			array(
				'label' => __( 'Card Content', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_mg_card_title',
			array(
				'label'       => __( 'Title', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __( 'Enter Card Title', 'rah-power-addons' ),
				'default'     => __( 'Card Title', 'rah-power-addons' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'rahad_mg_card_title_tag',
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
			'rahad_mg_card_desc',
			array(
				'label'       => __( 'Description', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'input_type'  => 'text',
				'placeholder' => __( 'Card description goes here.', 'rah-power-addons' ),
				'default'     => __( 'Dummy text you can edit or remove it. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempo.', 'rah-power-addons' ),
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_text_align',
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
				'toggle'    => false,
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-text' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mg_card_badge',
			array(
				'label' => __( 'Badge', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_card_badge_use',
			array(
				'label'     => __( 'Use Card Badge?', 'rah-power-addons' ),
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
					'rahad_card_badge_use' => 'yes',
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
				'toggle'    => false,
				'default'   => 'right-bottom',
				'condition' => array(
					'rahad_card_badge_use' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mg_card_button',
			array(
				'label' => __( 'Button', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_mg_card_btn_use',
			array(
				'label'     => __( 'Use Card Button?', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'rah-power-addons' ),
				'label_off' => __( 'No', 'rah-power-addons' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'rahad_mg_card_btn_title',
			array(
				'label'       => __( 'Button Title', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __( 'Button Text', 'rah-power-addons' ),
				'default'     => __( 'Read More', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_mg_card_btn_link',
			array(
				'label'       => __( 'Button Link', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'rah-power-addons' ),
				'default'     => array(
					'url' => '#',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'rahad_mg_card_usebtn_icon',
			array(
				'label'     => __( 'Use icon', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'rah-power-addons' ),
				'label_off' => __( 'No', 'rah-power-addons' ),
				'default'   => 'no',
			)
		);

		$this->add_control(
			'rahad_mg_card_btn_selected_icon',
			array(
				'label'      => __( 'Choose Icon', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::ICONS,
				'default'    => array(
					'value'   => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				),
				'condition'  => array(
					'rahad_mg_card_usebtn_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mg_cardbtn_icon_position',
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
				'toggle'    => false,
				'default'   => 'right',
				'condition' => array(
					'rahad_mg_card_usebtn_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mg_cardbtn_iconspace',
			array(
				'label'      => __( 'Icon Spacing', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'condition'  => array(
					'rahad_mg_card_usebtn_icon' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card .rahad-mg-card-btn i.left'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-card .rahad-mg-card-btn .left i'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-card .rahad-mg-card-btn svg.left' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-card .rahad-mg-card-btn .left svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-card .rahad-mg-card-btn i.right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-card .rahad-mg-card-btn .right i'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-card .rahad-mg-card-btn svg.right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-card .rahad-mg-card-btn .right svg' => 'margin-left: {{SIZE}}{{UNIT}};',
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
			'rahad_mg_card_basic_style',
			array(
				'label' => __( 'Basic style', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_content_padding',
			array(
				'label'      => __( 'Content Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_content_margin',
			array(
				'label'      => __( 'Content Margin', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_content_bg_color',
			array(
				'label'     => __( 'Card Background color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_content_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'rahad_mg_card_content_border',
				'selector' => '{{WRAPPER}} .rahad-mg-card',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'rahad_mg_card_content_shadow',
				'selector' => '{{WRAPPER}}.elementor-widget-rahad_magical_card',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mg_card_img_style',
			array(
				'label'     => __( 'Image style', 'rah-power-addons' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'rahad_mg_card_img_show' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_image_width_set',
			array(
				'label'      => __( 'Width', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
				),
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.rahad-mg-card-img-right .rahad-mg-card-text, {{WRAPPER}}.rahad-mg-card-img-left .rahad-mg-card-text' => 'flex: 0 0 calc(100% - {{SIZE}}{{UNIT}}); max-width: calc(100% - {{SIZE}}{{UNIT}});',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_img_auto_height',
			array(
				'label'     => __( 'Image auto height', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'On', 'rah-power-addons' ),
				'label_off' => __( 'Off', 'rah-power-addons' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'rahad_mg_card_img_height',
			array(
				'label'      => __( 'Image Height', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'condition'  => array(
					'rahad_mg_card_img_auto_height!' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-img figure img' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_imgbg_height',
			array(
				'label'      => __( 'Image div Height', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'condition'  => array(
					'rahad_mg_card_img_auto_height!' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-img' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_img_padding',
			array(
				'label'      => __( 'Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-img figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_img_margin',
			array(
				'label'      => __( 'Margin', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_img_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_imgbg_color',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-img' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'rahad_mg_card_img_border',
				'selector' => '{{WRAPPER}} .rahad-mg-card-img figure img',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mg_card_card_details_style',
			array(
				'label' => __( 'Card Title', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_title_padding',
			array(
				'label'      => __( 'Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_title_margin',
			array(
				'label'      => __( 'Margin', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_title_color',
			array(
				'label'     => __( 'Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_title_bgcolor',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-title' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_mg_card_title_typography',
				'selector' => '{{WRAPPER}} .rahad-mg-card-title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mgtm_card_description_style',
			array(
				'label' => __( 'Description', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_description_padding',
			array(
				'label'      => __( 'Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mg_card_description_margin',
			array(
				'label'      => __( 'Margin', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mg_card_description_color',
			array(
				'label'     => __( 'Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-text p' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_mg_card_description_typography',
				'selector' => '{{WRAPPER}} .rahad-mg-card-text p',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mgbtn_badge_style',
			array(
				'label'     => __( 'Badge', 'rah-power-addons' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'rahad_card_badge_use' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mgcard_badge_margin',
			array(
				'label'      => __( 'Margin', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} span.rahad-mgc-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_mgcard_badge_padding',
			array(
				'label'      => __( 'Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} span.rahad-mgc-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_mgcard_badge_color',
			array(
				'label'     => __( 'Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} span.rahad-mgc-badge' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rahad_mgcard_badge_bgcolor',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} span.rahad-mgc-badge' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_mgcard_badge_typography',
				'selector' => '{{WRAPPER}} span.rahad-mgc-badge',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'rahad_mgcard_badge_border',
				'selector' => '{{WRAPPER}} span.rahad-mgc-badge',
			)
		);

		$this->add_control(
			'rahad_mgcard_badge_bradius',
			array(
				'label'      => __( 'Border Radius', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} span.rahad-mgc-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_mgbtn_card_style',
			array(
				'label' => __( 'Button', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'rahad_mgcard_btn_padding',
			array(
				'label'      => __( 'Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_mgcard_btn_typography',
				'selector' => '{{WRAPPER}} .rahad-mg-card-btn',
			)
		);

		$this->add_responsive_control(
			'rahad_mgcard_btn_icon_size',
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
					'{{WRAPPER}} .rahad-mg-card-text .rahad-mg-btn.rahad-mg-card-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rahad-mg-card-text .rahad-mg-btn.rahad-mg-card-btn svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'rahad_mgcard_btn_border',
				'selector' => '{{WRAPPER}} .rahad-mg-card-btn',
			)
		);

		$this->add_control(
			'rahad_mgcard_btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-card-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'rahad_mgcard_btn_box_shadow',
				'selector' => '{{WRAPPER}} .rahad-mg-card-btn',
			)
		);

		$this->add_control(
			'rahad_mgcard_button_color',
			array(
				'label'     => __( 'Button color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'rahad_mgcard_btn_tabs' );

		$this->start_controls_tab(
			'rahad_mgcard_btn_normal_style',
			array(
				'label' => __( 'Normal', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_mgcard_btn_color',
			array(
				'label'     => __( 'Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-btn'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .rahad-mg-card-btn i'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .rahad-mg-card-btn svg'    => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rahad_mgcard_btn_bg_color',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'rahad_mgcard_btn_hover_style',
			array(
				'label' => __( 'Hover', 'rah-power-addons' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'rahad_mgcard_btnhover_boxshadow',
				'selector' => '{{WRAPPER}} .rahad-mg-card-btn:hover',
			)
		);

		$this->add_control(
			'rahad_mgcard_btn_hcolor',
			array(
				'label'     => __( 'Text Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-btn:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rahad-mg-card-btn:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rahad-mg-card-btn:hover svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rahad_mgcard_btn_hbg_color',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-card-btn:hover' => 'background-color: {{VALUE}};',
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

		$rahad_mg_card_title     = $settings['rahad_mg_card_title'];
		$rahad_mg_card_title_tag = $settings['rahad_mg_card_title_tag'];
		$rahad_mg_card_img       = $settings['rahad_mg_card_img'];
		$rahad_mg_card_desc      = $settings['rahad_mg_card_desc'];

		$this->add_inline_editing_attributes( 'rahad_mg_card_title', 'basic' );
		$this->add_render_attribute( 'rahad_mg_card_title', 'class', 'rahad-mg-card-title' );

		$this->add_inline_editing_attributes( 'rahad_mg_card_desc', 'basic' );
		$this->add_render_attribute( 'rahad_mg_card_desc', 'class', 'rahad-mg-card-desc' );
		?>
		<div class="rahad-mg-card">
			<?php if ( $settings['rahad_mg_card_img_show'] && ( $rahad_mg_card_img['url'] || $rahad_mg_card_img['id'] ) ) : ?>
				<div class="rahad-mg-card-img">
					<figure>
						<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'rahad_mg_card_img' ); ?>
					</figure>
					<?php if ( $settings['rahad_card_badge_use'] ) : ?>
						<span class="rahad-mgc-badge rahad-mgcb-<?php echo esc_attr( $settings['rahad_badge_position'] ); ?>"><?php echo esc_html( $settings['rahad_badge_text'] ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="rahad-mg-card-text">
				<?php if ( $rahad_mg_card_title ) : ?>
					<<?php echo esc_attr( $rahad_mg_card_title_tag ); ?> <?php echo $this->get_render_attribute_string( 'rahad_mg_card_title' ); ?>><?php echo esc_html( $rahad_mg_card_title ); ?></<?php echo esc_attr( $rahad_mg_card_title_tag ); ?>>
				<?php endif; ?>

				<?php if ( $rahad_mg_card_desc ) : ?>
					<p <?php echo $this->get_render_attribute_string( 'rahad_mg_card_desc' ); ?>><?php echo wp_kses_post( $rahad_mg_card_desc ); ?></p>
				<?php endif; ?>

				<?php if ( $settings['rahad_mg_card_btn_use'] ) : ?>
					<?php
					$btn_title  = ! empty( $settings['rahad_mg_card_btn_title'] ) ? $settings['rahad_mg_card_btn_title'] : '';
					$btn_link   = ! empty( $settings['rahad_mg_card_btn_link']['url'] ) ? $settings['rahad_mg_card_btn_link']['url'] : '#';
					$btn_target = ! empty( $settings['rahad_mg_card_btn_link']['is_external'] ) ? ' target="_blank"' : '';
					$btn_nofollow = ! empty( $settings['rahad_mg_card_btn_link']['nofollow'] ) ? ' rel="nofollow"' : '';

					if ( $settings['rahad_mg_card_usebtn_icon'] === 'yes' ) :
						$icon_position = $settings['rahad_mg_cardbtn_icon_position'];
						?>
						<a class="rahad-mg-btn rahad-mg-card-btn" href="<?php echo esc_url( $btn_link ); ?>"<?php echo $btn_target; ?><?php echo $btn_nofollow; ?>>
							<?php if ( $icon_position === 'left' ) : ?>
								<span class="left">
									<?php \Elementor\Icons_Manager::render_icon( $settings['rahad_mg_card_btn_selected_icon'], array( 'aria-hidden' => 'true' ) ); ?>
								</span>
							<?php endif; ?>
							<span><?php echo esc_html( $btn_title ); ?></span>
							<?php if ( $icon_position === 'right' ) : ?>
								<span class="right">
									<?php \Elementor\Icons_Manager::render_icon( $settings['rahad_mg_card_btn_selected_icon'], array( 'aria-hidden' => 'true' ) ); ?>
								</span>
							<?php endif; ?>
						</a>
						<?php
					else :
						?>
						<a class="rahad-mg-btn rahad-mg-card-btn" href="<?php echo esc_url( $btn_link ); ?>"<?php echo $btn_target; ?><?php echo $btn_nofollow; ?>><?php echo esc_html( $btn_title ); ?></a>
						<?php
					endif;
					?>
				<?php endif; ?>
			</div>
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
			var iconHTML = elementor.helpers.renderIcon( view, settings.rahad_mg_card_btn_selected_icon, { 'aria-hidden' : true }, 'i' , 'object' );
			view.addInlineEditingAttributes( 'rahad_mg_card_title', 'basic' );
			view.addRenderAttribute( 'rahad_mg_card_title' , 'class' , 'rahad-mg-card-title' );
			view.addInlineEditingAttributes( 'rahad_mg_card_desc', 'basic' );
			view.addRenderAttribute( 'rahad_mg_card_desc' , 'class' , 'rahad-mg-card-desc' );

			if ( settings.rahad_mg_card_img.url || settings.rahad_mg_card_img.id ) {
				var image = {
					id: settings.rahad_mg_card_img.id,
					url: settings.rahad_mg_card_img.url,
					size: settings.thumbnail_size,
					dimension: settings.thumbnail_custom_dimension,
					model: view.getEditModel()
				};
				var image_url = elementor.imagesManager.getImageUrl( image );
			}
		#>

		<div class="rahad-mg-card">
			<# if ( settings.rahad_mg_card_img_show && ( settings.rahad_mg_card_img.url || settings.rahad_mg_card_img.id) ) { #>
				<div class="rahad-mg-card-img">
					<figure>
						<img alt="Card Image" src="{{ image_url }}">
					</figure>
					<# if(settings.rahad_card_badge_use ){ #>
						<span class="rahad-mgc-badge rahad-mgcb-{{{ settings.rahad_badge_position }}}">{{{ settings.rahad_badge_text }}}</span>
					<# } #>
				</div>
			<# } #>

			<div class="rahad-mg-card-text">
				<# if (settings.rahad_mg_card_title) { #>
					<{{ settings.rahad_mg_card_title_tag }} {{{ view.getRenderAttributeString( 'rahad_mg_card_title' ) }}}>{{{ settings.rahad_mg_card_title }}}</{{ settings.rahad_mg_card_title_tag }}>
				<# } #>

				<# if (settings.rahad_mg_card_desc) { #>
					<p {{{ view.getRenderAttributeString( 'rahad_mg_card_desc' ) }}}>{{{ settings.rahad_mg_card_desc }}}</p>
				<# } #>

				<# if (settings.rahad_mg_card_btn_use) { #>
					<# if (settings.rahad_mg_card_usebtn_icon==='yes' ) { #>
						<a class="rahad-mg-btn rahad-mg-card-btn" href="{{ settings.rahad_mg_card_btn_link.url }}">
							<# if (settings.rahad_mg_cardbtn_icon_position==='left' ) { #>
								<span class="left">{{{ iconHTML.value }}}</span>
							<# } #>
							<span>{{{ settings.rahad_mg_card_btn_title }}}</span>
							<# if (settings.rahad_mg_cardbtn_icon_position==='right' ) { #>
								<span class="right">{{{ iconHTML.value }}}</span>
							<# } #>
						</a>
					<# } else { #>
						<a class="rahad-mg-btn rahad-mg-card-btn" href="{{ settings.rahad_mg_card_btn_link.url }}">{{{ settings.rahad_mg_card_btn_title }}}</a>
					<# } #>
				<# } #>
			</div>
		</div>
		<?php
	}
}
