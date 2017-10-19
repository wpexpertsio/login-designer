<?php
/**
 * Alpha Color Picker Customizer Control
 *
 * @see https://github.com/BraadMartin/components/tree/master/customizer/alpha-color-picker
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
 * This class is for the alpha color picker in the Customizer.
 *
 * @access  public
 */
class Login_Designer_Alpha_Color_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'alpha-color';

	/**
	 * Add support for color palettes.
	 *
	 * @access public
	 * @var array
	 */
	public $palette;

	/**
	 * Add support for opacity on the slider handle.
	 *
	 * @access public
	 * @var array
	 */
	public $show_opacity;

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
		wp_enqueue_style( 'login-designer-alpha-color-control', $css_dir . 'login-designer-customize-alpha-color-control' . $suffix . '.css', LOGIN_DESIGNER_VERSION, 'all' );

		// Custom control scripts.
		wp_enqueue_script( 'login-designer-alpha-color-control', $js_dir . 'login-designer-customize-alpha-color-control' . $suffix . '.js', array( 'jquery' ), LOGIN_DESIGNER_VERSION, 'all' );
	}

	/**
	 * Render the content.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/render_content/
	 */
	public function render_content() {

		// Process the palette.
		if ( is_array( $this->palette ) ) {
			$palette = implode( '|', $this->palette );
		} else {
			// Default to true.
			$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
		}

		// Support passing show_opacity as string or boolean. Default to true.
		$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true'; ?>

		<label>
			<?php
			if ( isset( $this->label ) && '' !== $this->label ) {
				echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
			}
			if ( isset( $this->description ) && '' !== $this->description ) {
				echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
			} ?>
			<input class="alpha-color-control" type="text" data-show-opacity="<?php echo esc_attr( $show_opacity ); ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
		</label>
		<?php
	}
}
