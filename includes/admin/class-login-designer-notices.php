<?php
/**
 * Admin notices.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Notices' ) ) :
	/**
	 * Login_Designer_Notices Class
	 */
	class Login_Designer_Notices {

		/**
		 * Constructor
		 */
		public function __construct() {

			// Retrieve the Login Designer page.
			$page = Login_Designer()->get_login_designer_page();

			// Add a warning notice if the user has attempted to trash the Login Designer page.
			if ( isset( $_GET['ids'] ) && intval( $_GET['ids'] ) === $page->ID ) { // phpcs:ignore  WordPress.Security.NonceVerification
				add_action( 'admin_notices', array( $this, 'double_install_admin_notice' ) );
			}
		}

		/**
		 * Renders an admin notice.
		 *
		 * @access private
		 * @param string $message The notice content.
		 * @param string $type The type of admin notice.
		 * @param string $dismissable Is this dismissable.
		 * @return void
		 */
		private static function render_admin_notice( $message, $type = 'update', $dismissable = false ) {
			if ( ! is_admin() ) {
				return;
			} elseif ( ! is_user_logged_in() ) {
				return;
			} elseif ( ! current_user_can( 'update_core' ) ) {
				return;
			}

			$dismissable = ( false === $dismissable ) ? null : ' is-dismissible';

			$allowed_html_array = array(
				'a' => array(
					'href' => array(),
				),
				'b' => array(),
			);

			echo '<div class="notice ' . esc_attr( $type . $dismissable ) . '">';
				echo '<p>' . wp_kses( $message, $allowed_html_array ) . '</p>';
				echo '<style>.updated.notice.is-dismissible {display: none;}</style>';
			echo '</div>';
		}

		/**
		 * Shows an admin notice if the Login Designer page is tossed in the bin.
		 *
		 * @return void
		 */
		public function double_install_admin_notice() {
			/* translators: 1: Name of the plugin */
			$message = __( '<b>The %s page may not be removed.</b> This page is used for login page styling within the Customizer.', 'login-designer' );

			$this->render_admin_notice( sprintf( $message, 'Login Designer' ), 'notice-warning', false );
		}
	}

endif;

return new Login_Designer_Notices();
