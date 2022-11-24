<?php
/**
 * Login Designer File Import Button Control
 *
 * @package Login Designer
 */

/**
 * Class Login_Designer_File_Import_Button_Control
 */
class Login_Designer_File_Import_Button_Control extends WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @since 4.2.0
	 * @var string
	 */
	public $type = 'import-json-file';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 3.4.0
	 * @since 4.2.0 Moved from WP_Customize_Upload_Control.
	 */
	public function enqueue() {
		if ( ! defined( 'LOGIN_DESIGNER_DEBUG' ) || ( defined( 'LOGIN_DESIGNER_DEBUG' ) && false === LOGIN_DESIGNER_DEBUG ) ) {
			return;
		}

		// Define where the asset is loaded from.
		$dir = Login_Designer()->asset_source( 'js', 'controls/' );

		// Enqueue the asset. Note that there is no minified version of this singular asset.
		wp_enqueue_script( 'login-designer-file-import-control', $dir . 'login-designer-file-import-control.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
		wp_localize_script(
			'login-designer-file-import-control',
			'login_designer_file_import_object',
			array(
				'nonce'   => wp_create_nonce(),
				'element' => $this->type,
			)
		);
	}

	/**
	 * Function use to grt values
	 */
	public function to_json() {
		parent::to_json();

		$this->json['id']           = $this->id;
		$this->json['value']        = $this->value();
		$this->json['link']         = $this->get_link();
		$this->json['defaultValue'] = $this->setting->default;
	}

	/**
	 * Don't render any content for this control from PHP.
	 *
	 * @since 3.4.0
	 * @since 4.2.0 Moved from WP_Customize_Upload_Control.
	 *
	 * @see WP_Customize_Media_Control::content_template()
	 */
	public function render_content() {
		?>
		<div class="login-designer-import-export-btns">
			<button class="button-secondary login-designer-import-export-buttons" id="login-customizer-export-btn" data-login-designer-export-element="#login-designer-export-container"><?php esc_attr_e( 'Export', 'login-designer' ); ?></button>
			<button class="button-secondary login-designer-import-export-buttons" id="login-customizer-import-btn" data-login-designer-import-element="#login-designer-import-container"><?php esc_attr_e( 'Import', 'login-designer' ); ?></button>
		</div>


		<div id="login-designer-export-container" class="login-designer-ix-container" style="display: none;">
			<textarea class="login-designer-textarea" id="login-designer-export-textarea"></textarea>
			<button class="button-secondary login-designer-export-button" data-login-designer-copy-element="#login-designer-export-textarea" id="login-designer-export-btn"><?php esc_attr_e( 'Copy to Clipboard', 'login-designer' ); ?></button>
		</div>

		<div id="login-designer-import-container" class="login-designer-ix-container" style="display: none;">
			<textarea class="login-designer-textarea" id="login-designer-import-textarea"></textarea>
			<button class="button-secondary login-designer-import-button" id="login-designer-import-btn" data-login-designer-import-json-element="#login-designer-import-textarea"><?php esc_attr_e( 'Save and Apply', 'login-designer' ); ?></button>
		</div>

		<div style="display: none;" class="login-designer-snackbar login-designer-snackbar-hide-2000">
			<span class="login-designer-snackbar-text">
				<?php esc_attr_e( 'Text copied to clipboard', 'login-designer' ); ?>
				<button class="login-designer-snackbar-close"><?php esc_attr_e( 'Close', 'login-designer' ); ?></button>
			</span>
		</div>
		<?php
	}
}
