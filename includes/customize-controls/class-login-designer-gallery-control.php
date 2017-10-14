<?php
/**
 * Layout Customizer Control
 *
 * @see ttps://developer.wordpress.org/reference/classes/wp_customize_control/
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
 * This class is for the template selector in the Customizer.
 *
 * @access  public
 */
class LoginDesigner_Background_Gallery_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'login-designer-gallery';

	/**
	 * Enqueue neccessary custom control stylesheet.
	 */
	public function enqueue() {

		// Define where the control's scripts are.
		$js_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/';
		$css_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/css/';

		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Custom control styles.
		wp_enqueue_style( 'login-designer-gallery-control', $css_dir . 'login-designer-customize-gallery-control' . $suffix . '.css', LOGIN_DESIGNER_VERSION, 'all' );
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

		<div class="gallery">
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

		<?php
	}
}
