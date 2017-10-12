<?php
/**
 * Customize API: Loginly_Background_Control class
 *
 * @package Customizer Custom Background
 * @since 1.0.0
 */

/**
 * Customize Custom Background Control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Upload_Control
 */
class Loginly_Background_Control extends WP_Customize_Upload_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'background-image';

	/**
	 * Mime type for upload control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $mime_type = 'image';

	/**
	 * Labels for upload control buttons.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $button_labels = array();

	/**
	 * Field labels
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $field_labels = array();

	/**
	 * Background choices for the select fields.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $background_choices = array();

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @uses WP_Customize_Upload_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Calls the parent __construct.
		parent::__construct( $manager, $id, $args );

		// Set button labels for image uploader.
		$button_labels = $this->get_button_labels();
		$this->button_labels = apply_filters( 'loginly_background_button_labels', $button_labels, $id );

		// Set field labels.
		$field_labels = $this->get_field_labels();
		$this->field_labels = apply_filters( 'loginly_background_field_labels', $field_labels, $id );

		// Set background choices.
		$background_choices = $this->get_background_choices();
		$this->background_choices = apply_filters( 'loginly_background_choices', $background_choices, $id );

	}

	/**
	 * Enqueue neccessary custom control stylesheet.
	 */
	public function enqueue() {

		parent::enqueue();

		// Define where the control's scripts are.
		$js_dir = LOGINLY_PLUGIN_URL . 'assets/js/';
		$css_dir = LOGINLY_PLUGIN_URL . 'assets/css/';

		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Custom control scripts.
		wp_enqueue_script( 'loginly-background-control', $js_dir . 'loginly-customize-background-control' . $suffix . '.js', array( 'jquery' ), LOGINLY_VERSION, 'all' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {

		parent::to_json();

		$background_choices = $this->background_choices;
		$field_labels = $this->field_labels;

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $field_labels[ $setting_key ] ) ? $field_labels[ $setting_key ] : '',
			);

			if ( 'image_url' === $setting_key ) {
				if ( $this->value( $setting_key ) ) {
					// Get the attachment model for the existing file.
					$attachment_id = attachment_url_to_postid( $this->value( $setting_key ) );
					if ( $attachment_id ) {
						$this->json['attachment'] = wp_prepare_attachment_for_js( $attachment_id );
					}
				}
			} elseif ( 'repeat' === $setting_key ) {
				$this->json[ $setting_key ]['choices'] = $background_choices['repeat'];
			} elseif ( 'size' === $setting_key ) {
				$this->json[ $setting_key ]['choices'] = $background_choices['size'];
			} elseif ( 'position' === $setting_key ) {
				$this->json[ $setting_key ]['choices'] = $background_choices['position'];
			} elseif ( 'attach' === $setting_key ) {
				$this->json[ $setting_key ]['choices'] = $background_choices['attach'];
			}
		}
	}

	/**
	 * Render a JS template for the content of the media control.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {

		parent::content_template();
		?>

		<div class="background-image-fields">
		<# if ( data.attachment && data.repeat && data.repeat.choices ) { #>
			<li class="background-image-repeat">
				<# if ( data.repeat.label ) { #>
					<span class="customize-control-title">{{ data.repeat.label }}</span>
				<# } #>
				<select {{{ data.repeat.link }}}>
					<# _.each( data.repeat.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.repeat.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>
				</select>
			</li>
		<# } #>

		<# if ( data.attachment && data.size && data.size.choices ) { #>
			<li class="background-image-size">
				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }}</span>
				<# } #>
				<select {{{ data.size.link }}}>
					<# _.each( data.size.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.size.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>
				</select>
			</li>
		<# } #>

		<# if ( data.attachment && data.position && data.position.choices ) { #>
			<li class="background-image-position">
				<# if ( data.position.label ) { #>
					<span class="customize-control-title">{{ data.position.label }}</span>
				<# } #>
				<select {{{ data.position.link }}}>
					<# _.each( data.position.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.position.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>
				</select>
			</li>
		<# } #>

		<# if ( data.attachment && data.attach && data.attach.choices ) { #>
			<li class="background-image-attach">
				<# if ( data.attach.label ) { #>
					<span class="customize-control-title">{{ data.attach.label }}</span>
				<# } #>
				<select {{{ data.attach.link }}}>
					<# _.each( data.attach.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.attach.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>
				</select>
			</li>
		<# } #>

		</div>

		<?php
	}

	/**
	 * Returns button labels.
	 *
	 * @since 1.0.0
	 */
	public static function get_button_labels() {

		$button_labels = array(
			'select'       => __( 'Upload Image', '@@textdomain' ),
			'change'       => __( 'Change', '@@textdomain' ),
			'remove'       => __( 'Remove', '@@textdomain' ),
			'default'      => __( 'Default', '@@textdomain' ),
			'placeholder'  => __( 'No image selected', '@@textdomain' ),
			'frame_title'  => __( 'Select Image', '@@textdomain' ),
			'frame_button' => __( 'Choose Image', '@@textdomain' ),
		);

		return $button_labels;

	}

	/**
	 * Returns field labels.
	 *
	 * @since 1.0.0
	 */
	public static function get_field_labels() {

		$field_labels = array(
			'repeat'	=> __( 'Repeat', '@@textdomain' ),
			'size'		=> __( 'Size', '@@textdomain' ),
			'position'	=> __( 'Position', '@@textdomain' ),
			'attach'	=> __( 'Attachment', '@@textdomain' ),
		);

		return $field_labels;

	}

	/**
	 * Returns the background choices.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_background_choices() {

		$choices = array(
			'repeat' => array(
				'no-repeat' => __( 'No Repeat', '@@textdomain' ),
				'repeat'    => __( 'Tile', '@@textdomain' ),
				'repeat-x'  => __( 'Tile Horizontally', '@@textdomain' ),
				'repeat-y'  => __( 'Tile Vertically', '@@textdomain' ),
			),
			'size' => array(
				'auto'    => __( 'Default', '@@textdomain' ),
				'cover'   => __( 'Cover', '@@textdomain' ),
				'contain' => __( 'Contain', '@@textdomain' ),
			),
			'position' => array(
				'left-top'      => __( 'Left Top', '@@textdomain' ),
				'left-center'   => __( 'Left Center', '@@textdomain' ),
				'left-bottom'   => __( 'Left Bottom', '@@textdomain' ),
				'right-top'     => __( 'Right Top', '@@textdomain' ),
				'right-center'  => __( 'Right Center', '@@textdomain' ),
				'right-bottom'  => __( 'Right Bottom', '@@textdomain' ),
				'center-top'    => __( 'Center Top', '@@textdomain' ),
				'center-center' => __( 'Center Center', '@@textdomain' ),
				'center-bottom' => __( 'Center Bottom', '@@textdomain' ),
			),
			'attach' => array(
				'fixed'   => __( 'Fixed', '@@textdomain' ),
				'scroll'  => __( 'Scroll', '@@textdomain' ),
			),
		);

		return $choices;

	}
}
