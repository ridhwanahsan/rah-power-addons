<?php
/**
 * Flip box widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flip box widget class.
 */
class rahad_Widget_Flip_Box extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_flip_box';
	}

	public function get_title() {
		return __( 'Flip Box', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rahad_flip_box_content',
			array(
				'label' => __( 'Flip Box', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_front_title',
			array(
				'label'   => __( 'Front Title', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Front Side', 'rah-power-addons' ),
			)
		);
		$this->add_control(
			'rahad_front_desc',
			array(
				'label'   => __( 'Front Description', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Hover to see more details.', 'rah-power-addons' ),
			)
		);
		$this->add_control(
			'rahad_back_title',
			array(
				'label'   => __( 'Back Title', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Back Side', 'rah-power-addons' ),
			)
		);
		$this->add_control(
			'rahad_back_desc',
			array(
				'label'   => __( 'Back Description', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Use this area for CTA details.', 'rah-power-addons' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings = $this->get_settings_for_display();
		?>
		<div class="rahad-flip-box-widget">
			<div class="rahad-flip-box-inner">
				<div class="rahad-flip-box-front">
					<h3><?php echo esc_html( $rahad_settings['rahad_front_title'] ); ?></h3>
					<p><?php echo esc_html( $rahad_settings['rahad_front_desc'] ); ?></p>
				</div>
				<div class="rahad-flip-box-back">
					<h3><?php echo esc_html( $rahad_settings['rahad_back_title'] ); ?></h3>
					<p><?php echo esc_html( $rahad_settings['rahad_back_desc'] ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}
}
