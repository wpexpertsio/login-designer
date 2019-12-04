<?php
/**
 * Title Customizer Control
 *
 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/
 *
 * @package Login Designer
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
class Login_Designer_License_Control extends WP_Customize_Control {

	/**
	 * Set the control type.
	 *
	 * @var $type Customizer type
	 */
	public $type = 'login-designer-license';

	/**
	 * Enqueue neccessary custom control scripts.
	 * Localization occurs in the Login_Designer_Customizer_Scripts() class (based on LOGIN_DESIGNER_DEBUG).
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
		wp_enqueue_script( 'login-designer-license-control', $dir . 'login-designer-license-control.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
	}

	/**
	 * Render the content.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/render_content/
	 */
	public function render_content() {
		$customizer       = new Login_Designer_License_Handler();
		$key              = $customizer->key();
		$status           = $customizer->status();
		$expiration       = $customizer->expiration();
		$site_count       = $customizer->site_count();
		$activations_left = $customizer->activations_left();
		$is_valid         = $customizer->is_valid_license();
		$visibility       = ( true === $is_valid ) ? 'is-valid' : 'is-not-valid';

		// Array of allowed HTML.
		$allowed_html_array = array(
			'a' => array(
				'href'   => array(),
				'target' => array(),
			),
		);

		if ( isset( $this->label ) ) {
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		}

		if ( ! empty( $this->description ) ) {
			echo '<span class="customize-control-description">' . wp_kses( $this->description, $allowed_html_array ) . '</span>';
		}
		?>

		<form id="license-form" name="license-form">
			<input id="license-key" class="license" name="license-key" spellcheck="false" type="text" <?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
			<input type="submit" name="login-designer-license" id="login-designer-activate-license" value="Activate" class="button-secondary button <?php echo esc_attr( $visibility ); ?>">
			<input type="submit" name="login-designer-deactivate-license" id="login-designer-deactivate-license" value="Deactivate" class="button-secondary button <?php echo esc_attr( $visibility ); ?>">
			<div class="spinner"></div>
		</form>

		<div id="license-error"></div>

		<ul id="license-info" class="<?php echo esc_attr( $visibility ); ?>">

			<li><strong>Status:</strong> <span id="license-status"><?php echo esc_html( $status ); ?></span></li>

			<li id="li--license-expiration"><strong>Expiration:</strong> <span id="license-expiration"><?php echo esc_html( $expiration ); ?></span></li>

			<li id="li--license-site_count"><strong>Activations:</strong>
				<?php if ( 'unlimited' !== $activations_left ) { ?>
					<span id="license-site_count"><?php echo esc_html( $site_count ); ?></span> out of <span id="license-activations_left"><?php echo esc_html( $activations_left ); ?></span></li>
				<?php } else { ?>
					Unlimited
				<?php } ?>
			</li>

		<ul>

		<?php
	}
}
