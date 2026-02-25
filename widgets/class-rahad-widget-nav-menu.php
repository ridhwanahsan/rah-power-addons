<?php
/**
 * Nav menu widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Navigation menu widget class.
 */
class rahad_Widget_Nav_Menu extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_nav_menu';
	}

	public function get_title() {
		return __( 'Nav Menu', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$rahad_menus = wp_get_nav_menus();
		$rahad_items = array();

		foreach ( $rahad_menus as $rahad_menu ) {
			$rahad_items[ (string) $rahad_menu->term_id ] = $rahad_menu->name;
		}

		$this->start_controls_section(
			'rahad_nav_menu_content',
			array(
				'label' => __( 'Menu', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_menu_id',
			array(
				'label'   => __( 'Select Menu', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $rahad_items,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings = $this->get_settings_for_display();
		$rahad_menu_id  = isset( $rahad_settings['rahad_menu_id'] ) ? absint( $rahad_settings['rahad_menu_id'] ) : 0;

		if ( ! $rahad_menu_id ) {
			echo '<p>' . esc_html__( 'Please select a menu.', 'rah-power-addons' ) . '</p>';
			return;
		}
		?>
		<nav class="rahad-nav-menu-widget" aria-label="<?php echo esc_attr__( 'Rah Navigation Menu', 'rah-power-addons' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'menu'            => $rahad_menu_id,
					'container'       => false,
					'menu_class'      => 'rahad-nav-menu-list',
					'fallback_cb'     => false,
					'depth'           => 3,
				)
			);
			?>
		</nav>
		<?php
	}
}
