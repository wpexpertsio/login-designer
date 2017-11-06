<?php
/**
 * Layout Customizer Control
 *
 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 * @version   @@pkg.version
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
class Login_Designer_Background_Gallery_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'login-designer-gallery';

	/**
	 * Enqueue neccessary custom control scripts.
	 */
	public function enqueue() {

		// Use this only if SCRIPT_DEBUG is turned on.
		if ( defined( 'SCRIPT_DEBUG' ) && false === SCRIPT_DEBUG ) {
			return;
		}

		// Define where the control's scripts are.
		$js_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/controls/';

		// Custom control scripts.
		wp_enqueue_script( 'login-designer-gallery-control', $js_dir . 'login-designer-gallery-control.js', array( 'jquery' ), LOGIN_DESIGNER_VERSION, 'all' );
	}

	/**
	 * Render the content.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/render_content/
	 */
	public function render_content() {

		$name = '_customize-layout-' . $this->id;

		if ( isset( $this->label ) ) {
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		}

		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
		} ?>

		<div id="login-designer-gallery" class="gallery">
			<?php foreach ( $this->choices as $value => $label ) { ?>

				<div class="gallery__item">
			   		<input id="<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $value ); ?>" class="checkbox" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<label for="<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $value ); ?>">
						<div class="gallery--intrinsic">
							<div class="gallery--img" style="background-image: url( <?php echo esc_html( $this->choices[ $value ] ); ?> );"></div>
						</div>
					</label>

				</div>

			<?php } ?>
		</div>

		<button id="gallery-button" class="button"><?php esc_html_e( 'Open Gallery', '@@textdomain' ); ?></button>

		<?php
	}
}
