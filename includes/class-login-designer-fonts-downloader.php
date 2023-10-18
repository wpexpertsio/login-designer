<?php
/**
 * Login Designer Fonts Downloader
 *
 * @package Login Deisnger
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Login_Designer_Fonts_Downloader' ) ) {
	/**
	 * Login Designer Fonts Downloader
	 */
	class Login_Designer_Fonts_Downloader {
		/**
		 * Fonts URL.
		 *
		 * @var string $fonts_url The fonts url.
		 */
		private $fonts_url = '';

		/**
		 * Font families.
		 *
		 * @var $font_families
		 */
		private $font_families;

		/**
		 * Font styles.
		 *
		 * @var $font_styles
		 */
		private $font_styles;

		/**
		 * Constructor
		 *
		 * @param string $fonts_url The fonts url.
		 */
		public function __construct( $fonts_url ) {
			$this->fonts_url = $fonts_url;
		}

		/**
		 * Get font families
		 *
		 * @return Login_Designer_Fonts_Downloader
		 */
		private function get_font_families() {
			preg_match( '/family=([^&]+)/', $this->fonts_url, $matches );
			$families = $matches[1];
			$families = str_replace( '%20', ' ', $families );
			$families = str_replace( '%7C', '|', $families );

			$this->font_families = explode( '|', $families );

			return $this;
		}

		/**
		 * Get font styles
		 *
		 * @return $this
		 */
		private function get_font_styles() {
			$fonts_url = str_replace( '%20', ' ', $this->fonts_url );
			$fonts_url = str_replace( '%7C', '|', $fonts_url );
			preg_match( '/\:(.+)\&/', $fonts_url, $matches );
			$this->font_styles = str_replace( array( ':', '//', '/', '?', '=', '&' ), '-', $matches[1] );
			$this->font_styles = strtolower( $this->font_styles );
			$this->font_styles = str_replace( '-fonts.googleapis.com-css-family-', '', $this->font_styles );
			$this->font_styles = explode( '|', $this->font_styles );
			return $this;
		}

		/**
		 * Collect font styles.
		 *
		 * @param string $css Google fonts css.
		 *
		 * @return array
		 */
		private function collect_font_styles( $css ) {
			$urls = array();
			preg_match_all( '/src: url\((.+)\) format\(\'truetype\'\)|format\(\'woff2\'\);/', $css, $matches );
			$new_urls = $matches[1];

			foreach ( $new_urls as $url ) {
				foreach ( $this->font_styles as $font_style ) {
					$font_style_match = str_replace( ' ', '', $font_style );
					if ( strpos( $url, $font_style_match ) ) {
						$urls[ $font_style ] = $url;
						continue;
					}
				}
			}

			return $urls;
		}

		/**
		 * Arrange css array.
		 *
		 * @param array $matches Matches.
		 *
		 * @return array
		 */
		private function arrange_css_array( $matches ) {
			$css_array = array();
			foreach ( $matches as $match ) {
				$css_array[ str_replace( ' ', '', strtolower( $match[1] ) ) ] = array(
					'font-family' => $match[1],
					'font-style'  => $match[2],
					'font-weight' => $match[3],
				);
			}
			return $css_array;
		}

		/**
		 * Generate css.
		 *
		 * @param array $css_array CSS array.
		 *
		 * @return string
		 */
		private function generate_css( $css_array ) {
			$css = '';
			foreach ( $css_array as $font_family => $font ) {
				$css .= '@font-face {';
				$css .= 'font-family: \'' . $font['font-family'] . '\';';
				$css .= 'font-style: ' . $font['font-style'] . ';';
				$css .= 'font-weight: ' . $font['font-weight'] . ';';
				$css .= 'src: ' . $font['src'] . ';';
				$css .= '}';
			}
			return $css;
		}

		/**
		 * Download fonts
		 */
		public function download_fonts() {
			$login_designer_filesystem = Login_Designer_File_System::get_instance();
			$this->get_font_families();
			$this->get_font_styles();

			$css  = $login_designer_filesystem->get_content( $this->fonts_url );
			$urls = $this->collect_font_styles( $css );

			preg_match_all( '/font-family: \'(.*?)\'.*?font-style: (.*?);.*?font-weight: (\d+)/s', $css, $matches, PREG_SET_ORDER );

			$css_array = $this->arrange_css_array( $matches );

			foreach ( $urls as $file_name => $url ) {
				$content   = $login_designer_filesystem->get_content( $url );
				$file_path = $login_designer_filesystem->mkdir( 'fonts' )->put_content( 'fonts/' . str_replace( ' ', '', $file_name ) . '.ttf', $content, false, true );

				$css_array[ strtolower( str_replace( ' ', '', $file_name ) ) ]['src'] = 'url(' . $file_path['baseurl'] . ') format(\'truetype\')';
			}

			$css = $this->generate_css( $css_array );

			$css_file = $login_designer_filesystem->mkdir( 'css' )->put_content( 'css/fonts.css', $css, false, true );

			return $css_file['baseurl'];
		}
	}
}
