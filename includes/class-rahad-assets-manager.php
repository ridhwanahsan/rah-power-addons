<?php
/**
 * Asset manager.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers and enqueues frontend assets.
 */
class rahad_Assets_Manager {

	/**
	 * Widget manager.
	 *
	 * @var rahad_Widget_Manager
	 */
	private $rahad_widget_manager;

	/**
	 * Performance module.
	 *
	 * @var rahad_Performance_Module
	 */
	private $rahad_performance_module;

	/**
	 * Constructor.
	 *
	 * @param rahad_Widget_Manager    $rahad_widget_manager Widget manager.
	 * @param rahad_Performance_Module $rahad_performance_module Performance module.
	 */
	public function __construct( $rahad_widget_manager, $rahad_performance_module ) {
		$this->rahad_widget_manager    = $rahad_widget_manager;
		$this->rahad_performance_module = $rahad_performance_module;

		// Only load on frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'rahad_register_frontend_assets' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'rahad_enqueue_frontend_assets' ), 20 );
		
		// Only load in Elementor editor (not admin)
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'rahad_enqueue_preview_assets' ) );
	}

	/**
	 * Register all frontend assets.
	 *
	 * @return void
	 */
	public function rahad_register_frontend_assets() {
		// Main frontend styles
		wp_register_style( 'rahad_frontend', rahad_PLUGIN_URL . 'assets/css/frontend.css', array(), rahad_PLUGIN_VERSION );
		
		// Magical widgets CSS (separate files for each widget)
		wp_register_style( 'rahad_card', rahad_PLUGIN_URL . 'assets/css/rahad-card.css', array(), rahad_PLUGIN_VERSION );
		wp_register_style( 'rahad_infobox', rahad_PLUGIN_URL . 'assets/css/rahad-infobox.css', array(), rahad_PLUGIN_VERSION );
		wp_register_style( 'rahad_progressbar', rahad_PLUGIN_URL . 'assets/css/rahad-progressbar.css', array(), rahad_PLUGIN_VERSION );
		
		// Icon system
		wp_register_style( 'rahad_icon_system', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2' );
		
		// Scripts
		wp_register_script( 'rahad_frontend', rahad_PLUGIN_URL . 'assets/js/frontend.js', array(), rahad_PLUGIN_VERSION, true );
		wp_register_script( 'rahad_gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js', array(), '3.12.7', true );
	}

	/**
	 * Enqueue frontend assets only when needed.
	 *
	 * @return void
	 */
	public function rahad_enqueue_frontend_assets() {
		$rahad_custom_code = get_option( 'rahad_custom_code_settings', array() );
		$rahad_has_custom_code = ! empty( $rahad_custom_code['rahad_enabled'] ) && ( ! empty( $rahad_custom_code['rahad_css'] ) || ! empty( $rahad_custom_code['rahad_js'] ) );

		if ( ! is_singular() && ! $rahad_has_custom_code ) {
			return;
		}

		$rahad_should_enqueue = $rahad_has_custom_code;
		$rahad_used_widgets   = array();
		$rahad_post_id        = absint( get_queried_object_id() );

		if ( $rahad_post_id ) {
			$rahad_used_widgets = get_post_meta( $rahad_post_id, 'rahad_used_widgets', true );
			if ( ! is_array( $rahad_used_widgets ) ) {
				$rahad_used_widgets = array();
			}

			$rahad_is_elementor_post = ! empty( get_post_meta( $rahad_post_id, '_elementor_edit_mode', true ) );
			$rahad_performance       = $this->rahad_performance_module->rahad_get_performance_settings();
			$rahad_lazy_load_assets  = ! empty( $rahad_performance['rahad_lazy_load_assets'] );

			if ( $rahad_is_elementor_post ) {
				if ( $rahad_lazy_load_assets ) {
					if ( ! empty( $rahad_used_widgets ) ) {
						$rahad_should_enqueue = true;
					} else {
						$rahad_elementor_data = (string) get_post_meta( $rahad_post_id, '_elementor_data', true );
						if ( false !== strpos( $rahad_elementor_data, 'rahad_' ) ) {
							$rahad_should_enqueue = true;
						}
					}
				} else {
					$rahad_should_enqueue = true;
				}
			}
		}

		if ( ! $rahad_should_enqueue ) {
			return;
		}

		$rahad_performance = $this->rahad_performance_module->rahad_get_performance_settings();

		wp_enqueue_style( 'rahad_frontend' );
		wp_enqueue_script( 'rahad_frontend' );

		// Enqueue magical widget styles based on used widgets
		if ( ! empty( $rahad_used_widgets ) ) {
			if ( in_array( 'rahad_magical_card', $rahad_used_widgets ) ) {
				wp_enqueue_style( 'rahad_card' );
			}
			if ( in_array( 'rahad_magical_infobox', $rahad_used_widgets ) ) {
				wp_enqueue_style( 'rahad_infobox' );
			}
			if ( in_array( 'rahad_magical_progress', $rahad_used_widgets ) ) {
				wp_enqueue_style( 'rahad_progressbar' );
			}
		}

		if ( ! empty( $rahad_performance['rahad_icon_system'] ) ) {
			wp_enqueue_style( 'rahad_icon_system' );
		}

		if ( ! empty( $rahad_performance['rahad_enable_gsap'] ) && $rahad_post_id && get_post_meta( $rahad_post_id, 'rahad_used_animations', true ) ) {
			wp_enqueue_script( 'rahad_gsap' );
		}

		wp_localize_script(
			'rahad_frontend',
			'rahadFrontendData',
			array(
				'rahad_is_logged_in' => is_user_logged_in(),
				'rahad_gsap_url'     => 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js',
				'rahad_performance'  => $rahad_performance,
				'rahad_used_widgets' => $rahad_used_widgets,
			)
		);
	}

	/**
	 * Enqueue assets in Elementor preview.
	 * Load all widget CSS for proper editor rendering.
	 *
	 * @return void
	 */
	public function rahad_enqueue_preview_assets() {
		$this->rahad_register_frontend_assets();
		
		// Load frontend base styles
		wp_enqueue_style( 'rahad_frontend' );
		
		// Load all widget CSS in editor for proper preview
		wp_enqueue_style( 'rahad_card' );
		wp_enqueue_style( 'rahad_infobox' );
		wp_enqueue_style( 'rahad_progressbar' );
		
		wp_enqueue_script( 'rahad_frontend' );
	}
}
