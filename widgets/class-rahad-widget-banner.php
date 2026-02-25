<?php
/**
 * Banner widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Banner widget class.
 */
class rahad_Widget_Banner extends \Elementor\Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'rahad_banner';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Banner', 'rah-power-addons' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-banner';
	}

	/**
	 * Widget category.
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
		return array( 'rahad', 'banner', 'hero' );
	}

	/**
	 * Register controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'rahad_banner_content',
			array(
				'label' => __( 'Content', 'rah-power-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'rahad_subtitle',
			array(
				'label'   => __( 'Subtitle', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Rah Power Addons', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_title',
			array(
				'label'   => __( 'Title', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Build Powerful Elementor Experiences', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_description',
			array(
				'label'   => __( 'Description', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Create modern sections using modular, lightweight widgets and advanced controls.', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_image',
			array(
				'label'   => __( 'Image', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'rahad_button_text',
			array(
				'label'   => __( 'Button Text', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Get Started', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_button_url',
			array(
				'label'       => __( 'Button URL', 'rah-power-addons' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://example.com',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render output.
	 *
	 * @return void
	 */
	protected function render() {
		$rahad_settings = $this->get_settings_for_display();

		$rahad_subtitle = isset( $rahad_settings['rahad_subtitle'] ) ? $rahad_settings['rahad_subtitle'] : '';
		$rahad_title    = isset( $rahad_settings['rahad_title'] ) ? $rahad_settings['rahad_title'] : '';
		$rahad_desc     = isset( $rahad_settings['rahad_description'] ) ? $rahad_settings['rahad_description'] : '';
		$rahad_btn_text = isset( $rahad_settings['rahad_button_text'] ) ? $rahad_settings['rahad_button_text'] : '';
		$rahad_btn_url  = ! empty( $rahad_settings['rahad_button_url']['url'] ) ? $rahad_settings['rahad_button_url']['url'] : '';
		$rahad_img_url  = ! empty( $rahad_settings['rahad_image']['url'] ) ? $rahad_settings['rahad_image']['url'] : '';

		$rahad_target_attr = ! empty( $rahad_settings['rahad_button_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
		$rahad_rel_attr    = ! empty( $rahad_settings['rahad_button_url']['nofollow'] ) ? ' rel="nofollow noopener"' : '';
		?>
		<div class="rahad-banner-widget">
			<div class="rahad-banner-content">
				<?php if ( ! empty( $rahad_subtitle ) ) : ?>
					<span class="rahad-banner-subtitle"><?php echo esc_html( $rahad_subtitle ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $rahad_title ) ) : ?>
					<h2 class="rahad-banner-title"><?php echo esc_html( $rahad_title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $rahad_desc ) ) : ?>
					<div class="rahad-banner-description"><?php echo wp_kses_post( wpautop( $rahad_desc ) ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $rahad_btn_text ) ) : ?>
					<a class="rahad-banner-button" href="<?php echo esc_url( $rahad_btn_url ? $rahad_btn_url : '#' ); ?>"<?php echo $rahad_target_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo $rahad_rel_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php echo esc_html( $rahad_btn_text ); ?>
					</a>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $rahad_img_url ) ) : ?>
				<div class="rahad-banner-image-wrap">
					<img src="<?php echo esc_url( $rahad_img_url ); ?>" alt="<?php echo esc_attr( $rahad_title ); ?>" class="rahad-banner-image" />
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
