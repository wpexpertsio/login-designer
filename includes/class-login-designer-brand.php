<?php
/**
 * Getting started introduction guide.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Brand' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Brand {

		/**
		 * The class constructor.
		 */
		public function __construct() {

			// For the Customizer.
			add_action( 'customize_preview_init', array( $this, 'is_customize' ), 99 );
			add_action( 'customize_preview_init', array( $this, 'styles' ), 99 );
			add_action( 'login_body_class', array( $this, 'body_class' ) );

			// Return early if the option is deactived.
			if ( ! true === $this->is_active() ) {
				return;
			}

			// For the login page.
			if ( ! is_customize_preview() ) {
				add_action( 'login_enqueue_scripts', array( $this, 'styles' ), 99 );
				add_action( 'login_footer', array( $this, 'load_sprite' ), 9999 );
				add_action( 'login_footer', array( $this, 'render' ) );
			}
		}

		/**
		 * Add functionality to the Customizer.
		 */
		public function is_customize() {
			if ( ! is_customize_preview() ) {
				return;
			}

			add_action( 'wp_footer', array( $this, 'load_sprite' ), 9999 );
			add_action( 'wp_footer', array( $this, 'render' ) );
		}

		/**
		 * Add a class to the body so we know where the badge is located.
		 *
		 * @access public
		 * @param array $classes Existing body classes to be filtered.
		 */
		public function body_class( $classes ) {

			// If we're not in the Customizer, return.
			if ( ! is_customize_preview() ) {
				return $classes;
			}

			$position = $this->position();
			$position = 'login-designer-badge-' . esc_attr( $position );

			$classes[] = $position;

			return $classes;
		}

		/**
		 * Check if this is enabled.
		 *
		 * @access public
		 */
		public function is_active() {
			$admin_options = get_option( 'login_designer_settings', array() );
			$option        = array_key_exists( 'branding', $admin_options ) ? $admin_options['branding'] : false;

			if ( true === $option ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Pull the Login Designer page from options.
		 *
		 * @access public
		 */
		public function position() {
			$admin_options = get_option( 'login_designer_settings', array() );
			$option        = array_key_exists( 'branding_position', $admin_options ) ? $admin_options['branding_position'] : false;

			return $option;
		}

		/**
		 * Render the "Powered by Login Designer" badge.
		 */
		public function render() {

			// Hide the branding badge if the option was previously disabled.
			$visibility = ! true === $this->is_active() ? 'is-hidden ' : null;

			// Position the badge as determined in the Customizer.
			$position = $this->position();

			// Retrieve the Login Designer shop URL.
			$url = Login_Designer()->get_store_url(
				'/',
				array(
					'utm_medium'   => 'login-designer-lite',
					'utm_source'   => 'login-page',
					'utm_campaign' => 'branding-badge',
					'utm_content'  => 'powered-by-login-designer',
				)
			);

			// Text.
			$text = esc_html__( 'Powered by', 'login-designer' );
			$alt  = esc_attr__( 'Get Login Designer today', 'login-designer' );

			$markup = '';

			$markup .= sprintf( '<div class="login-designer-badge %1$s">', esc_attr( $visibility . $position ) );
			$markup .= '<div class="login-designer-badge__inner">';
			$markup .= sprintf( '<span class="login-designer-badge__text">%1$s</span>', esc_html( $text ) );
			$markup .= $this->get_svg( array( 'icon' => 'login-designer' ) );
			$markup .= sprintf( '<a class="login-designer-badge__link" href="%1$s" alt="%2$s" title="%2$s" target="_blank"></a>', esc_url( 'https://wordpress.org/plugins/login-designer/' ), esc_attr( $alt ) );
			$markup .= '</div>';
			$markup .= '</div>';

			// Array of allowed HTML for the badge markup.
			$allowed_html_array = array(
				'div'  => array(
					'class' => array(),
				),
				'span' => array(
					'class' => array(),
				),
				'a'    => array(
					'alt'    => array(),
					'href'   => array(),
					'target' => array(),
					'class'  => array(),
				),
				'svg'  => array(
					'class'       => array(),
					'aria-hidden' => array(),
					'role'        => array(),
				),
				'use'  => array(
					'xlink:href' => array(),
				),
			);

			echo wp_kses( $markup, $allowed_html_array );
		}

		/**
		 * Enqueue the branding badge styles.
		 *
		 * @access public
		 */
		public function styles() {
			$css = '';

			$css .= '
			.login-designer-badge {
				overflow: hidden;
				position: absolute;
				bottom: 15px;
				display: none;
				right: 15px;
				z-index: 2;
			}

			.login-designer-badge.left {
				left: 15px;
				right: inherit;
			}

			.login-designer-badge.right {
				right: 15px;
			}

			.login-designer-badge.middle {
				left: 15px;
				right: 15px;
				margin: 0 auto;
			}

			.login-designer-badge.top-right {
				top: 15px;
				right: 15px;
				bottom: inherit;
			}

			@media screen and (min-width: 600px) {
				.login-designer-badge {
					display: block;
				}
			}

			@media screen and (max-height: 600px) {
				.login-designer-badge {
					display: none;
				}
			}

			.login-designer-badge.is-hidden .login-designer-badge__inner {
				opacity: 0;
				transform: scale(0);
				transition: transform 500ms cubic-bezier(0.694, 0.0482, 0.335, 1), opacity 200ms cubic-bezier(0.694, 0.0482, 0.335, 1);
			}

			.login-designer-badge__inner {
				display: -webkit-box;
				display: -webkit-flex;
				display: -ms-flexbox;
				display: flex;
				-webkit-align-content: center;
				-ms-flex-line-pack: center;
				align-content: center;
				-webkit-box-pack: center;
				-webkit-justify-content: center;
				-ms-flex-pack: center;
				justify-content: center;
				-webkit-box-align: center;
				-webkit-align-items: center;
				-ms-flex-align: center;
				align-items: center;
				position: relative;
				padding: 8px 15px;
				transition: transform 500ms cubic-bezier(0.694, 0.0482, 0.335, 1), opacity 200ms cubic-bezier(0.694, 0.0482, 0.335, 1) 300ms;
			}

			.login-designer-badge__text {
				position: relative;
				padding-right: 7px;
				line-height: 1;
			}

			.login-designer-badge .icon {
				width: 164px;
				height: 26px;
			}

			.login-designer-badge__link {
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				height: 100%;
				width: 100%;
				z-index: 9;
			}
			';

			// Get the admin default options.
			$admin_defaults = new Login_Designer_Customizer_Output();
			$admin_defaults = $admin_defaults->admin_defaults();

			$options = get_option( 'login_designer_settings' );

			// Merge the $options and $defaults.
			$options = wp_parse_args( $options, $admin_defaults );

			if ( $options ) {
				$options = array_filter( $options );
			}

			if ( ! empty( $options ) ) :

				// Branding text color.
				if ( isset( $options['branding_color'] ) ) {
					$css .= '.login-designer-badge__text { color:' . esc_attr( $options['branding_color'] ) . ';}';
				}

				// Icon color.
				if ( isset( $options['branding_icon_color'] ) ) {
					$css .= '.login-designer-badge .icon { color:' . esc_attr( $options['branding_icon_color'] ) . ';}';
				}
			endif;

			if ( is_customize_preview() ) :
				$css .= '
				body:not(.login-designer) .login-designer-badge {
					display: none !important;
				}
				';
			endif;

			// Combine the values from above and minifiy them.
			$css = preg_replace( '#/\*.*?\*/#s', '', $css );
			$css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css );
			$css = preg_replace( '/\s\s+(.*)/', '$1', $css );

			// Add inline style.
			wp_add_inline_style( 'login', wp_strip_all_tags( $css ) );

			if ( is_customize_preview() ) {
				wp_add_inline_style( 'customize-preview', wp_strip_all_tags( $css ) );
			}
		}

		/**
		 * Add SVG definitions to the footer.
		 */
		public function load_sprite() {

			// Define the SVG sprite file.
			$sprite = esc_url( LOGIN_DESIGNER_PLUGIN_DIR . 'assets/images/login-designer.svg' );

			// If it exists, include it.
			if ( file_exists( $sprite ) ) {
				require_once $sprite;
			}
		}

		/**
		 * Return SVG markup.
		 * Based on the function from Twenty Seventeen.
		 *
		 * @param array $args {
		 *     Parameters needed to display an SVG.
		 *
		 *     @type string $icon  Required SVG icon filename.
		 *     @type string $title Optional SVG title.
		 *     @type string $desc  Optional SVG description.
		 * }
		 * @return string SVG markup.
		 */
		public function get_svg( $args = array() ) {
			// Make sure $args are an array.
			if ( empty( $args ) ) {
				return __( 'Please define default parameters in the form of an array.', 'login-designer' );
			}

			// Define an icon.
			if ( false === array_key_exists( 'icon', $args ) ) {
				return __( 'Please define an SVG icon filename.', 'login-designer' );
			}

			// Set defaults.
			$defaults = array(
				'icon'        => '',
				'title'       => '',
				'desc'        => '',
				'class'       => '',
				'aria_hidden' => true, // Hide from screen readers.
				'fallback'    => false,
			);

			// Parse args.
			$args = wp_parse_args( $args, $defaults );

			// Set aria hidden.
			$aria_hidden = '';

			if ( true === $args['aria_hidden'] ) {
				$aria_hidden = ' aria-hidden="true"';
			}

			// Set ARIA.
			$aria_labelledby = '';

			/*
			 * Login Designer doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
			 *
			 * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
			 *
			 * Example 1 with title: <?php echo logindesigner_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'login-designer' ) ) ); ?>
			 *
			 * Example 2 with title and description: <?php echo logindesigner_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'login-designer' ), 'desc' => __( 'This is the description', 'login-designer' ) ) ); ?>
			 *
			 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
			 */
			if ( $args['title'] ) {
				$aria_hidden     = '';
				$unique_id       = uniqid();
				$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

				if ( $args['desc'] ) {
					$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
				}
			}

			// Begin SVG markup.
			$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . ' ' . esc_attr( $args['class'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

			// Display the title.
			if ( $args['title'] ) {
				$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

				// Display the desc only if the title is already set.
				if ( $args['desc'] ) {
					$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
				}
			}

			/*
			 * Display the icon.
			 *
			 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
			 *
			 * See https://core.trac.wordpress.org/ticket/38387.
			 */
			$svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';

			// Add some markup to use as a fallback for browsers that do not support SVGs.
			if ( $args['fallback'] ) {
				$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
			}

			$svg .= '</svg>';

			return $svg;
		}

		/**
		 * Allowed HTML for rendered sprite SVG images.
		 */
		public function svg_allowed_html() {
			$array = array(
				'svg' => array(
					'class'       => array(),
					'aria-hidden' => array(),
					'role'        => array(),
				),
				'use' => array(
					'xlink:href' => array(),
				),
			);

			return apply_filters( 'logindesigner_svg_allowed_html', $array );
		}
	}

endif;

new Login_Designer_Brand();
