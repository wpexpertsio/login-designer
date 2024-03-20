<?php
/**
 * Freemius SDK
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'ld_fs' ) ) {
	/**
	 * Create a helper function for easy SDK access.
	 *
	 * @return Freemius The Freemius SDK.
	 * @throws Freemius_Exception Throws Freemius Exception.
	 */
	function ld_fs() {
		global $ld_fs;

		if ( ! isset( $ld_fs ) ) {
			// Include Freemius SDK.
			require_once __DIR__ . '/freemius/start.php';

			$ld_fs = fs_dynamic_init(
				array(
					'id'             => '11442',
					'slug'           => 'login-designer',
					'type'           => 'plugin',
					'public_key'     => 'pk_8ce3c04198a7961c26bba01883213',
					'is_premium'     => false,
//					'has_addons'     => true,
					'has_paid_plans' => false,
					'menu'           => array(
						'slug'       => 'login-designer',
						'first-path' => 'themes.php?page=login-designer',
						'contact'    => false,
						'support'    => false,
						'parent'     => array(
							'slug' => 'themes.php',
						),
					),
				)
			);
		}

		return $ld_fs;
	}

	// Init Freemius.
	ld_fs();
	// Signal that SDK was initiated.
	do_action( 'ld_fs_loaded' );
}
