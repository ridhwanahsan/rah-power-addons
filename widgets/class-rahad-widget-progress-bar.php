<?php
/**
 * Progress bar widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Progress bar widget class.
 */
class rahad_Widget_Progress_Bar extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_progress_bar';
	}

	public function get_title() {
		return __( 'Progress Bar', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rahad_progress_bar_content',
			array(
				'label' => __( 'Progress', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_progress_title',
			array(
				'label'   => __( 'Title', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Skill Progress', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_progress_percent',
			array(
				'label'   => __( 'Percentage', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 75,
				'min'     => 0,
				'max'     => 100,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings = $this->get_settings_for_display();
		$rahad_title    = isset( $rahad_settings['rahad_progress_title'] ) ? $rahad_settings['rahad_progress_title'] : '';
		$rahad_percent  = isset( $rahad_settings['rahad_progress_percent'] ) ? absint( $rahad_settings['rahad_progress_percent'] ) : 0;
		if ( $rahad_percent > 100 ) {
			$rahad_percent = 100;
		}
		?>
		<div class="rahad-progress-widget">
			<div class="rahad-progress-header">
				<span><?php echo esc_html( $rahad_title ); ?></span>
				<span><?php echo esc_html( $rahad_percent ); ?>%</span>
			</div>
			<div class="rahad-progress-track">
				<div class="rahad-progress-fill" style="width: <?php echo esc_attr( $rahad_percent ); ?>%;"></div>
			</div>
		</div>
		<?php
	}
}
