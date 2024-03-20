<?php
/**
 * Login Designer Localize Google Fonts
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Login_Designer_Localize_Google_Fonts' ) && class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Login Designer Localize Google Fonts
	 */
	class Login_Designer_Localize_Google_Fonts extends WP_Customize_Control {
		/**
		 * Customize Control Type
		 *
		 * @var string $type The type.
		 */
		public $type = 'login-designer-localize-google-fonts';

		/**
		 * Enqueue scripts
		 */
		public function enqueue() {
			wp_enqueue_script( 'login-designer-' . str_replace( '_', '-', __CLASS__ ), LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/src/controls/localize-google-fonts.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
			wp_localize_script(
				'login-designer-' . str_replace( '_', '-', __CLASS__ ),
				'login_designer_google_fonts',
				array(
					'_wpnonce' => wp_create_nonce( 'login-designer-google-fonts' ),
				)
			);
		}

		/**
		 * Convert array to json
		 */
		public function to_json() {
			$login_designer_output = new Login_Designer_Customizer_Output();
			parent::to_json();
			$this->json['label']              = $this->label;
			$this->json['id']                 = $this->id;
			$this->json['value']              = $this->value();
			$this->json['link']               = $this->get_link();
			$this->json['button']['disabled'] = empty( $login_designer_output->fonts() );
			$this->json['button_title']       = esc_attr__( 'Import google fonts to your site', 'login-designer' );
			$this->json['message']            = esc_html__( 'Make sure you have published the changes before Importing Google Fonts', 'login-designer' );
		}

		/**
		 * Render content

		 * @override WP_Customize_Control::render_content()
		 */
		public function render_content() {}

		/**
		 * Content template
		 */
		public function content_template() {
			?>
			<span class="customize-control-title">{{ data.label }}</span>

			<div class="login-designer--localize-google-fonts">
				<button
					type="button"
					id="login-designer-localize-google-fonts"
					class="button-primary"
					{{ data.button.disabled ? "disabled='disabled'" : "" }}
				>{{ data.button_title }}</button>

				<div id="login-designer-google-fonts-response"></div>

				<div class="notice notice-warning">
					<p>{{ data.message }}</p>

					<span id="login-designer-google-fonts-spinner" class="spinner"></span>
				</div>
			</div>
			<?php
		}
	}
}
