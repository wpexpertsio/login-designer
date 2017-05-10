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
class Loginly_Template_Selector_Control extends WP_Customize_Control {

	/**
	 * Set the variables to be used in this control.
	 *
	 * @var string $type Control Name.
	 */
	public $type = 'loginly-template-selector';

	/**
	 * Enqueue neccessary custom control stylesheet.
	 */
	public function enqueue() {

		$js_dir = LOGINLY_PLUGIN_URL . 'assets/js/';

		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

		wp_register_script( 'loginly-template-selector', $js_dir . 'loginly-template-selector' . $suffix . '.js', array( 'jquery' ), LOGINLY_VERSION, 'all' );
		wp_enqueue_script( 'loginly-template-selector' );
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
						<div class="layout-screenshot" style="background-image: url( <?php echo esc_html( $this->choices[$value] ); ?> );"></div>
					</div>
			   </label>

			<?php } ?>
		</div>

		<button id="layout-switcher" class="button layout-switcher"><?php esc_html_e( 'Install New Template', '@@textdomain' ); ?></button>
		
		<?php
	}
}
