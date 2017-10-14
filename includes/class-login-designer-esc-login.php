<?php
/**
 * Adds a escape key login functionality for improved logging in experience.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Esc_Login' ) ) :

	/**
	 * Login via the 'escape' key.
	 */
	class Login_Designer_Esc_Login {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'init' ) );
		}

		/**
		 * Enqueues the relevant scripts, based on the user's login status.
		 *
		 * @access public
		 */
		public function init() {
			if ( is_customize_preview() ) {
				return;
			}
			if ( is_user_logged_in() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_admin_trigger' ) );
			} else {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_login_trigger' ) );
			}
		}

		/**
		 * When the user "logs in" we send them to the appropriate login page URL, redirecting to current URL.
		 *
		 * @access public
		 */
		public function enqueue_login_trigger() {

			$url = wp_login_url( ( is_ssl() ? 'https://' : 'http://' ) ); ?>

			<script type="text/javascript">
				document['onkeyup'] = function(event){
					var e = event || window.event;
					var login_url = "<?php echo esc_js( $url ); ?>";
					if ( e.keyCode == 27 ) {
						document.location.href=login_url;
					}
				}
			</script>

		<?php
		}

		/**
		 * If the user is already logged in, send them to the dashboard.
		 *
		 * @access public
		 */
		function enqueue_admin_trigger() {

			if ( is_admin() && ! current_user_can( 'manage_users' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
				return;
			}

			$url = admin_url(); ?>

			<script type="text/javascript">
				document['onkeyup'] = function(event){
					var e = event || window.event;
					var admin_url = "<?php echo esc_js( $url ); ?>";
					if ( e.keyCode == 27 ) {
						document.location.href=admin_url;
					}
				}
			</script>

			<?php
		}
	}

endif;

new Login_Designer_Esc_Login();
