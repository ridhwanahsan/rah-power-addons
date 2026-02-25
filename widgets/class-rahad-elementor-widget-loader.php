<?php
/**
 * Elementor widget loader.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loads and registers enabled widgets.
 */
class rahad_Elementor_Widget_Loader {

	/**
	 * Widget manager.
	 *
	 * @var rahad_Widget_Manager
	 */
	private $rahad_widget_manager;

	/**
	 * Constructor.
	 *
	 * @param rahad_Widget_Manager $rahad_widget_manager Widget manager.
	 */
	public function __construct( $rahad_widget_manager ) {
		$this->rahad_widget_manager = $rahad_widget_manager;

		add_action( 'elementor/elements/categories_registered', array( $this, 'rahad_register_widget_category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'rahad_register_widgets' ) );
	}

	/**
	 * Register Elementor category.
	 *
	 * @param Elementor\Elements_Manager $rahad_elements_manager Manager.
	 * @return void
	 */
	public function rahad_register_widget_category( $rahad_elements_manager ) {
		$rahad_elements_manager->add_category(
			'rahad_widgets',
			array(
				'title' => __( 'Rah Power Addons', 'rah-power-addons' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Register enabled widgets.
	 *
	 * @param Elementor\Widgets_Manager $rahad_widgets_manager Manager.
	 * @return void
	 */
	public function rahad_register_widgets( $rahad_widgets_manager ) {
		require_once rahad_PLUGIN_PATH . 'widgets/class-rahad-widget-simple.php';

		$rahad_available_widgets = $this->rahad_widget_manager->rahad_get_available_widgets();
		$rahad_enabled_widgets   = $this->rahad_widget_manager->rahad_get_enabled_widgets();

		foreach ( $rahad_available_widgets as $rahad_slug => $rahad_widget ) {
			if ( empty( $rahad_enabled_widgets[ $rahad_slug ] ) ) {
				continue;
			}

			if ( empty( $rahad_widget['rahad_file'] ) || empty( $rahad_widget['rahad_class'] ) ) {
				continue;
			}

			$rahad_file_path = rahad_PLUGIN_PATH . 'widgets/' . $rahad_widget['rahad_file'];
			if ( ! file_exists( $rahad_file_path ) ) {
				continue;
			}

			require_once $rahad_file_path;

			$rahad_class_name = $rahad_widget['rahad_class'];
			if ( class_exists( $rahad_class_name ) ) {
				$rahad_widgets_manager->register( new $rahad_class_name() );
			}
		}
	}
}
