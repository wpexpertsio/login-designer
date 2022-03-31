<?php
/**
 * Class: Login_Designer_Features
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Login_Designer_Features' ) ) {
	/**
	 * Class Login_Designer_Features
	 */
	class Login_Designer_Features {
		/**
		 * Login_Designer_Features constructor.
		 */
		public function __construct() {
			/**
			 * Translation Field actions.
			 */
			add_action( 'login_head', array( $this, 'add_translation_styles' ) );
			$login_designer = get_option( 'login_designer', array( 'template' => 'default' ) );
			if ( isset( $login_designer['template'] ) && 'default' !== $login_designer['template'] ) {
				add_action( 'login_footer', array( $this, 'translation_field' ) );
			}
			add_action( 'login_footer', array( $this, 'hide_customizer_elements' ) );
		}

		/**
		 * Adding translation styles in login head
		 */
		public function add_translation_styles() {
			echo '<style type="text/css">';
			$translation_parameters = get_option( 'login_designer_translations', false );
			if ( $translation_parameters ) {
				$translation = $translation_parameters['translation'];
				if ( $translation ) {
					echo '.language-switcher { display:block !important; }';
				} else {
					echo '.language-switcher { display: none !important; }';

				}
			}
			echo '</style>';
		}

		/**
		 * Hiding login designer customizer elements.
		 */
		public function hide_customizer_elements() {
			echo '<script type="text/javascript">';
			if ( is_customize_preview() ) {
				$login_designer = get_option( 'login_designer_translations', false );
				if ( $login_designer ) {
					if ( $login_designer['translation'] ) {
						echo "let login_designer_template = jQuery( '#login-designer-template' ).text();
                            if ( 'default' === login_designer_template ) {
                                jQuery( '.login-designer--translation-switcher[data-logindesigner-template=template]' ).attr( 'style', 'display: none !important;position:relative;' );
                                jQuery( '.login-designer--translation-switcher[data-logindesigner-template=default]' ).attr( 'style', 'display: block !important;position:relative;' );
                            }
                            if ( 'default' !== login_designer_template ) {
                                jQuery( '.login-designer--translation-switcher[data-logindesigner-template=default]' ).attr( 'style', 'display: none !important;position:relative;' );
                                jQuery( '.login-designer--translation-switcher[data-logindesigner-template=template]' ).attr( 'style', 'display: block !important;position:relative;' );
                            }";
					} else {
						echo "jQuery( 'body' ).addClass( 'login-designer-no-language' );";
					}
				}
			}
			echo '</script>';
		}

		/**
		 * Display element on right way.
		 */
		public function translation_field() {
			$js = <<<JS
                let language_translator=jQuery(".language-switcher").html(),embed_html="<div class='language-switcher'>"+language_translator+"</div>";jQuery(".language-switcher").remove(),jQuery("#login").append(embed_html);
JS;
			wp_add_inline_script( 'jquery', trim( $js ) );
			wp_enqueue_script( 'jquery' );
		}
	}
}

new Login_Designer_Features();
