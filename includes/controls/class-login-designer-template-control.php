<?php
/**
 * Layout Customizer Control
 *
 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/
 *
 * @package   @@pkg.name
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
 * This class is for the template selector in the Customizer.
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
	public $type = 'login-designer-template-selector';

	/**
	 * Enqueue neccessary custom control stylesheet.
	 * Localization occurs in the Login_Designer_Customizer_Scripts() class (based on SCRIPT_DEBUG).
	 */
	public function enqueue() {

		// Use this only if SCRIPT_DEBUG is turned on.
		if ( defined( 'SCRIPT_DEBUG' ) && false === SCRIPT_DEBUG ) {
			return;
		}

		// Define where the control's scripts are.
		$js_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/controls/';

		// Custom control scripts.
		wp_enqueue_script( 'login-designer-template-control', $js_dir . 'login-designer-template-control.js', array( 'jquery' ), LOGIN_DESIGNER_VERSION, 'all' );
	}

	/**
	 * Render the content.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/render_content/
	 */
	public function render_content() {

		$name = '_customize-layout-' . $this->id;

		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
		} ?>

		<div class="login-designer-templates-wrapper">
			<?php foreach ( $this->choices as $value => $label ) { ?>

			   <input id="<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $value ); ?>" class="layout" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<label for="<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $value ); ?>">
						<div class="intrinsic">
							<div class="layout-screenshot" style="background-image: url( <?php echo esc_html( $this->choices[ $value ] ); ?> );"></div>
						</div>
					</label>

			<?php } ?>
		</div>

		<button id="layout-switcher" class="button layout-switcher hidden"><?php esc_html_e( 'Install New Template', '@@textdomain' ); ?></button>

		<?php
	}
}
