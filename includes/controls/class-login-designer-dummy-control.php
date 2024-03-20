<?php
/**
 * File: class-login-designer-dummy-control.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

if ( ! class_exists( 'Login_Designer_Dummy_Control' ) ) {
	/**
	 * Class Login_Designer_Dummy_Control
	 */
	class Login_Designer_Dummy_Control extends WP_Customize_Control {
		/**
		 * Login Designer dummy control.
		 *
		 * @var string
		 */
		public $type = 'login-designer-dummy-control';

		/**
		 * Login Designer image src
		 *
		 * @var string
		 */
		public $image_src;

		/**
		 * Converting custom attributes to json
		 */
		public function to_json() {
			parent::to_json();

			$this->json['image_src'] = $this->image_src;
		}

		/**
		 * Render Content
		 */
		public function render_content() {}

		/**
		 * Content Template
		 *
		 * @throws Freemius_Exception Exception.
		 */
		protected function content_template() {
			$purchase_url = 'https://logindesigner.com/pricing/?utm_source=plugin&utm_medium=customizer';
			?>
			<a draggable="false" href="<?php echo esc_url( $purchase_url ); ?>" style="font-size: 17px;" target="_blank">
				<?php esc_attr_e( 'Upgrade To Pro', 'login-designer' ); ?>
				<i style="vertical-align: baseline;width: auto;height: auto;" class="dashicons dashicons-external"></i>
				<img style="margin-top: 10px" draggable="false" src="{{ data.image_src }}" alt="#">
			</a>
			<?php
		}
	}
}
