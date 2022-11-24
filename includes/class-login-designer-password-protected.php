<?php
/**
 * Class: Login_Designer_Password_Protected
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Login_Designer_Password_Protected' ) ) {
	/**
	 * Class Login_Designer_Password_Protected
	 */
	class Login_Designer_Password_Protected {
		/**
		 * Login_Designer_Password_Protected constructor.
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'create_customizer_page' ) );
			add_action( 'password_protected_enqueue_scripts', array( $this, 'password_protected_head' ) );
			add_filter( 'password_protected_login_password_title', array( $this, 'change_password_protected_title' ) );
			add_filter( 'password_protected_login_headerurl', array( $this, 'change_password_protected_login_head_url' ) );
		}

		public function change_password_protected_login_head_url( $url ) {
			$maybe_url = password_protected_get_option( 'logo_url', $url );
			if ( is_integer( $maybe_url ) ) {
				$page_id = $maybe_url;
				$url = get_permalink( $page_id );
			}
			return esc_url( $url );
		}

		/**
		 * Changing password protected field title.
		 *
		 * @param string $title Password protected field title.
		 *
		 * @return string
		 */
		public function change_password_protected_title( $title ) {
			return password_protected_get_option( 'password_label', $title );
		}

		/**
		 * Password protected head
		 */
		public function password_protected_head() {
			$label_font             = password_protected_get_option( 'label_font' );
			$remember_font          = password_protected_get_option( 'remember_font' );
			$button_font            = password_protected_get_option( 'button_font' );
			$disable_logo           = password_protected_get_option( 'disable_logo' );
			$logo_width             = password_protected_get_option( 'logo_width' );
			$logo_height            = password_protected_get_option( 'logo_height' );
			$logo                   = password_protected_get_option( 'logo' );
			$label_font_size        = password_protected_get_option( 'label_font_size' );
			$label_position         = password_protected_get_option( 'label_position' );
			$label_color            = password_protected_get_option( 'label_color' );
			$field_background_color = password_protected_get_option( 'field_background_color', '#ffffff' );
			$field_border           = password_protected_get_option( 'field_border' );
			$field_border_color     = password_protected_get_option( 'field_border_color' );
			$field_margin_bottom    = password_protected_get_option( 'field_margin_bottom' );
			$field_side_padding     = password_protected_get_option( 'field_side_padding' );
			$field_padding_top      = password_protected_get_option( 'field_padding_top' );
			$field_padding_bottom   = password_protected_get_option( 'field_padding_bottom' );
			$field_radius           = password_protected_get_option( 'field_radius' );
			$field_shadow           = password_protected_get_option( 'field_shadow' );
			$field_shadow_opacity   = (int) password_protected_get_option( 'field_shadow_opacity', 1 );
			$field_shadow_opacity   = $field_shadow_opacity * .01;
			$field_shadow_inset     = password_protected_get_option( 'field_shadow_inset' );
			$field_font_size        = password_protected_get_option( 'field_font_size' );
			$field_color            = password_protected_get_option( 'field_color' );
			$field_shadow_inset     = $field_shadow_inset ? 'inset' : '';
			$checkbox_size          = password_protected_get_option( 'checkbox_size' );
			$checkbox_bg            = password_protected_get_option( 'checkbox_bg' );
			$checkbox_border        = password_protected_get_option( 'checkbox_border' );
			$checkbox_border_color  = password_protected_get_option( 'checkbox_border_color' );
			$checkbox_radius        = password_protected_get_option( 'checkbox_radius' );
			$remember_font_size     = password_protected_get_option( 'remember_font_size' );
			$remember_position      = password_protected_get_option( 'remember_position' );
			$remember_color         = password_protected_get_option( 'remember_color' );
			$button_bg              = password_protected_get_option( 'button_bg' );
			$button_border          = password_protected_get_option( 'button_border' );
			$button_border_color    = password_protected_get_option( 'button_border_color' );
			$button_side_padding    = password_protected_get_option( 'button_side_padding' );
			$button_padding_top     = password_protected_get_option( 'button_padding_top' );
			$button_padding_bottom  = password_protected_get_option( 'button_padding_bottom' );
			$button_radius          = password_protected_get_option( 'button_radius' );
			$button_shadow          = password_protected_get_option( 'button_shadow' );
			$button_shadow_opacity  = password_protected_get_option( 'button_shadow_opacity', 1 );
			$button_shadow_opacity  = (int) $button_shadow_opacity * .01;
			$button_font_size       = password_protected_get_option( 'button_font_size' );
			$button_color           = password_protected_get_option( 'button_color' );
			$form_bg                = password_protected_get_option( 'form_bg' );
			$form_radius            = password_protected_get_option( 'form_radius' );
			$form_shadow            = password_protected_get_option( 'form_shadow' );
			$form_shadow_opacity    = password_protected_get_option( 'form_shadow_opacity', 1 );
			$form_shadow_opacity    = (int) $form_shadow_opacity * .01;
			$form_side_padding      = password_protected_get_option( 'form_side_padding' );
			$form_bg_transparency   = password_protected_get_option( 'form_bg_transparency' );
			$form_vertical_padding  = password_protected_get_option( 'form_vertical_padding' );
			$form_width             = password_protected_get_option( 'form_width' );
			$bg_image               = password_protected_get_option( 'bg_image' );
			$bg_image_gallery       = password_protected_get_option( 'bg_image_gallery' );
			$bg_repeat              = password_protected_get_option( 'bg_repeat' );
			$bg_size                = password_protected_get_option( 'bg_size' );
			$bg_attach              = password_protected_get_option( 'bg_attach' );
			$bg_position            = password_protected_get_option( 'bg_position' );
			$bg_color               = password_protected_get_option( 'bg_color' );

			// phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
			// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			// echo '<link rel="stylesheet" type="text/css" href="' . $this->fonts( $password_protected_styles ) . '"/>';
			// phpcs:enable

			$css = '';

			if ( $disable_logo ) {
				$css .= '#password-protected-logo a {
					display: none;
				}
				#password-protected-logo,
				#password-protected-logo a {
					height: 0;
					width: 0;
				}';
			} else {

				$css .= '#password-protected-logo a {
					display: block;
					background-size: ' . esc_attr( $logo_width ) . 'px ' . esc_attr( $logo_height ) . 'px;
				}
				#password-protected-logo {
					height: ' . esc_attr( $logo_height ) . 'px;
				}
				#password-protected-logo,
				#password-protected-logo a {
					margin: 0 auto;
					width: ' . esc_attr( $logo_width ) . 'px;
					height: ' . esc_attr( $logo_height ) . 'px;
				}';

				if ( $logo ) {
					$logo = wp_get_attachment_image_url( $logo );
					$css .= '#password-protected-logo a {
						background-image: url("' . esc_attr( $logo ) . '");
					}';
				} else {
					$css .= '#password-protected-logo a {
						width: 84px;
						height: 84PX;
						background-size: 84px;
						background-image: none, url("' . esc_url( admin_url( 'images/wordpress-logo.svg' ) ) . '");
					}
					#password-protected-logo {
						width: 84px;
						height: 84px;
					}';
				}
			}
			$css .= 'label:not([for="password_protected_rememberme"]) {
				font-size: ' . esc_attr( $label_font_size ) . 'px;
				color: ' . sanitize_hex_color( $label_color ) . ';
				font-family: ' . esc_attr( $label_font ) . '
			}
			.input {
				margin-top: ' . esc_attr( $label_position ) . 'px !important;
			}';

			$css .= '.input {
				background-color: ' . sanitize_hex_color( $field_background_color ) . ' !important;
				border: ' . esc_attr( $field_border ) . 'px solid ' . sanitize_hex_color( $field_border_color ) . ' !important;
				margin-bottom: ' . esc_attr( $field_margin_bottom ) . 'px !important;
				padding: ' . esc_attr( $field_padding_top ) . 'px ' . esc_attr( $field_side_padding ) . 'px ' . esc_attr( $field_padding_bottom ) . 'px ' . esc_attr( $field_side_padding ) . 'px !important;
				border-radius: ' . esc_attr( $field_radius ) . 'px !important;
				font-size: ' . esc_attr( $field_font_size ) . 'px !important;
				color: ' . sanitize_hex_color( $field_color ) . ' !important;
				box-shadow: ' . esc_attr( $field_shadow_inset ) . ' 0 0 ' . esc_attr( $field_shadow ) . 'px rgba( 0, 0, 0, ' . esc_attr( $field_shadow_opacity ) . '), inset 0 0 0 9999px ' . sanitize_hex_color( $field_background_color ) . ' !important;
			}';

			$css .= 'label[for="password_protected_rememberme"]{
				font-size: ' . esc_attr( $remember_font_size ) . 'px;
				color: ' . sanitize_hex_color( $remember_color ) . ';
				margin-top: ' . esc_attr( $remember_position ) . 'px;
				font-family: ' . esc_attr( $remember_font ) . ';
			}';

			$css .= '#password_protected_rememberme {
				background-color: ' . sanitize_hex_color( $checkbox_bg ) . ';
				border: ' . esc_attr( $checkbox_border ) . 'px solid ' . sanitize_hex_color( $checkbox_border_color ) . ';
				width: ' . esc_attr( $checkbox_size ) . 'px;
				height: ' . esc_attr( $checkbox_size ) . 'px;
				border-radius: ' . esc_attr( $checkbox_radius ) . 'px;
			}';

			$css .= '#wp-submit {
				background-color: ' . sanitize_hex_color( $button_bg ) . ';
				border: ' . esc_attr( $button_border ) . 'px solid ' . sanitize_hex_color( $button_border_color ) . ';
				padding: ' . esc_attr( $button_padding_top ) . 'px ' . esc_attr( $button_side_padding ) . 'px ' . esc_attr( $button_padding_bottom ) . 'px ' . esc_attr( $button_side_padding ) . 'px;
				border-radius: ' . esc_attr( $button_radius ) . 'px;
				color: ' . sanitize_hex_color( $button_color ) . ';
				font-size: ' . esc_attr( $button_font_size ) . 'px;
				box-shadow: 0 0 ' . esc_attr( $button_shadow ) . ' rgba( 0, 0, 0, ' . esc_attr( $button_shadow_opacity ) . ' );
				font-family: ' . esc_attr( $button_font ) . '
			}';

			if ( $form_bg_transparency ) {
				$css .= '#password-protected-form, #loginform {
					background-color: transparent !important;
					border:none !important;
					box-shadow:none !important;
					background: none !important;
				}';
			} else {
				$css .= '#password-protected-form, #loginform {
					background-color: ' . sanitize_hex_color( $form_bg ) . ';
				}';
			}

			$css .= '#password-protected-form, #loginform {
				border-radius: ' . esc_attr( $form_radius ) . 'px !important;
				padding: ' . esc_attr( $form_vertical_padding ) . 'px ' . esc_attr( $form_side_padding ) . 'px !important;
				box-shadow: 0 0 ' . esc_attr( $form_shadow ) . ' rgba( 0, 0, 0, ' . esc_attr( $form_shadow_opacity ) . ') !important;
			}
			#login {
				width: ' . esc_attr( $form_width ) . 'px;
			}';

			$background_image = 'background-image: none;';
			if ( 'none' !== $bg_image_gallery ) {
				$image_url        = LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/' . $bg_image_gallery . '.jpg';
				$background_image = 'background-image: url( ' . esc_url( $image_url ) . ' )';
			}

			if ( ! empty( $bg_image ) ) {
				$background_image = 'background-image: url(' . esc_url( $bg_image ) . ')';
			}

			$css .= '#password-protected-background {
				' . esc_html( $background_image ) . ';
			}
			#password-protected-background, .login {
				background-attachment: ' . esc_attr( $bg_attach ) . ';
				background-position: ' . esc_attr( $bg_position ) . ';
				background-repeat: ' . esc_attr( $bg_repeat ) . ';
				background-size: ' . esc_attr( $bg_size ) . ';
			}
			.login {
				background-color: ' . sanitize_hex_color( $bg_color ) . ';
			}';

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<style>' . $css . '</style>';
		}

		/**
		 * Getting fonts URL.
		 *
		 * @param array $fonts_names fonts names.
		 */
		protected function fonts( $fonts_names ) {
			$fonts_url = '';
			$fonts     = array();

			$label_font    = $fonts_names['label_font'];
			$remember_font = $fonts_names['remember_font'];
			$button_font   = $fonts_names['button_font'];

			if ( $label_font ) {
				if ( 'default' !== $label_font ) {
					$fonts[] = $label_font;
				}
			}

			if ( $remember_font ) {
				if ( 'default' !== $remember_font ) {
					$fonts[] = $remember_font;
				}
			}

			if ( $button_font ) {
				if ( 'default' !== $button_font ) {
					$fonts[] = $button_font;
				}
			}

			if ( $fonts ) {
				$fonts_url = add_query_arg(
					array(
						'family' => rawurlencode( implode( '|', array_unique( $fonts ) ) ),
					),
					'https://fonts.googleapis.com/css'
				);
			}

			return esc_url_raw( $fonts_url );
		}

		/**
		 * Get password protected Id.
		 */
		public static function get_password_protected_id() {
			global $wpdb;
			// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery
			// phpcs:disable WordPress.DB.DirectDatabaseQuery.NoCaching
			$password_protected_page = $wpdb->get_var( $wpdb->prepare( "SELECT ID from {$wpdb->posts} WHERE post_type = 'page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_name = %s", 'password-protected' ) );
			return is_null( $password_protected_page ) ? false : $password_protected_page;
		}

		/**
		 * Create customizer page if not exist.
		 */
		public function create_customizer_page() {
			global $wpdb;
			$content = sprintf(
				'<p>' .
				// translators: %1$s to display page name.
				esc_attr__( 'This page is used by %1$s to preview the form on customizer', 'login-designer' )
				. '</p>',
				'password-protected'
			);

			$password_protected_options = array(
				'name'    => _x( 'password-protected', 'Page Slug', 'login-designer' ),
				'title'   => _x( 'Password Protected', 'Page Title', 'login-designer' ),
				'content' => $content,
			);

			$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_name = %s", $password_protected_options['name'] ) );
			if ( $valid_page_found ) {
				return $valid_page_found;
			}

			$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID from {$wpdb->posts} WHERE post_type = 'page' AND post_status = 'trash' AND post_name = %s", $password_protected_options['name'] ) );
			if ( $trashed_page_found ) {
				$page_id   = $trashed_page_found;
				$page_date = array(
					'ID'          => $page_id,
					'post_status' => 'publish',
				);

				wp_update_post( $page_date );
			} else {
				$page_data = array(
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'post_author'    => 1,
					'post_name'      => $password_protected_options['name'],
					'post_title'     => $password_protected_options['title'],
					'post_content'   => $password_protected_options['content'],
					'comment_status' => 'closed',
				);
				$page_id   = wp_insert_post( $page_data );
				login_designer_attach_template_to_page( $page_id, 'template-password-protected.php' );
			}

			return $page_id;
		}
	}
}

return new Login_Designer_Password_Protected();
