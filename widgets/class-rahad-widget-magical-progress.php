<?php
/**
 * Magical Progress Bar widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Magical Progress Bar widget class.
 */
class rahad_Widget_Magical_Progress extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'rahad_magical_progress';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Rah Magical Progress Bar', 'rah-power-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-skill-bar';
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
		return array( 'progress', 'progressbar', 'bar', 'skill', 'magical' );
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
			'rahad_mg_progressbar',
			array(
				'label' => __( 'Magical Progress Bar', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_mgp_title_use',
			array(
				'label'   => __( 'Use Title', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'rahad_mgp_title',
			array(
				'label'     => __( 'Title', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => array(
					'rahad_mgp_title_use' => 'yes',
				),
				'default' => __( 'My Skill', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_mgp_parcent',
			array(
				'label'      => __( 'Percentage', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 80,
				),
			)
		);

		$this->add_control(
			'rahad_mgp_parcent_show',
			array(
				'label'   => __( 'Show percentage', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'rahad_mgp_animation_time',
			array(
				'label'      => __( 'Animation time', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'ms' ),
				'range'      => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'default'    => array(
					'unit' => 'ms',
					'size' => 1500,
				),
			)
		);

		$this->add_control(
			'rahad_mgp_bganimation_show',
			array(
				'label'   => __( 'Show background Animation', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'rahad_mgp_bar_color_type',
			array(
				'label'   => __( 'Bar Color Type', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'default' => __( 'Default (Green)', 'rah-power-addons' ),
					'orange'  => __( 'Orange', 'rah-power-addons' ),
					'red'     => __( 'Red', 'rah-power-addons' ),
					'custom'  => __( 'Custom', 'rah-power-addons' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'rahad_mgp_bar_color',
			array(
				'label'     => __( 'Custom Bar Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'rahad_mgp_bar_color_type' => 'custom',
				),
				'selectors' => array(
					'{{WRAPPER}} .rahad-progress-line' => 'background-color: {{VALUE}};',
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
			'rahad_progress_bgstyle',
			array(
				'label' => __( 'Progress Bar Background style', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'rahad_pbar_bgcolor',
			array(
				'label'     => __( 'Background Color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .rahad-progress-container' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'rahad_pbar_padding',
			array(
				'label'      => __( 'Padding', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-mg-progress' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_pbar_radius',
			array(
				'label'      => __( 'Border Radius', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-progress-container, {{WRAPPER}} .rahad-progress-line' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_progress_style',
			array(
				'label' => __( 'Progress Bar style', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'rahad_bar_height',
			array(
				'label'      => __( 'Height', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .rahad-progress-container' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rahad_progress_text_style',
			array(
				'label' => __( 'Text style', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'rahad_progress_title_heading',
			array(
				'type'  => \Elementor\Controls_Manager::HEADING,
				'label' => __( 'Title Style', 'rah-power-addons' ),
			)
		);

		$this->add_responsive_control(
			'rahad_title_margin',
			array(
				'label'      => __( 'Title Margin', 'rah-power-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} span.rahad-mgp-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rahad_title_color',
			array(
				'label'     => __( 'Title color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#222',
				'selectors' => array(
					'{{WRAPPER}} span.rahad-mgp-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_title_typography',
				'selector' => '{{WRAPPER}} .rahad-mgp-title',
			)
		);

		$this->add_control(
			'rahad_progress_percentage_heading',
			array(
				'type'  => \Elementor\Controls_Manager::HEADING,
				'label' => __( 'Percentage Style', 'rah-power-addons' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'rahad_text_color',
			array(
				'label'     => __( 'Percentage Text color', 'rah-power-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#222',
				'selectors' => array(
					'{{WRAPPER}} .rahad-mg-progress .rahad-mgp-percent' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rahad_text_typography',
				'selector' => '{{WRAPPER}} .rahad-mg-progress .rahad-mgp-percent',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$title_use       = $this->get_settings( 'rahad_mgp_title_use' );
		$title           = $this->get_settings( 'rahad_mgp_title' );
		$parcent_show    = $this->get_settings( 'rahad_mgp_parcent_show' );
		$parcent         = $this->get_settings( 'rahad_mgp_parcent' );
		$animation_time  = $this->get_settings( 'rahad_mgp_animation_time' );
		$bganimation_show = $this->get_settings( 'rahad_mgp_bganimation_show' );
		$bar_color_type  = $this->get_settings( 'rahad_mgp_bar_color_type' );

		$this->add_inline_editing_attributes( 'rahad_mgp_title' );
		$this->add_render_attribute( 'rahad_mgp_title', 'class', 'rahad-mgp-title' );

		$animation_class = 'animate';
		if ( $bganimation_show != 'yes' ) {
			$animation_class .= ' rahad-bganimate-hide';
		}

		$color_class = '';
		if ( $bar_color_type === 'orange' ) {
			$color_class = 'rahad-orange';
		} elseif ( $bar_color_type === 'red' ) {
			$color_class = 'rahad-red';
		}

		$speed = ! empty( $animation_time['size'] ) ? $animation_time['size'] : 1500;
		?>

		<div class="rahad-mg-progress <?php echo esc_attr( $animation_class ); ?> <?php echo esc_attr( $color_class ); ?>" data-percent="<?php echo esc_attr( $parcent['size'] . '%' ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>">
			<div class="rahad-mgp-top-text">
				<?php if ( $title_use == 'yes' ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'rahad_mgp_title' ); ?>><?php echo esc_html( $title ); ?></span>
				<?php endif; ?>
				<?php if ( $parcent_show ) : ?>
					<div class="rahad-mgp-percent"><?php echo esc_html( '0%' ); ?></div>
				<?php endif; ?>
			</div>
			<div class="rahad-progress-container">
				<span class="rahad-progress-background">
					<span class="rahad-progress-line"></span>
				</span>
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
			var settings = settings;
			var title_use = settings.rahad_mgp_title_use;
			var title = settings.rahad_mgp_title;
			var parcent_show = settings.rahad_mgp_parcent_show;
			var parcent = settings.rahad_mgp_parcent;
			var bganimation_show = settings.rahad_mgp_bganimation_show;
			var bar_color_type = settings.rahad_mgp_bar_color_type;

			view.addInlineEditingAttributes('rahad_mgp_title');
			view.addRenderAttribute('rahad_mgp_title', 'class', 'rahad-mgp-title');

			var animation_class = 'animate';
			if (bganimation_show !== 'yes') {
				animation_class += ' rahad-bganimate-hide';
			}

			var color_class = '';
			if (bar_color_type === 'orange') {
				color_class = 'rahad-orange';
			} else if (bar_color_type === 'red') {
				color_class = 'rahad-red';
			}

			var speed = settings.rahad_mgp_animation_size || 1500;
		#>

		<div class="rahad-mg-progress {{ animation_class }} {{ color_class }}" data-percent="{{ parcent.size }}%" data-speed="{{ speed }}">
			<div class="rahad-mgp-top-text">
				<# if (title_use === 'yes') { #>
					<span {{{ view.getRenderAttributeString( 'rahad_mgp_title' ) }}}>{{{ title }}}</span>
				<# } #>
				<# if (parcent_show) { #>
					<div class="rahad-mgp-percent">0%</div>
				<# } #>
			</div>
			<div class="rahad-progress-container">
				<span class="rahad-progress-background">
					<span class="rahad-progress-line"></span>
				</span>
			</div>
		</div>
		<?php
	}
}
