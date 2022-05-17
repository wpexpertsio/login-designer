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
		$error_footer = "<br />\r\n";

		return $error_header . $message . $error_footer;
	}
}

if ( ! function_exists( 'login_designer_wpml_ids' ) ) {
	/**
	 * Login Designer WPML
	 *
	 * @return array
	 */
	function login_designer_wpml_ids() {
		$translations = array();
		$languages    = apply_filters( 'wpml_active_languages', null );
		foreach ( (array) $languages as $k => $language ) {
			$post_id = wpml_object_id_filter( Login_Designer()->get_login_designer_page()->ID, 'page', false, $language['code'] );
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
			$translations = array_merge( $translations, login_designer_wpml_ids() );
		}
		return $translations;
	}
}
