<?php
/**
 * Layout Customizer Control
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
 * This class is for the range control in the Customizer.
 *
 * @access  public
 */
class Login_Designer_Range_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'login-designer-range';

	/**
	 * Get the control default.
	 *
	 * @access public
	 * @var $type Customizer type option
	 */
	public $default = 'default';

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
		wp_enqueue_script( 'login-designer-range-control', $dir . 'login-designer-range-control.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
	}

	/**
	 * Render the content.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/render_content/
	 */
	public function render_content() {
		?>

		<div class="relative">

			<?php if ( ! empty( $this->label ) ) : ?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				</label>
			<?php endif; ?>

			<div class="value">
				<span><?php echo esc_attr( $this->value() ); ?></span>
				<input class="track-input" data-default-value="<?php echo esc_html( $this->default ); ?>" type="number"<?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
				<em><?php echo esc_html( $this->description ); ?></em>
			</div>

			<input class="track" data-default-value="<?php echo esc_html( $this->default ); ?>" data-input-type="range" type="range"<?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />

			<a type="button" value="reset" class="range-reset"></a>

		</div>

		<?php
	}
}
