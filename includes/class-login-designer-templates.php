<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Templates' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Templates {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'login_body_class', array( $this, 'body_class' ) );
			add_action( 'body_class', array( $this, 'body_class' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'frontend_styles' ) );
			add_action( 'customize_preview_init', array( $this, 'customize_styles' ) );
			add_filter( 'login_designer_control_localization', array( $this, 'template_defaults' ) );

			// Add the Template 01 background.
			if ( ! is_customize_preview() ) {
				add_action( 'login_footer', array( $this, 'render_false_template_background' ) );
			}
		}

		/**
		 * Render the false template background for Template 01.
		 */
		public function render_false_template_background() {

			// Check for the option.
			$options  = new Login_Designer_Customizer_Output();
			$template = $options->option_wrapper( 'template' );

			// Return early if no template is set.
			if ( ! $template || '01' !== $template ) {
				return;
			}

			$markup = '<div id="login-designer-background"></div>';

			// Array of allowed HTML for the badge markup.
			$allowed_html_array = array(
				'div' => array(
					'id' => array(),
				),
			);

			echo wp_kses( $markup, $allowed_html_array );
		}

		/**
		 * Adds the associated template to the body on our fake login customizer page and the real login page.
		 *
		 * @access public
		 * @param array $classes Existing body classes to be filtered.
		 */
		public function body_class( $classes ) {
			global $pagenow;

			// Return if we're not on the Login Designer template.
			if ( 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_page_template( 'template-login-designer.php' ) ) {
				return $classes;
			}

			// Check for the option.
			$options = new Login_Designer_Customizer_Output();
			$option  = $options->option_wrapper( 'template' );

			// No need to ouput a class for the default template.
			if ( ! $option || 'default' !== $option ) {
				$template  = 'login-designer-template-' . esc_attr( $option );
				$classes[] = $template;
			}

			return $classes;
		}

		/**
		 * Enqueue the template stylesheets.
		 *
		 * @access public
		 */
		public function frontend_styles() {

			// Check for the option.
			$options  = new Login_Designer_Customizer_Output();
			$template = $options->option_wrapper( 'template' );

			// Return early if no template is set.
			if ( ! $template || 'default' === $template ) {
				return;
			}

			// Set the stylesheet handle from the template.
			$handle = 'login-designer-template-' . $template;

			// Define where the control's scripts are.
			$dir = Login_Designer()->asset_source( 'css', 'templates/' );

			// Custom control styles.
			wp_enqueue_style( $handle, $dir . $handle . LOGIN_DESIGNER_ASSET_SUFFIX . '.css', LOGIN_DESIGNER_VERSION, 'all' );
		}

		/**
		 * Enqueue the template stylesheets within the Customizer.
		 *
		 * @access public
		 */
		public function customize_styles() {

			// Don't display the stylesheets if we're in the Customizer.
			if ( ! is_customize_preview() ) {
				return;
			}

			// Define where the styles are.
			$dir = Login_Designer()->asset_source( 'css', 'templates/' );

			// And output each associated stylesheet to the Customizer window.
			foreach ( $this->get_templates() as $option => $value ) :

				// Set the stylesheet handle from the template.
				$handle = 'login-designer-template-' . $option;

				// Custom control styles.
				wp_enqueue_style( $handle, $dir . '/' . $handle . LOGIN_DESIGNER_ASSET_SUFFIX . '.css', LOGIN_DESIGNER_VERSION, 'all' );
			endforeach;

			// Remove the default option. There's not one.
			wp_dequeue_style( 'login-designer-template-default' );
		}

		/**
		 * Register templates.
		 */
		public function get_templates() {
			$image_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/';

			if ( Login_Designer()->has_pro() ) {
				$templates = array(
					'default' => esc_url( $image_dir ) . 'customizer/default.jpg',
					'01'      => esc_url( $image_dir ) . 'customizer/template-01.jpg',
					'02'      => esc_url( $image_dir ) . 'customizer/template-02.jpg',
					'03'      => esc_url( $image_dir ) . 'customizer/template-03.jpg',
					'04'      => esc_url( $image_dir ) . 'customizer/template-04.jpg',
				);
			} else {
				$templates = array(
					'default' => esc_url( $image_dir ) . 'customizer/default.jpg',
					'01'      => esc_url( $image_dir ) . 'customizer/template-01.jpg',
					'02'      => esc_url( $image_dir ) . 'customizer/template-02.jpg',
				);
			}

			return apply_filters( 'login_designer_templates', $templates );
		}

		/**
		 * Template defaults for the live previewer.
		 *
		 * @param  array $localize Default control localization.
		 * @return array of default fonts, plus the new typekit additions.
		 */
		public function template_defaults( $localize ) {

			// White on-the-site template.
			$template_01 = apply_filters(
				'login_designer_template_01_defaults',
				array(
					'bg_image_gallery'      => 'bg_09',
					'form_width'            => '',
					'form_side_padding'     => '40',
					'form_vertical_padding' => '26',
					'form_radius'           => '0',
					'form_shadow'           => '0',
					'form_shadow_opacity'   => '0',
					'field_bg'              => '#ffffff',
					'field_padding_top'     => '6',
					'field_padding_bottom'  => '6',
					'field_side_padding'    => '12',
					'field_border'          => '2',
					'field_radius'          => '3',
					'field_shadow'          => '0',
					'field_shadow_opacity'  => '0',
					'field_font_size'       => '24',
					'field_color'           => '#32373c',
					'label_position'        => '2',
					'label_font_size'       => '14',
					'label_color'           => '#72777c',
				)
			);

			$template_01_branding = apply_filters(
				'login_designer_template_01_branding_defaults',
				array(
					'branding_color'      => '#000000',
					'branding_icon_color' => '#000000',
					'branding_position'   => 'right',
				)
			);

			// Dark template.
			$template_02 = apply_filters(
				'login_designer_template_02_defaults',
				array(
					'bg_image_gallery'      => 'none',
					'bg_color'              => '#000000',
					'form_bg'               => '#000000',
					'form_bg_transparency'  => true,
					'form_side_padding'     => '10',
					'form_vertical_padding' => '1',
					'form_radius'           => '0',
					'form_shadow'           => '0',
					'form_shadow_opacity'   => '0',
					'field_bg'              => '#191919',
					'field_padding_top'     => '9',
					'field_padding_bottom'  => '9',
					'field_side_padding'    => '13',
					'field_margin_bottom'   => '25',
					'field_border'          => '0',
					'field_radius'          => '5',
					'field_shadow'          => '0',
					'field_shadow_opacity'  => '0',
					'field_font'            => 'Rubik',
					'field_font_size'       => '18',
					'field_color'           => '#606060',
					'username_label'        => esc_html__( 'Username', 'login-designer' ),
					'label_font'            => 'Rubik',
					'label_position'        => '5',
					'label_color'           => '#4f4f4f',
					'lost_password'         => false,
					'back_to'               => false,
					'below_color'           => '#4f4f4f',
					'below_position'        => '50',
					'remember_color'        => '#4f4f4f',
					'remember_font'         => 'Rubik',
					'remember_position'     => '9',
					'button_bg'             => '#dcdcdc',
					'button_padding_top'    => '8',
					'button_padding_bottom' => '8',
					'button_side_padding'   => '17',
					'button_border'         => '0',
					'button_radius'         => '4',
					'button_font'           => 'Rubik',
					'button_font_size'      => '14',
					'button_color'          => '#000000',
					'checkbox_bg'           => '#272727',
					'checkbox_border'       => '0',
					'checkbox_radius'       => '3',
				)
			);

			$template_02_branding = apply_filters(
				'login_designer_template_02_branding_defaults',
				array(
					'branding_color'      => '#353535',
					'branding_icon_color' => '#353535',
					'branding_position'   => 'right',
				)
			);

			// White minimal template.
			$template_03 = apply_filters(
				'login_designer_template_03_defaults',
				array(
					'bg_image_gallery'      => 'none',
					'bg_color'              => '#ffffff',
					'logo_margin_bottom'    => '0',
					'form_bg'               => '#ffffff',
					'form_bg_transparency'  => true,
					'form_side_padding'     => '10',
					'form_vertical_padding' => '1',
					'form_radius'           => '0',
					'form_shadow'           => '0',
					'form_shadow_opacity'   => '0',
					'field_bg'              => '#efefef',
					'field_padding_top'     => '9',
					'field_padding_bottom'  => '9',
					'field_side_padding'    => '13',
					'field_margin_bottom'   => '25',
					'field_border'          => '0',
					'field_radius'          => '5',
					'field_shadow'          => '0',
					'field_shadow_opacity'  => '0',
					'field_font'            => 'Rubik',
					'field_font_size'       => '18',
					'field_color'           => '#434343',
					'username_label'        => esc_html__( 'Username', 'login-designer' ),
					'label_font'            => 'Rubik',
					'label_position'        => '5',
					'label_color'           => '#8b8b8b',
					'lost_password'         => false,
					'back_to'               => false,
					'below_color'           => '#8b8b8b',
					'below_position'        => '50',
					'remember_color'        => '#8b8b8b',
					'remember_font'         => 'Rubik',
					'remember_position'     => '9',
					'button_bg'             => '#1e1e1e',
					'button_padding_bottom' => '9',
					'button_padding_top'    => '9',
					'button_side_padding'   => '17',
					'button_border'         => '0',
					'button_radius'         => '5',
					'button_font'           => 'Rubik',
					'button_font_size'      => '14',
					'button_color'          => '#fff',
					'checkbox_bg'           => '#efefef',
					'checkbox_border'       => '0',
					'checkbox_radius'       => '3',
				)
			);

			$template_03_branding = apply_filters(
				'login_designer_template_03_branding_defaults',
				array(
					'branding_color'      => '#191919',
					'branding_icon_color' => '#191919',
					'branding_position'   => 'right',
				)
			);

			// White 50/50 on-the-site template.
			$template_04 = apply_filters(
				'login_designer_template_04_defaults',
				array(
					'bg_image_gallery'      => 'bg_01',
					'bg_color'              => '#f4f5f7',
					'form_width'            => '',
					'form_side_padding'     => '40',
					'form_vertical_padding' => '20',
					'form_radius'           => '0',
					'form_shadow'           => '0',
					'form_shadow_opacity'   => '0',
					'field_bg'              => '#f4f5f7',
					'field_padding_top'     => '6',
					'field_padding_bottom'  => '6',
					'field_side_padding'    => '12',
					'field_border'          => '2',
					'field_border_color'    => '#e3e4e5',
					'field_radius'          => '3',
					'field_shadow'          => '0',
					'field_shadow_opacity'  => '0',
					'field_font'            => 'Karla',
					'field_font_size'       => '22',
					'field_color'           => '#3f473b',
					'label_position'        => '5',
					'label_font_size'       => '15',
				)
			);

			$template_04_branding = apply_filters(
				'login_designer_template_04_branding_defaults',
				array(
					'branding_color'      => '#444444',
					'branding_icon_color' => '#333333',
					'branding_position'   => 'right',
				)
			);

			$customizer = new Login_Designer_Customizer_Output();

			// Branding defaults.
			$branding_defaults = apply_filters(
				'login_designer_template_01_branding_defaults',
				array(
					'branding_color'      => '#444444',
					'branding_icon_color' => '#222222',
				)
			);

			$defaults = array(
				'template_defaults'             => $customizer->defaults(),
				'template_branding_defaults'    => $branding_defaults,
				'template_defaults_01'          => $template_01,
				'template_defaults_02'          => $template_02,
				'template_defaults_03'          => $template_03,
				'template_defaults_04'          => $template_04,
				'template_branding_defaults_01' => $template_01_branding,
				'template_branding_defaults_02' => $template_02_branding,
				'template_branding_defaults_03' => $template_03_branding,
				'template_branding_defaults_04' => $template_04_branding,
			);

			// Combine the three arrays.
			$localize = array_merge( $localize, $defaults );

			return $localize;
		}
	}

endif;

new Login_Designer_Templates();
