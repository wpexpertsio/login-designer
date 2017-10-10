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
class Loginly_Template_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'loginly-template-selector';

	/**
	 * Enqueue neccessary custom control stylesheet.
	 */
	public function enqueue() {

		// Define where the control's scripts are.
		$js_dir = LOGINLY_PLUGIN_URL . 'assets/js/';
		$css_dir = LOGINLY_PLUGIN_URL . 'assets/css/';

		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Custom control styles.
		wp_enqueue_style( 'loginly-template-control', $css_dir . 'loginly-customize-template-control' . $suffix . '.css', LOGINLY_VERSION, 'all' );

		// Custom control scripts.
		wp_enqueue_script( 'loginly-template-control', $js_dir . 'loginly-customize-template-control' . $suffix . '.js', array( 'jquery' ), LOGINLY_VERSION, 'all' );

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

		<div class="layout-switcher__wrapper">
			<?php foreach ( $this->choices as $value => $label ) { ?>

			   <input id="<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $value ); ?>" class="layout" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<label for="<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $value ); ?>">
					<div class="intrinsic">
						<div class="layout-screenshot" style="background-image: url( <?php echo esc_html( $this->choices[ $value ] ); ?> );"></div>
			   </label>
					</div>

			<?php } ?>
		</div>

		<button id="layout-switcher" class="button layout-switcher"><?php esc_html_e( 'Install New Template', '@@textdomain' ); ?></button>

		<?php
	}
}
