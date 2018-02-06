<?php
/**
 * Title Customizer Control
 *
 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/
 *
 * @package   @@pkg.title
 * @author    @@pkg.author
 * @license   @@pkg.license
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
	 * Render the content.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/render_content/
	 */
	public function render_content() {

		// Array of allowed HTML.
		$allowed_html_array = array(
			'a' => array(
				'href' => array(),
				'target' => array(),
			),
		);

		if ( isset( $this->label ) ) {
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		}

		if ( ! empty( $this->description ) ) {
			echo '<span class="customize-control-description">' . wp_kses( $this->description, $allowed_html_array ) . '</span>';
		}

	}
}
