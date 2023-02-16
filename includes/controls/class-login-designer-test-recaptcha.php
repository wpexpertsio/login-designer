<?php
/**
 * Login Designer - Test reCAPTCHA Control
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Login_Designer_Test_Recaptcha' ) && class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Login Designer - Test reCAPTCHA Control
	 */
	class Login_Designer_Test_Recaptcha extends WP_Customize_Control {
		/**
		 * Control type
		 *
		 * @var string
		 */
		public $type = 'login-designer-test-recaptcha';

		/**
		 * Render the control's content.
		 */
		public function enqueue() {
			wp_enqueue_script( 'login-designer-test-recaptcha', LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/src/controls/test-recaptcha.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
			wp_localize_script(
				'login-designer-test-recaptcha',
				'login_designer_recaptcha_object',
				array(
					'_wpnonce' => wp_create_nonce( 'login-designer-recaptcha-test' ),
				)
			);
		}

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 */
		public function to_json() {
			parent::to_json();
			$this->json['id']    = $this->id;
			$this->json['value'] = $this->value();

				$this->json['button_v3'] = esc_html__( 'Validate and Save', 'login-designer' );
				$this->json['button_v2'] = esc_html__( 'Render Recaptcha', 'login-designer' );
		}

		/**
		 * Render the control's content.
		 */
		public function render_content() {  }

		/**
		 * An Underscore (JS) template for this control's content.
		 */
		protected function content_template() {
			?>
			<div id="{{ data.id }}">
				<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
				<# } #>
				<br>
				<div class="notice" id="recaptcha-validation-success"></div>
				<br>

				<# disabled = ! data.value.verified ? 'disabled' : '';  #>
				<button class="button button-secondary" id="test-recaptcha" {{ disabled }} >
					<# let google_recaptcha_version = wp.customize( 'login_designer_google_recaptcha[recaptcha_version]' ).get() #>
					<# google_recaptcha_version = parseInt( google_recaptcha_version ) #>
					<# if ( 2 === google_recaptcha_version ) { #>
						{{ data.button_v2 }}
					<# } else { #>
						{{ data.button_v3 }}
					<# } #>
				</button>

				<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
				<# } #>
			</div>
			<?php
		}
	}
}
