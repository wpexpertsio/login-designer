<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
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

if ( ! class_exists( 'Loginly_Templates' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Loginly_Templates {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'login_enqueue_scripts', array( $this, 'template_frontend_styles' ) );
			add_action( 'customize_preview_init', array( $this, 'template_customize_styles' ) );
			add_action( 'login_body_class', array( $this, 'template_classes' ) );
			add_action( 'body_class', array( $this, 'template_classes' ) );
		}

		/**
		 * Adds the associated template to the body.
		 *
		 * @access public
		 * @param array $classes Existing body classes to be filtered.
		 */
		public function template_classes( $classes ) {
			$template = 'loginly-template-' . get_theme_mod( 'loginly__template-selector', 'default' );
			$classes[] = $template;

			if ( is_customize_preview() ) {
				$classes[] = 'is-customize-preview';
			}

			return $classes;
		}

		/**
		 * Enqueue the template stylesheets.
		 *
		 * @access public
		 */
		public function template_frontend_styles() {

			// Get the template Customizer option.
			$template 	= get_theme_mod( 'loginly__template-selector', 'default' );

			// We don't need to add a stylesheet if the default option is set.
			if ( 'default' === $template ) {
				return;
			}

			// Set the stylesheet handle from the template.
			$handle 	= 'loginly-template-' . $template;

			// Define where the control's scripts are.
			$css_dir 	= LOGINLY_PLUGIN_URL . 'assets/css/templates/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix 	= ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			// Custom control styles.
			wp_enqueue_style( $handle, $css_dir . $handle . $suffix . '.css', LOGINLY_VERSION, 'all' );
		}

		/**
		 * Enqueue the template stylesheets.
		 *
		 * @access public
		 */
		public function template_customize_styles() {

			// Don't display the stylesheets if we're in the Customizer.
			if ( ! is_customize_preview() ) {
				return;
			}

			// Define where the control's scripts are.
			$css_dir 	= LOGINLY_PLUGIN_URL . 'assets/css/templates/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix 	= ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			// Let's pull each option from the template selector in the Customizer.
			$customizer 	= new Loginly_Customizer();

			// And output each associated stylesheet to the Customizer window.
			foreach ( $customizer->get_templates() as $option => $value ) :

				// Set the stylesheet handle from the template.
				$handle = 'loginly-template-' . $option;

				// Custom control styles.
				wp_enqueue_style( $handle, $css_dir . $handle . $suffix . '.css', LOGINLY_VERSION, 'all' );

			endforeach;

			// Remove the default option. There's not one.
			wp_dequeue_style( 'loginly-template-default' );
		}
	}

endif;

new Loginly_Templates();
