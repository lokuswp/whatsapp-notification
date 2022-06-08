<?php

namespace LokusWP\Notification\Fonnte;

class Boot {

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'loaded' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'load_assets' ] );

		// Activation and Deactivation
		register_activation_hook( LOKUSWP_FONNTE_BASE, [ $this, 'activate' ] );
		register_deactivation_hook( LOKUSWP_FONNTE_BASE, [ $this, 'deactivate' ] );
	}

	/**
	 * Load Activation Class when Plugin is Active
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function activate() {
		require_once LOKUSWP_FONNTE_PATH . 'src/includes/common/class-activation.php';
		Activation::activate();
	}

	/**
	 * Load Deactivation Class when Plugin is Active
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function deactivate() {
		require_once LOKUSWP_FONNTE_PATH . 'src/includes/common/class-deactivation.php';
		Deactivation::deactivate();
	}


	/**
	 * Load Notification Class
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function loaded() {

		require_once dirname( __DIR__ ) . '/src/includes/channel/class-notification-whatsapp.php';
	}

	/**
	 * Load Notification Assets
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function load_assets() {

	}
}

new Boot();