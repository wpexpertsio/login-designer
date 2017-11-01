<?php
/**
 * Title Customizer Control
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
	 * Enqueue neccessary custom control stylesheet.
	 */
	public function enqueue() {

		// Define where the control's scripts are.
		$js_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/dist/';
		$css_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/css/';

		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Custom control styles.
		wp_enqueue_style( 'login-designer-license-control', $css_dir . 'login-designer-customize-license-control' . $suffix . '.css', LOGIN_DESIGNER_VERSION, 'all' );

		// Custom control scripts.
		wp_enqueue_script( 'login-designer-license-control', $js_dir . 'login-designer-customize-license-control' . $suffix . '.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );

		wp_localize_script( 'login-designer-license-control', '_login_designer_license', array(
			'confirm' 	=> esc_html__( 'Attention! You are attempting to reset all custom styling added to Login Designer. Please note that this action is irreversible. Proceed?', '@@textdomain' ),
			'nonce'   	=> array( 'license' => wp_create_nonce( 'login-designer-license' ), 'deactivate' => wp_create_nonce( 'login-designer-deactivate-license' ) ),
			'ajaxurl'   	=> admin_url( 'admin-ajax.php' ),
		) );
	}

	/**
	 * Render the content.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/render_content/
	 */
	public function render_content() {

		$customizer 		= new Login_Designer_Customizer();
		$key 			= $customizer->key();
		$status 		= $customizer->status();
		$expiration 		= $customizer->expiration();
		$site_count 		= $customizer->site_count();
		$activations_left 	= $customizer->activations_left();
		$is_valid 		= $customizer->is_valid_license();
		$visibility 		= ( true === $is_valid ) ? 'is-valid' : 'is-not-valid';

		// Array of allowed HTML.
		$allowed_html_array = array(
			'a' => array(
				'href' => array(),
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

		<form id="license-form">
			<input id="license-key" class="license" spellcheck="false" type="text" <?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
			<input type="submit" name="login-designer-license" id="login-designer-activate-license" value="Activate" class="button-secondary button <?php echo esc_attr( $visibility ); ?>">
			<input type="submit" name="login-designer-deactivate-license" id="login-designer-deactivate-license" value="Deactivate" class="button-secondary button <?php echo esc_attr( $visibility ); ?>">

			<div class="spinner"></div>

		</form>

		<ul id="license-info" class="<?php echo esc_attr( $visibility ); ?>">

			<li><strong>Status:</strong> <span id="license-status"><?php echo $status; ?></span></li>

			<li id="li--license-expiration"><strong>Expiration:</strong> <span id="license-expiration"><?php echo $expiration; ?></span></li>

			<li id="li--license-site_count"><strong>Activations:</strong>
				<?php if ( 'unlimited' !== $activations_left ) { ?>
					<span id="license-site_count"><?php echo $site_count; ?></span> out of <span id="license-activations_left"><?php echo $activations_left; ?></span></li>
				<?php } else { ?>
					Unlimited
				<?php } ?>
			</li>

		<ul>

		<?php
	}
}























