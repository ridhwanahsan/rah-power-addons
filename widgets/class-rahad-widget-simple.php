<?php
/**
 * Base simple widget abstraction.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract base class for basic content widgets.
 */
abstract class rahad_Widget_Simple extends \Elementor\Widget_Base {

	/**
	 * Get widget slug.
	 *
	 * @return string
	 */
	abstract protected function rahad_get_simple_widget_slug();

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	abstract protected function rahad_get_simple_widget_title();

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	protected function rahad_get_simple_widget_icon() {
		return 'eicon-apps';
	}

	/**
	 * Elementor widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->rahad_get_simple_widget_slug();
	}

	/**
	 * Elementor widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return $this->rahad_get_simple_widget_title();
	}

	/**
	 * Elementor widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return $this->rahad_get_simple_widget_icon();
	}

	/**
	 * Widget categories.
	 *
	 * @return array<int,string>
	 */
	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	/**
	 * Widget keywords.
	 *
	 * @return array<int,string>
	 */
	public function get_keywords() {
		return array( 'rahad', 'elementor', 'widget' );
	}

	/**
	 * Register controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'rahad_content_section',
			array(
				'label' => __( 'Content', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_title',
			array(
				'label'       => __( 'Title', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $this->get_title(),
				'placeholder' => __( 'Enter title', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_description',
			array(
				'label'       => __( 'Description', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => __( 'This is a customizable widget from Rah Power Addons.', 'rah-power-addons' ),
				'placeholder' => __( 'Enter description', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_button_text',
			array(
				'label'   => __( 'Button Text', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Learn More', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_button_url',
			array(
				'label'       => __( 'Button Link', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'default'     => array(
					'url' => '',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 *
	 * @return void
	 */
	protected function render() {
		$rahad_settings = $this->get_settings_for_display();

		$rahad_title       = ! empty( $rahad_settings['rahad_title'] ) ? $rahad_settings['rahad_title'] : '';
		$rahad_description = ! empty( $rahad_settings['rahad_description'] ) ? $rahad_settings['rahad_description'] : '';
		$rahad_button_text = ! empty( $rahad_settings['rahad_button_text'] ) ? $rahad_settings['rahad_button_text'] : '';
		$rahad_button_url  = ! empty( $rahad_settings['rahad_button_url']['url'] ) ? $rahad_settings['rahad_button_url']['url'] : '';
		$rahad_button_external = ! empty( $rahad_settings['rahad_button_url']['is_external'] );
		$rahad_button_nofollow = ! empty( $rahad_settings['rahad_button_url']['nofollow'] );
		?>
		<div class="rahad-simple-widget rahad-widget-<?php echo esc_attr( $this->get_name() ); ?>">
			<?php if ( ! empty( $rahad_title ) ) : ?>
				<h3 class="rahad-widget-title"><?php echo esc_html( $rahad_title ); ?></h3>
			<?php endif; ?>
			<?php if ( ! empty( $rahad_description ) ) : ?>
				<div class="rahad-widget-description"><?php echo wp_kses_post( wpautop( $rahad_description ) ); ?></div>
			<?php endif; ?>
			<?php if ( ! empty( $rahad_button_text ) ) : ?>
				<p>
					<a
						class="rahad-widget-button"
						href="<?php echo esc_url( $rahad_button_url ? $rahad_button_url : '#' ); ?>"
						<?php echo $rahad_button_external ? ' target="_blank"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo $rahad_button_nofollow ? ' rel="nofollow"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					>
						<?php echo esc_html( $rahad_button_text ); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}
}
