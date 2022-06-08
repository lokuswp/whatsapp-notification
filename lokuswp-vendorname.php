<?php

/**
 * @wordpress-plugin
 * @lokuswp-integration
 *
 * Plugin Name:       ☠️ LokusWP 🤝 VendorName
 * Plugin URI:        https://vendorname.com/lokuswp
 * Description:       Whatsapp Notification for LokusWP
 * Version:           0.0.1
 * Author:            VendorName
 * Author URI:        https://vendorname.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Languages:         id_ID
 */

// Checking Test Env and Direct Access File
if ( ! defined( 'WPTEST' ) ) {
	defined( 'ABSPATH' ) or die( "Direct access to files is prohibited" );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 * Define Constant
 */
defined( 'LOKUSWP_VENDORNAME_VERSION' ) or define( 'LOKUSWP_VENDORNAME_VERSION', '0.0.1' );
defined( 'LOKUSWP_VENDORNAME_BASE' ) or define( 'LOKUSWP_VENDORNAME_BASE', plugin_basename( __FILE__ ) );
defined( 'LOKUSWP_VENDORNAME_PATH' ) or define( 'LOKUSWP_VENDORNAME_PATH', plugin_dir_path( __FILE__ ) );
defined( 'LOKUSWP_VENDORNAME_URI' ) or define( 'LOKUSWP_VENDORNAME_URI', plugin_dir_url( __FILE__ ) );

/**
 * Dependency Backbone Checking
 *
 * @return void
 */
function lwp_vendorname_dependency() {
	$lwp_active  = true;
	$lwp_version = true;

	// is LokusWP Active ??
	if ( is_admin() && current_user_can( 'activate_plugins' ) && ! is_plugin_active( 'lokuswp/lokuswp.php' ) ) {

		add_action( 'admin_notices', function () {
			echo '<div class="error"><p>' . __( 'LokusWP required. please activate plugin first.', 'lokuswp-vendorname' ) . '</p></div>';
		} );

		$lwp_active = false;
	}

	// Checking LokusWP Version to Run this Plugin
	$lwp_version = get_plugin_data( dirname( dirname( __FILE__ ) ) . '/lokuswp/lokuswp.php' );
	$lwp_version = $lwp_version['Version'] ?? false;
	if ( ! version_compare( LOKUSWP_VENDORNAME_VERSION, $lwp_version, '<' ) ) {

		add_action( 'admin_notices', function () use ( $lwp_version ) {
			$message      = sprintf( esc_html__( 'LokusWP Fonnte anda tidak kompatibel dengan versi LokusWP Backbone saat ini, silahkan gunakan LokusWP Fonnte v%s atau dibawahnya', 'lokuswp-vendorname' ),
				$lwp_version );
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		} );

		$lwp_version = false;
	}

	// When not Right -> Deactivate Extension
	if ( ! $lwp_version || ! $lwp_active ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}

add_action( 'admin_init', 'lwp_vendorname_dependency' );

// Run LokusWP Fonnte
if ( in_array( 'lokuswp/lokuswp.php', (array) apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once dirname( __DIR__ ) . '/lokuswp-vendorname/src/autoload.php';
}