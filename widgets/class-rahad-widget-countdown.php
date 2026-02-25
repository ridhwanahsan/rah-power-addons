<?php
/**
 * Countdown widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Countdown widget class.
 */
class rahad_Widget_Countdown extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_countdown';
	}

	public function get_title() {
		return __( 'Countdown', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rahad_countdown_section',
			array(
				'label' => __( 'Countdown', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_countdown_label',
			array(
				'label'   => __( 'Label', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Offer Ends In', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_countdown_target',
			array(
				'label'       => __( 'Target Date', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => gmdate( 'Y-m-d H:i:s', strtotime( '+7 days' ) ),
				'placeholder' => '2026-12-31 23:59:59',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings = $this->get_settings_for_display();
		$rahad_label    = isset( $rahad_settings['rahad_countdown_label'] ) ? $rahad_settings['rahad_countdown_label'] : '';
		$rahad_target   = isset( $rahad_settings['rahad_countdown_target'] ) ? $rahad_settings['rahad_countdown_target'] : '';
		?>
		<div class="rahad-countdown-widget">
			<?php if ( ! empty( $rahad_label ) ) : ?>
				<h4><?php echo esc_html( $rahad_label ); ?></h4>
			<?php endif; ?>
			<div class="rahad-countdown" data-rahad-countdown="<?php echo esc_attr( $rahad_target ); ?>">
				<span class="rahad-countdown-item"><strong data-rahad-days>00</strong> <?php echo esc_html__( 'Days', 'rah-power-addons' ); ?></span>
				<span class="rahad-countdown-item"><strong data-rahad-hours>00</strong> <?php echo esc_html__( 'Hours', 'rah-power-addons' ); ?></span>
				<span class="rahad-countdown-item"><strong data-rahad-minutes>00</strong> <?php echo esc_html__( 'Minutes', 'rah-power-addons' ); ?></span>
				<span class="rahad-countdown-item"><strong data-rahad-seconds>00</strong> <?php echo esc_html__( 'Seconds', 'rah-power-addons' ); ?></span>
			</div>
		</div>
		<?php
	}
}
