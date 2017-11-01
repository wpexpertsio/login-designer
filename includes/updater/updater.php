<?php
/**
 * EDD Theme Updater
 *
 * @package @@pkg.name
 * @version @@pkg.version
 * @author  @@pkg.author
 * @license @@pkg.license
 */

// Test license: f9ab6970486b10c4092bd2df0f6e1afa

$updater = new EDD_Theme_Updater_Admin(

	$config = array(
		'remote_api_url'    => 'https://themebeans.com',
		'item_name'         => 'York Pro',
		'theme_slug'        => 'york-pro',
		'version'           => '1.0.0',
		'author'            => 'ThemeBeans',
		'download_id'       => '105665',
		'renew_url'         => '',
	),
	$strings = array(
		'license-unknown'           => esc_html__( 'Unknown license. Please contact support at support@themebeans.com and we will sort this out for you.' , '@@textdomain' ),
		'theme-license'             => esc_html__( 'Activate your theme license.', '@@textdomain' ),
		'enter-key'                 => wp_kses( __( 'Add your license key to get theme updates without leaving your dashboard and to access support. Locate your license key in your ThemeBeans account dashboard and on your purchase receipt.<br><br>Enter your license key below:', '@@textdomain' ), array( 'br' => array() ) ),
		'license-key'               => esc_html__( 'License Key', '@@textdomain' ),
		'license-action'            => esc_html__( 'License Action', '@@textdomain' ),
		'enter-license-label'       => esc_html__( '', '@@textdomain' ),
		'deactivate-license'        => esc_html__( 'Deactivate License', '@@textdomain' ),
		'reload-button'             => esc_html__( 'Reload', '@@textdomain' ),
		'activate-license'          => esc_html__( 'Activate License', '@@textdomain' ),
		'reactivate-button'         => esc_html__( 'Reactivate License', '@@textdomain' ),
		'status-unknown'            => esc_html__( 'License status is unknown.', '@@textdomain' ),
		'renew'                     => esc_html__( 'renew your theme license.', '@@textdomain' ),
		'renew-after'               => esc_html__( 'After completing the renewal, click the Reload button below.', '@@textdomain' ),
		'renew-button'              => esc_html__( 'Renew your License &rarr;', '@@textdomain' ),
		'unlimited'                 => esc_html__( 'unlimited', '@@textdomain' ),
		'license-key-is-active%s'   => esc_html__( 'Seamless theme updates and support has been enabled for %s. You will receive a notice in your dashboard when an update is available.', '@@textdomain' ),
		'expires%s'                 => esc_html__( '', '@@textdomain' ),
		'%1$s/%2$-sites'            => esc_html__( 'You have %1$s / %2$s sites activated.', '@@textdomain' ),
		'license-key-expired-%s'    => esc_html__( 'Your license key expired on %s. In order to access support and seamless updates, you need to', '@@textdomain' ),
		'license-key-expired'       => esc_html__( 'License key has expired.', '@@textdomain' ),
		'license-keys-do-not-match' => esc_html__( 'This is not a valid license key. Please try again.', '@@textdomain' ),
		'license-is-inactive'       => esc_html__( 'License is inactive.', '@@textdomain' ),
		'license-key-is-disabled'   => esc_html__( 'License key is disabled.', '@@textdomain' ),
		'site-is-inactive'          => esc_html__( 'Site is inactive.', '@@textdomain' ),
		'license-status-unknown'    => esc_html__( 'License status is unknown.', '@@textdomain' ),
		'update-notice'             => esc_html__( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", '@@textdomain' ),
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" title="%4s" target="blank">Check out what\'s new</a> or <a href="%5$s" %6$s>update now</a>', '@@textdomain' ),
	)
);
