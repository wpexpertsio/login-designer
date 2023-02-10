<?php
/**
 * File: functions.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'login_designer_remove_if_empty_array' ) ) {
	/**
	 * Remove if array values are empty.
	 *
	 * @param array $array Array.
	 *
	 * @return array
	 */
	function login_designer_remove_if_empty_array( array $array ) {

		foreach ( $array as $k => $v ) {
			if ( ! empty( trim( $v ) ) ) {
				continue;
			} else {
				unset( $array[ $k ] );
			}
		}

		return $array;
	}
}

if ( ! function_exists( 'login_designer_is_username_error' ) ) {
	/**
	 * Is username or anything else.
	 *
	 * @param string $string Username or else string.
	 *
	 * @return false|mixed
	 */
	function login_designer_is_username_error( $string ) {
		$is_username = strpos( $string, 'username' );
		if ( is_int( $is_username ) ) {
			return $string;
		}
		return false;
	}
}

if ( ! function_exists( 'login_designer_is_password_error' ) ) {
	/**
	 * Is password or anything else.
	 *
	 * @param string $string Password or else string.
	 *
	 * @return false|mixed
	 */
	function login_designer_is_password_error( $string ) {
		$is_password = strpos( $string, 'password' );
		if ( is_int( $is_password ) ) {
			return $string;
		}
		return false;
	}
}

if ( ! function_exists( 'login_designer_is_empty_type' ) ) {
	/**
	 * Is empty Username or Password.
	 *
	 * @param string $string String empty or else.
	 *
	 * @return false|mixed
	 */
	function login_designer_is_empty_type( $string ) {
		$is_empty = strpos( $string, 'empty' );
		if ( is_int( $is_empty ) ) {
			return $string;
		}
		return false;
	}
}

if ( ! function_exists( 'login_designer_password_incorrect' ) ) {
	/**
	 * Is empty Username or Password.
	 *
	 * @param string $string String empty or else.
	 *
	 * @return false|mixed
	 */
	function login_designer_password_incorrect( $string ) {
		$is_empty = strpos( $string, 'incorrect' );
		if ( is_int( $is_empty ) ) {
			return $string;
		}
		return false;
	}
}

if ( ! function_exists( 'login_designer_username_incorrect' ) ) {
	/**
	 * Is empty Username or Password.
	 *
	 * @param string $string String empty or else.
	 *
	 * @return false|mixed
	 */
	function login_designer_username_incorrect( $string ) {
		$is_empty = strpos( $string, 'registered' );
		if ( is_int( $is_empty ) ) {
			return $string;
		}
		return false;
	}
}

if ( ! function_exists( 'login_designer_create_error_messages' ) ) {
	/**
	 * Error generator.
	 *
	 * @param string $title Error title.
	 * @param string $message Error message.
	 *
	 * @return string
	 */
	function login_designer_create_error_messages( $title, $message ) {
		$error_header = '<strong>' . esc_attr( $title ) . '</strong>: ';

		return $error_header . $message;
	}
}

if ( ! function_exists( 'login_designer_wpml_ids' ) ) {
	/**
	 * Login Designer WPML
	 *
	 * @return array
	 */
	function login_designer_wpml_ids( $page_id ) {
		$translations = array();
		$languages    = apply_filters( 'wpml_active_languages', null );
		foreach ( (array) $languages as $k => $language ) {
			$post_id = wpml_object_id_filter( $page_id, 'page', false, $language['code'] );
			if ( null === $post_id ) {
				continue;
			}
			$this_post = get_post( $post_id );
			if ( 'publish' !== $this_post->post_status ) {
				continue;
			}
			$translations[] = $this_post->ID;
		}
		return $translations;
	}
}

if ( ! function_exists( 'login_designer_pages' ) ) {
	/**
	 * Login Designer Pages.
	 *
	 * @param int $login_designer_id Login designer page id.
	 *
	 * @return array
	 */
	function login_designer_pages( $login_designer_id ) {
		$translations = array( $login_designer_id );
		if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
			if ( class_exists( 'Login_Designer_Password_Protected' ) ) {
				$password_protected_page_id = Login_Designer_Password_Protected::get_password_protected_id();
				$translations[]             = $password_protected_page_id;
				$translations               = array_merge( $translations, login_designer_wpml_ids( $password_protected_page_id ) );
			}
			$translations = array_merge( $translations, login_designer_wpml_ids( $login_designer_id ) );
		}
		return $translations;
	}
}

if ( ! function_exists( 'password_protected_get_option' ) ) {
	/**
	 * Getting password protected styles.
	 *
	 * @param string $option_name Option name to get.
	 * @param mixed  $default Default value if option not exist.
	 *
	 * @return mixed
	 */
	function password_protected_get_option( $option_name, $default = false ) {
		$options = get_option( 'password_protected', array() );
		if ( ! isset( $options[ $option_name ] ) ) {
			$options = ( new Login_Designer_Customizer_Output() )->defaults();
			if ( isset( $options[ $option_name ] ) ) {
				return $options[ $option_name ];
			}
			return $default;
		}

		return $options[ $option_name ];
	}
}

if ( ! function_exists( 'login_designer_upload_file_by_url' ) ) {
	/**
	 * Upload file by URL
	 *
	 * @param string $url image file url.
	 * @param string $title Attachment title.
	 *
	 * @return false|int
	 */
	function login_designer_upload_file_by_url( $url, $title = '' ) {
		require_once ABSPATH . '/wp-load.php';
		require_once ABSPATH . '/wp-admin/includes/image.php';
		require_once ABSPATH . '/wp-admin/includes/file.php';
		require_once ABSPATH . '/wp-admin/includes/media.php';

		// Download url to a temp file.
		$tmp = download_url( $url );
		if ( is_wp_error( $tmp ) ) {
			return false;
		}

		// Get the filename and extension ("photo.png" => "photo", "png").
		$filename  = pathinfo( $url, PATHINFO_FILENAME );
		$extension = pathinfo( $url, PATHINFO_EXTENSION );

		// An extension is required or else WordPress will reject the upload.
		if ( ! $extension ) {
			// Look up mime type, example: "/photo.png" -> "image/png".
			$mime = mime_content_type( $tmp );
			$mime = is_string( $mime ) ? sanitize_mime_type( $mime ) : false;

			// Only allow certain mime types because mime types do not always end in a valid extension (see the .doc example below).
			$mime_extensions = array(
				// mime_type         => extension (no period).
				'text/plain'         => 'txt',
				'text/csv'           => 'csv',
				'application/msword' => 'doc',
				'image/jpg'          => 'jpg',
				'image/jpeg'         => 'jpeg',
				'image/gif'          => 'gif',
				'image/png'          => 'png',
				'video/mp4'          => 'mp4',
			);

			if ( isset( $mime_extensions[ $mime ] ) ) {
				// Use the mapped extension.
				$extension = $mime_extensions[ $mime ];
			} else {
				// Could not identify extension.
				wp_delete_file( $tmp );
				return false;
			}
		}

		// Upload by "sideloading": "the same way as an uploaded file is handled by media_handle_upload".
		$args = array(
			'name'     => "$filename.$extension",
			'tmp_name' => $tmp,
		);

		// Do the upload.
		$attachment_id = media_handle_sideload( $args, 0, $title );

		// Cleanup temp file.
		wp_delete_file( $tmp );

		// Error uploading.
		if ( is_wp_error( $attachment_id ) ) {
			return false;
		}

		// Success, return attachment ID (int).
		return (int) $attachment_id;
	}
}
