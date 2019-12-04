<?php
/**
 * Template Customizer Control
 *
 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if WP_Customize_Control does not exsist.
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * This class is for the gallery selector in the Customizer.
 *
 * @access  public
 */
class Login_Designer_Template_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'login-designer-templates';

	/**
	 * Enqueue neccessary custom control scripts.
	 */
	public function enqueue() {

		// Use this only if LOGIN_DESIGNER_DEBUG is active.
		// If it is not active, we're loading the concated and minified login-designer-custom-controls.min.js file.
		if ( ! defined( 'LOGIN_DESIGNER_DEBUG' ) || ( defined( 'LOGIN_DESIGNER_DEBUG' ) && false === LOGIN_DESIGNER_DEBUG ) ) {
			return;
		}

		// Define where the asset is loaded from.
		$dir = Login_Designer()->asset_source( 'js', 'controls/' );

		// Enqueue the asset. Note that there is no minified version of this singular asset.
		wp_enqueue_script( 'login-designer-template-control', $dir . 'login-designer-template-control.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @access public
	 * @since  1.1.7
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// The setting value.
		$this->json['id']      = $this->id;
		$this->json['value']   = $this->value();
		$this->json['link']    = $this->get_link();
		$this->json['choices'] = $this->choices;
	}

	/**
	 * Don't render the content via PHP.  This control is handled with a JS template.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function render_content() {}

	/**
	 * An Underscore (JS) template for this control's content.
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see    WP_Customize_Control::print_template()
	 *
	 * @access protected
	 * @since  1.1.7
	 * @return void
	 */
	protected function content_template() {
		?>

		<# if ( ! data.choices ) {
			return;
		} #>

		<# if ( data.description ) { #>
			<span class="customize-control-description">{{ data.description }}</span>
		<# } #>

		<div id="login-designer-templates" class="login-designer-templates">

			<# for ( choice in data.choices ) { #>

				<input type="radio" value="{{ choice }}" name="_customize-{{ data.id }}" id="{{ data.id }}{{ choice }}" class="login-designer-templates__input" {{{ data.link }}} <# if ( data.value === choice ) { #> checked="checked" <# } #> />

				<label for="{{ data.id }}{{ choice }}" class="login-designer-templates__label">
					<div class="login-designer-templates__intrinsic">
						<div class="login-designer-templates__screenshot" style="background-image: url( {{ data.choices[ choice ] }} );"></div>
					</div>
				</label>

			<# } #>

		</div>

		<?php
	}
}
