<?php
/**
 * Search bar widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search bar widget class.
 */
class rahad_Widget_Search_Bar extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_search_bar';
	}

	public function get_title() {
		return __( 'Search Bar', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-search';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rahad_search_section',
			array(
				'label' => __( 'Search', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_search_placeholder',
			array(
				'label'   => __( 'Placeholder', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Search...', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_search_button_text',
			array(
				'label'   => __( 'Button Text', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Search', 'rah-power-addons' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings    = $this->get_settings_for_display();
		$rahad_placeholder = isset( $rahad_settings['rahad_search_placeholder'] ) ? $rahad_settings['rahad_search_placeholder'] : '';
		$rahad_button_text = isset( $rahad_settings['rahad_search_button_text'] ) ? $rahad_settings['rahad_search_button_text'] : '';
		?>
		<form role="search" method="get" class="rahad-search-bar-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label>
				<span class="screen-reader-text"><?php echo esc_html__( 'Search for:', 'rah-power-addons' ); ?></span>
				<input type="search" class="rahad-search-field" placeholder="<?php echo esc_attr( $rahad_placeholder ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
			</label>
			<button type="submit" class="rahad-search-submit"><?php echo esc_html( $rahad_button_text ); ?></button>
		</form>
		<?php
	}
}
