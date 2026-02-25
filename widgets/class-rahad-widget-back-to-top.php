<?php
/**
 * Back to top widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Back to top widget class.
 */
class rahad_Widget_Back_To_Top extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_back_to_top';
	}

	public function get_title() {
		return __( 'Back To Top', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-arrow-up';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rahad_back_to_top_content',
			array(
				'label' => __( 'Button', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_back_to_top_text',
			array(
				'label'   => __( 'Text', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Back to Top', 'rah-power-addons' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings = $this->get_settings_for_display();
		$rahad_text     = isset( $rahad_settings['rahad_back_to_top_text'] ) ? $rahad_settings['rahad_back_to_top_text'] : __( 'Back to Top', 'rah-power-addons' );
		?>
		<div class="rahad-back-to-top-widget">
			<button type="button" class="rahad-back-to-top-button" data-rahad-back-to-top="1">
				<span class="rahad-back-to-top-icon" aria-hidden="true">&#8593;</span>
				<span><?php echo esc_html( $rahad_text ); ?></span>
			</button>
		</div>
		<?php
	}
}
