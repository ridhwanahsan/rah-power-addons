<?php
/**
 * Admin notices.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Notice manager.
 */
class rahad_Admin_Notices {

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Always add the admin notice directly
		add_action( 'admin_notices', array( $this, 'rahad_elementor_missing_notice' ) );

		// Only check version requirements if Elementor is active
		if ( did_action( 'elementor/loaded' ) ) {
			if ( defined( 'ELEMENTOR_VERSION' ) && ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'rahad_elementor_version_notice' ) );
			}
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'rahad_php_version_notice' ) );
		}
	}

	/**
	 * Elementor missing notice.
	 *
	 * @return void
	 */
	public function rahad_elementor_missing_notice() {
		// Only show notice if Elementor is not loaded
		if ( did_action( 'elementor/loaded' ) ) {
			return;
		}

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		if ( file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' ) ) {
			$activate_url = wp_nonce_url( 'plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php' );
			$message      = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Activate link */
				esc_html__( '%1$s requires %2$s plugin, which is currently NOT RUNNING. %3$s', 'rah-power-addons' ),
				'<strong>' . esc_html__( 'Rah Power Addons for Elementor', 'rah-power-addons' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'rah-power-addons' ) . '</strong>',
				'<a class="button button-primary" style="margin-left:20px" href="' . esc_url( $activate_url ) . '">' . esc_html__( 'Activate Elementor', 'rah-power-addons' ) . '</a>'
			);
		} else {
			$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$message     = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Install link */
				esc_html__( '%1$s requires %2$s plugin, which is currently NOT RUNNING. %3$s', 'rah-power-addons' ),
				'<strong>' . esc_html__( 'Rah Power Addons for Elementor', 'rah-power-addons' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'rah-power-addons' ) . '</strong>',
				'<a class="button button-primary" style="margin-left:20px" href="' . esc_url( $install_url ) . '">' . esc_html__( 'Install Elementor', 'rah-power-addons' ) . '</a>'
			);
		}

		printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Elementor version notice.
	 *
	 * @return void
	 */
	public function rahad_elementor_version_notice() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		?>
		<div class="notice notice-error">
			<p>
				<?php
				echo sprintf(
					/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
					esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'rah-power-addons' ),
					'<strong>' . esc_html__( 'Rah Power Addons', 'rah-power-addons' ) . '</strong>',
					'<strong>' . esc_html__( 'Elementor', 'rah-power-addons' ) . '</strong>',
					self::MINIMUM_ELEMENTOR_VERSION
				);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * PHP version notice.
	 *
	 * @return void
	 */
	public function rahad_php_version_notice() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		?>
		<div class="notice notice-error">
			<p>
				<?php
				echo esc_html(
					sprintf(
						/* translators: 1: required PHP version. */
						__( 'Rah Power Addons for Elementor requires PHP version %1$s or greater.', 'rah-power-addons' ),
						self::MINIMUM_PHP_VERSION
					)
				);
				?>
			</p>
		</div>
		<?php
	}
}
