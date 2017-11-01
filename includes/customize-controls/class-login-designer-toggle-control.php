<?php
/**
 * Toggle Customizer Control
 *
 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/
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

// Exit if WP_Customize_Control does not exsist.
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * This class is for the toggle control in the Customizer.
 *
 * @access  public
 */
class Login_Designer_Toggle_Control extends WP_Customize_Control {

	/**
	 * Enqueue neccessary custom control stylesheet.
	 */
	public function enqueue() {

		// Define where the control's scripts are.
		$css_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/css/';

		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Custom control styles.
		wp_enqueue_style( 'login-designer-toggle-control', $css_dir . 'login-designer-toggle-control' . $suffix . '.css', LOGIN_DESIGNER_VERSION, 'all' );
	}

	/**
	 * Render the control's content.
	 *
	 * @author soderlind
	 * @version 1.2.0
	 */
	public function render_content() {
		?>
		<label>
			<div class="toggle-wrapper">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input id="cb<?php echo esc_attr( $this->instance_number ); ?>" type="checkbox" class="tgl tgl-light" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
				<label for="cb<?php echo esc_attr( $this->instance_number ); ?>" class="tgl-btn"></label>
			</div>
			<?php if ( ! empty( $this->description ) ) { ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php } ?>
		</label>
		<?php
	}
}
