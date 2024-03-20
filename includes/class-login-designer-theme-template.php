<?php
/**
 * Template Functions
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Theme_Template' ) ) :

	/**
	 * Create a template to use in the theme.
	 */
	class Login_Designer_Theme_Template {

		/**
		 * Instance.
		 *
		 * @var string $instance
		 */
		private static $instance;

		/**
		 * * The array of templates that this plugin tracks.
		 *
		 * @var string $instance
		 */
		private $templates;

		/**
		 * Returns an instance of this class.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new Login_Designer_Theme_Template();
			}

			return self::$instance;
		}

		/**
		 * Initializes the plugin by setting filters and administration functions.
		 */
		private function __construct() {
			$this->templates = array();

			// Add a filter to the save post to inject out template into the page cache.
			add_filter( 'wp_insert_post_data', array( $this, 'register_project_templates' ) );

			// Add a filter to the template include to determine if the page has our template assigned and return it's path.
			add_filter( 'template_include', array( $this, 'view_project_template' ) );

			// Add a noindex meta tag.
			add_action( 'login_head', array( $this, 'noindex_meta' ), 9 );

			// Add templates.
			$this->templates = array(
				'template-login-designer.php'     => esc_html__( 'Login Designer', 'login-designer' ),
				'template-password-protected.php' => esc_html__( 'Password Protected', 'login-designer' ),
			);
		}

		/**
		 * Ensure the Login Designer page is not indexed.
		 */
		public function noindex_meta() {
			remove_action( 'login_head', 'wp_no_robots' );
			echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
		}

		/**
		 * Add template to the pages cache in order to convince WordPress
		 * into thinking the template file exists where it doens't really exist.
		 *
		 * @param string|string $atts Attributes.
		 */
		public function register_project_templates( $atts ) {

			// Create the key used for the themes cache.
			$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

			// Retrieve the cache list.
			// If it doesn't exist, or it's empty prepare an array.
			$templates = wp_get_theme()->get_page_templates();
			if ( empty( $templates ) ) {
				$templates = array();
			}

			// New cache, therefore remove the old one.
			wp_cache_delete( $cache_key, 'themes' );

			// Now add our template to the list of templates by merging our templates
			// with the existing templates array from the cache.
			$templates = array_merge( $templates, $this->templates );

			// Add the modified cache to allow WordPress to pick it up for listing available templates.
			wp_cache_add( $cache_key, $templates, 'themes', 1800 );

			return $atts;
		}

		/**
		 * Checks if the template is assigned to the page.
		 *
		 * @param string|string $template The template.
		 */
		public function view_project_template( $template ) {
			global $post;

			// Return template if post is empty.
			if ( ! $post ) {
				return $template;
			}

			// Return default template if we don't have a custom one defined.
			if ( ! isset( $this->templates[ get_post_meta( $post->ID, '_wp_page_template', true ) ] ) ) {
				return $template;
			}

			$file = plugin_dir_path( __FILE__ ) . get_post_meta(
				$post->ID,
				'_wp_page_template',
				true
			);

			// Just to be safe, we check if the file exist first.
			if ( file_exists( $file ) ) {
				return $file;
			} else {
				echo esc_url( $file );
			}

			// Return template.
			return $template;
		}
	}

endif;

add_action( 'plugins_loaded', array( 'Login_Designer_Theme_Template', 'get_instance' ) );
