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
	 * Elementor missing notice.
	 *
	 * @return void
	 */
	public static function rahad_elementor_missing_notice() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		?>
		<div class="notice notice-warning is-dismissible">
			<p><?php echo esc_html__( 'Rah Power Addons for Elementor requires Elementor to be installed and activated.', 'rah-power-addons' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Elementor version notice.
	 *
	 * @return void
	 */
	public static function rahad_elementor_version_notice() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		?>
		<div class="notice notice-error">
			<p><?php echo esc_html__( 'Rah Power Addons for Elementor requires a newer Elementor version.', 'rah-power-addons' ); ?></p>
		</div>
		<?php
	}

	/**
	 * PHP version notice.
	 *
	 * @return void
	 */
	public static function rahad_php_version_notice() {
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
						rahad_MIN_PHP_VERSION
					)
				);
				?>
			</p>
		</div>
		<?php
	}
}
