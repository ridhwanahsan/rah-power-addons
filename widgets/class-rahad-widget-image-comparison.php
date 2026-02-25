<?php
/**
 * Image comparison widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Image comparison widget class.
 */
class rahad_Widget_Image_Comparison extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_image_comparison';
	}

	public function get_title() {
		return __( 'Image Comparison', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-image-before-after';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rahad_image_comparison_content',
			array(
				'label' => __( 'Images', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_before_image',
			array(
				'label'   => __( 'Before Image', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
			)
		);
		$this->add_control(
			'rahad_after_image',
			array(
				'label'   => __( 'After Image', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
			)
		);
		$this->add_control(
			'rahad_slider_position',
			array(
				'label'   => __( 'Initial Position', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'   => array( '%' => array( 'min' => 0, 'max' => 100 ) ),
				'default' => array( 'size' => 50, 'unit' => '%' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings = $this->get_settings_for_display();
		$rahad_before   = ! empty( $rahad_settings['rahad_before_image']['url'] ) ? $rahad_settings['rahad_before_image']['url'] : '';
		$rahad_after    = ! empty( $rahad_settings['rahad_after_image']['url'] ) ? $rahad_settings['rahad_after_image']['url'] : '';
		$rahad_position = ! empty( $rahad_settings['rahad_slider_position']['size'] ) ? (int) $rahad_settings['rahad_slider_position']['size'] : 50;

		if ( $rahad_position < 0 ) {
			$rahad_position = 0;
		}
		if ( $rahad_position > 100 ) {
			$rahad_position = 100;
		}
		?>
		<div class="rahad-image-comparison-widget" data-rahad-comparison="1">
			<div class="rahad-image-comparison-inner">
				<?php if ( ! empty( $rahad_after ) ) : ?>
					<img src="<?php echo esc_url( $rahad_after ); ?>" alt="<?php echo esc_attr__( 'After', 'rah-power-addons' ); ?>" class="rahad-comparison-after" />
				<?php endif; ?>
				<?php if ( ! empty( $rahad_before ) ) : ?>
					<div class="rahad-comparison-before-wrap" style="width: <?php echo esc_attr( $rahad_position ); ?>%;">
						<img src="<?php echo esc_url( $rahad_before ); ?>" alt="<?php echo esc_attr__( 'Before', 'rah-power-addons' ); ?>" class="rahad-comparison-before" />
					</div>
				<?php endif; ?>
				<input type="range" min="0" max="100" value="<?php echo esc_attr( $rahad_position ); ?>" class="rahad-comparison-range" aria-label="<?php echo esc_attr__( 'Image comparison slider', 'rah-power-addons' ); ?>" />
			</div>
		</div>
		<?php
	}
}
