<?php
/**
 * Title Customizer Control
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
 * This class is for the title control in the Customizer.
 *
 * @access  public
 */
class Login_Designer_Title_Control extends WP_Customize_Control {

	/**
	 * Set the control type.
	 *
	 * @var $type Customizer type
	 */
	public $type = 'login-designer-title';

	/**
	 * Don't render the content via PHP.  This control is handled with a JS template.
	 *
	 * @access public
	 * @since  1.1.7
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

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="customize-control-description">{{ data.description }}</span>
		<# } #>

		<?php
	}
}
