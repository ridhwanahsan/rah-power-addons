<?php
/**
 * Header and footer builder module.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers template CPT and renders assigned header/footer templates.
 */
class rahad_Header_Footer_Module {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'rahad_register_template_post_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'rahad_add_template_metabox' ) );
		add_action( 'save_post_rahad_template', array( $this, 'rahad_save_template_metabox' ) );
		add_action( 'wp_body_open', array( $this, 'rahad_render_assigned_header' ), 5 );
		add_action( 'wp_footer', array( $this, 'rahad_render_assigned_footer' ), 5 );
	}

	/**
	 * Register template post type.
	 *
	 * @return void
	 */
	public function rahad_register_template_post_type() {
		$rahad_labels = array(
			'name'               => __( 'Rah Templates', 'rah-power-addons' ),
			'singular_name'      => __( 'Rah Template', 'rah-power-addons' ),
			'add_new'            => __( 'Add New', 'rah-power-addons' ),
			'add_new_item'       => __( 'Add New Template', 'rah-power-addons' ),
			'edit_item'          => __( 'Edit Template', 'rah-power-addons' ),
			'new_item'           => __( 'New Template', 'rah-power-addons' ),
			'view_item'          => __( 'View Template', 'rah-power-addons' ),
			'search_items'       => __( 'Search Templates', 'rah-power-addons' ),
			'not_found'          => __( 'No templates found.', 'rah-power-addons' ),
			'not_found_in_trash' => __( 'No templates found in Trash.', 'rah-power-addons' ),
		);

		register_post_type(
			'rahad_template',
			array(
				'labels'             => $rahad_labels,
				'public'             => false,
				'show_ui'            => true,
				'show_in_menu'       => false,
				'show_in_rest'       => true,
				'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions' ),
				'menu_icon'          => 'dashicons-layout',
				'capability_type'    => 'post',
				'has_archive'        => false,
				'publicly_queryable' => false,
			)
		);
	}

	/**
	 * Add metabox.
	 *
	 * @return void
	 */
	public function rahad_add_template_metabox() {
		add_meta_box(
			'rahad_template_type',
			__( 'Template Type', 'rah-power-addons' ),
			array( $this, 'rahad_render_template_metabox' ),
			'rahad_template',
			'side',
			'default'
		);
	}

	/**
	 * Render template metabox.
	 *
	 * @param WP_Post $rahad_post Current post.
	 * @return void
	 */
	public function rahad_render_template_metabox( $rahad_post ) {
		$rahad_type = get_post_meta( $rahad_post->ID, 'rahad_template_type', true );
		if ( empty( $rahad_type ) ) {
			$rahad_type = 'section';
		}

		wp_nonce_field( 'rahad_template_type_nonce_action', 'rahad_template_type_nonce' );
		?>
		<p>
			<label for="rahad_template_type_field"><?php echo esc_html__( 'Template type', 'rah-power-addons' ); ?></label>
			<select id="rahad_template_type_field" name="rahad_template_type_field" class="widefat">
				<option value="section" <?php selected( 'section', $rahad_type ); ?>><?php echo esc_html__( 'Section', 'rah-power-addons' ); ?></option>
				<option value="header" <?php selected( 'header', $rahad_type ); ?>><?php echo esc_html__( 'Header', 'rah-power-addons' ); ?></option>
				<option value="footer" <?php selected( 'footer', $rahad_type ); ?>><?php echo esc_html__( 'Footer', 'rah-power-addons' ); ?></option>
			</select>
		</p>
		<p><?php echo esc_html__( 'Assign active header/footer templates from the plugin dashboard.', 'rah-power-addons' ); ?></p>
		<?php
	}

	/**
	 * Save template metabox.
	 *
	 * @param int $rahad_post_id Post ID.
	 * @return void
	 */
	public function rahad_save_template_metabox( $rahad_post_id ) {
		if ( ! isset( $_POST['rahad_template_type_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rahad_template_type_nonce'] ) ), 'rahad_template_type_nonce_action' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $rahad_post_id ) ) {
			return;
		}

		if ( isset( $_POST['rahad_template_type_field'] ) ) {
			$rahad_type = sanitize_key( wp_unslash( $_POST['rahad_template_type_field'] ) );
			if ( ! in_array( $rahad_type, array( 'header', 'footer', 'section' ), true ) ) {
				$rahad_type = 'section';
			}
			update_post_meta( $rahad_post_id, 'rahad_template_type', $rahad_type );
		}
	}

	/**
	 * Render selected header template.
	 *
	 * @return void
	 */
	public function rahad_render_assigned_header() {
		if ( is_admin() || is_singular( 'rahad_template' ) ) {
			return;
		}

		$rahad_settings   = get_option( 'rahad_header_footer_settings', array() );
		$rahad_template_id = ! empty( $rahad_settings['rahad_header_template_id'] ) ? absint( $rahad_settings['rahad_header_template_id'] ) : 0;
		$this->rahad_render_template_content( $rahad_template_id, 'rahad-header-template' );
	}

	/**
	 * Render selected footer template.
	 *
	 * @return void
	 */
	public function rahad_render_assigned_footer() {
		if ( is_admin() || is_singular( 'rahad_template' ) ) {
			return;
		}

		$rahad_settings   = get_option( 'rahad_header_footer_settings', array() );
		$rahad_template_id = ! empty( $rahad_settings['rahad_footer_template_id'] ) ? absint( $rahad_settings['rahad_footer_template_id'] ) : 0;
		$this->rahad_render_template_content( $rahad_template_id, 'rahad-footer-template' );
	}

	/**
	 * Render template content by ID.
	 *
	 * @param int    $rahad_template_id Template ID.
	 * @param string $rahad_wrapper_class Wrapper class.
	 * @return void
	 */
	private function rahad_render_template_content( $rahad_template_id, $rahad_wrapper_class ) {
		if ( ! $rahad_template_id || 'publish' !== get_post_status( $rahad_template_id ) ) {
			return;
		}

		$rahad_content = '';

		if ( class_exists( '\Elementor\Plugin' ) ) {
			$rahad_content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $rahad_template_id, true );
		}

		if ( empty( $rahad_content ) ) {
			$rahad_content = apply_filters( 'the_content', get_post_field( 'post_content', $rahad_template_id ) );
		}

		if ( empty( $rahad_content ) ) {
			return;
		}
		?>
		<div class="<?php echo esc_attr( $rahad_wrapper_class ); ?>">
			<?php echo $rahad_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}
}
