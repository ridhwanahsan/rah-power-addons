<?php
/**
 * Dual button widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dual button widget class.
 */
class rahad_Widget_Dual_Button extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_dual_button';
	}

	public function get_title() {
		return __( 'Dual Button', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-dual-button';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rahad_dual_button_content',
			array(
				'label' => __( 'Buttons', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_first_button_text',
			array(
				'label'   => __( 'First Button Text', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Primary', 'rah-power-addons' ),
			)
		);
		$this->add_control(
			'rahad_first_button_url',
			array(
				'label' => __( 'First Button URL', 'rah-power-addons' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$this->add_control(
			'rahad_second_button_text',
			array(
				'label'   => __( 'Second Button Text', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Secondary', 'rah-power-addons' ),
			)
		);
		$this->add_control(
			'rahad_second_button_url',
			array(
				'label' => __( 'Second Button URL', 'rah-power-addons' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings = $this->get_settings_for_display();

		$rahad_first_text = ! empty( $rahad_settings['rahad_first_button_text'] ) ? $rahad_settings['rahad_first_button_text'] : __( 'Primary', 'rah-power-addons' );
		$rahad_first_url  = ! empty( $rahad_settings['rahad_first_button_url']['url'] ) ? $rahad_settings['rahad_first_button_url']['url'] : '#';
		$rahad_second_text = ! empty( $rahad_settings['rahad_second_button_text'] ) ? $rahad_settings['rahad_second_button_text'] : __( 'Secondary', 'rah-power-addons' );
		$rahad_second_url  = ! empty( $rahad_settings['rahad_second_button_url']['url'] ) ? $rahad_settings['rahad_second_button_url']['url'] : '#';
		?>
		<div class="rahad-dual-button-widget">
			<a class="rahad-button rahad-button-primary" href="<?php echo esc_url( $rahad_first_url ); ?>"><?php echo esc_html( $rahad_first_text ); ?></a>
			<a class="rahad-button rahad-button-secondary" href="<?php echo esc_url( $rahad_second_url ); ?>"><?php echo esc_html( $rahad_second_text ); ?></a>
		</div>
		<?php
	}
}
