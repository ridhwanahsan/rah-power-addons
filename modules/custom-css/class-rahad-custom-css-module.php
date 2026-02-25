<?php
/**
 * Custom CSS module for Elementor elements.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers per-element custom CSS controls.
 */
class rahad_Custom_CSS_Module {

	/**
	 * Collected CSS rules.
	 *
	 * @var array<int,string>
	 */
	private $rahad_collected_css = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'elementor/element/after_section_end', array( $this, 'rahad_register_custom_css_controls' ), 10, 3 );
		add_action( 'elementor/frontend/element/before_render', array( $this, 'rahad_collect_custom_css' ) );
		add_action( 'wp_footer', array( $this, 'rahad_print_collected_css' ), 100 );
	}

	/**
	 * Register custom CSS controls.
	 *
	 * @param Elementor\Element_Base $rahad_element Element.
	 * @param string                  $rahad_section_id Section ID.
	 * @return void
	 */
	public function rahad_register_custom_css_controls( $rahad_element, $rahad_section_id ) {
		if ( 'section_advanced' !== $rahad_section_id ) {
			return;
		}

		$rahad_element->start_controls_section(
			'rahad_custom_css_section',
			array(
				'label' => __( 'Rah Custom CSS', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$rahad_element->add_control(
			'rahad_custom_css_code',
			array(
				'label'       => __( 'Custom CSS', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => 'selector { margin-top: 30px; }',
				'description' => __( 'Use selector to target this element.', 'rah-power-addons' ),
			)
		);

		$rahad_element->end_controls_section();
	}

	/**
	 * Collect element custom CSS.
	 *
	 * @param Elementor\Element_Base $rahad_element Element.
	 * @return void
	 */
	public function rahad_collect_custom_css( $rahad_element ) {
		$rahad_settings = $rahad_element->get_settings_for_display();
		if ( empty( $rahad_settings['rahad_custom_css_code'] ) ) {
			return;
		}

		$rahad_css_code = (string) $rahad_settings['rahad_custom_css_code'];
		$rahad_class    = 'rahad-custom-css-' . sanitize_html_class( $rahad_element->get_id() );

		$rahad_element->add_render_attribute( '_wrapper', 'class', $rahad_class );

		$rahad_css_code = str_replace( 'selector', '.' . $rahad_class, $rahad_css_code );
		$rahad_css_code = $this->rahad_sanitize_css( $rahad_css_code );

		if ( ! empty( $rahad_css_code ) ) {
			$this->rahad_collected_css[] = $rahad_css_code;
		}
	}

	/**
	 * Print combined dynamic CSS.
	 *
	 * @return void
	 */
	public function rahad_print_collected_css() {
		if ( empty( $this->rahad_collected_css ) ) {
			return;
		}

		$rahad_css = implode( "\n", $this->rahad_collected_css );
		?>
		<style id="rahad-dynamic-custom-css"><?php echo $rahad_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></style>
		<?php
	}

	/**
	 * Basic CSS sanitization.
	 *
	 * @param string $rahad_css CSS input.
	 * @return string
	 */
	private function rahad_sanitize_css( $rahad_css ) {
		$rahad_css = (string) $rahad_css;
		$rahad_css = preg_replace( '/<\/?style[^>]*>/i', '', $rahad_css );
		$rahad_css = str_replace( array( '<?php', '?>' ), '', $rahad_css );
		$rahad_css = wp_kses_no_null( $rahad_css, array( 'slash_zero' => 'keep' ) );

		return trim( $rahad_css );
	}
}
