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