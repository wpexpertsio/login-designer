<?php
/**
 * File: class-login-designer-section.php
 *
 * @package Login Designer Pro
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Customize_Section' ) ) {
	return;
}

if ( ! class_exists( 'Login_Designer_Section' ) ) {
	/**
	 * Class Login_Designer_Section
	 */
	class Login_Designer_Section extends WP_Customize_Section {
		/**
		 * Login Designer Section
		 *
		 * @type Login_Designer_Section
		 *
		 * @var string
		 */
		public $type = 'login-designer-section';

		/**
		 * Login Designer type.
		 *
		 * @var null
		 */
		protected $login_designer_type;

		/**
		 * Login Designer title.
		 *
		 * @var null
		 */
		protected $login_designer_title;

		/**
		 * Converting custom attributes to json.
		 *
		 * @return array
		 */
		public function json() {
			$array                         = parent::json();
			$array['login_designer_type']  = $this->login_designer_type;
			$array['login_designer_title'] = $this->login_designer_title;
			return $array;
		}

		/**
		 * Rendering template content.
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
				<h3 class="accordion-section-title" tabindex="0">
					{{ data.title }} <span class="login_designer_section_tag {{ data.login_designer_type }}">{{ data.login_designer_title }}</span>
					<span class="screen-reader-text"><?php esc_attr_e( 'Press return or enter to open this section' ); ?></span>
				</h3>
				<ul class="accordion-section-content">
					<li class="customize-section-description-container section-meta <# if ( data.description_hidden ) { #>customize-info<# } #>">
						<div class="customize-section-title">
							<button class="customize-section-back" tabindex="-1">
								<span class="screen-reader-text"><?php esc_attr_e( 'Back' ); ?></span>
							</button>
							<h3>
							<span class="customize-action">
								{{{ data.customizeAction }}}
							</span>
								{{ data.title }} <span class="login_designer_section_tag--title {{ data.login_designer_type }}">{{ data.login_designer_title }}</span>
							</h3>
							<# if ( data.description && data.description_hidden ) { #>
							<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php esc_attr_e( 'Help' ); ?></span></button>
							<div class="description customize-section-description">
								{{{ data.description }}}
							</div>
							<# } #>

							<div class="customize-control-notifications-container"></div>
						</div>

						<# if ( data.description && ! data.description_hidden ) { #>
						<div class="description customize-section-description">
							{{{ data.description }}}
						</div>
						<# } #>
					</li>
				</ul>
			</li>
			<?php
		}
	}
}
