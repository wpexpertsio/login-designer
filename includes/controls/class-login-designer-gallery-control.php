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

		<div id="login-designer-gallery" class="login-designer-gallery">
			<?php foreach ( $this->choices as $value => $label ) { ?>

				<div class="login-designer-gallery__item">
			   		<input id="<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $value ); ?>" class="login-designer-gallery__checkbox" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<label for="<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $value ); ?>">
						<div class="login-designer-gallery__intrinsic">
							<div class="login-designer-gallery__img" style="background-image: url( <?php echo esc_html( $this->choices[ $value ] ); ?> );"></div>
						</div>
					</label>

				</div>

			<?php } ?>
		</div>

		<?php
	}
}
