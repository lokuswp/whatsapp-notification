<?php

namespace LokusWP;

if ( ! defined( 'WPTEST' ) ) {
	defined( 'ABSPATH' ) or die( "Direct access to files is prohibited" );
}

class Notification_Whatsapp_VendorName extends Notification\Gateway {

	protected string $id = 'notification-whatsapp-vendorname';
	protected string $name = 'Vendor Name';
	protected string $type = 'whatsapp';

	protected array $country = [ 'ID', 'US' ];
	protected array $docs_url = array(
		'id_ID' => 'https://panduan.lokuswp.id/lokuswp/notifikasi/email',
		'en_US' => 'https://guide.lokuswp.com/lokuswp/notification/email',
	);

	/******************************************************************************************/

	public function __construct() {
		$this->setup();

		// Hit : When Notification Scheduler Triggered
		add_action( 'lokuswp/notification/processing', [ $this, 'execute' ] );

		// Action for Save Option and Test
		// add_action( 'wp_ajax_lokuswp_notification_vendorname_test', [ $this, 'action_test' ] );
	}

	/******************************************************************************************/

	/**
	 * Setup Pre Data for New User.
	 * This setup while be called once when first time lokuswp installed
	 *
	 * @return void
	 */
	public function setup() {


		if ( empty( lwp_get_option( $this->id . '-config' ) ) ) {
			$config          = array();
			$config['token'] = null;
			lwp_update_option( $this->id . '-config', $config );
		}

		if ( empty( lwp_get_option( $this->id . '-lwcommerce' ) ) ) {
			$settings = [];
			include LOKUSWP_VENDORNAME_PATH . 'src/includes/channel/notification-whatsapp/default-template-lwcommerce.php';

			$settings['pending']['user']['template']['id_ID']    = $template_pending_for_user;
			$settings['processing']['user']['template']['id_ID'] = $template_processing_for_user;
			$settings['shipped']['user']['template']['id_ID']    = $template_shipped_for_user;
			$settings['completed']['user']['template']['id_ID']  = $template_completed_for_user;
			$settings['cancelled']['user']['template']['id_ID']  = $template_cancelled_for_user;
			lwp_update_option( $this->id . '-lwcommerce', json_encode( $settings ) );
		}

	}

	/**
	 * Reset Data
	 * This method for reset data in database
	 *
	 * @return void
	 */
	public function reset() {
		lwp_update_option( $this->id . '-config', null );
		lwp_update_option( $this->id . '-lwdonation', null );
		$this->setup();
	}

	/******************************************************************************************/

	/**
	 * Getting Notification Data from Database
	 * Login and Function to Get Data
	 *
	 * @param $notification_obj
	 *
	 * @return array
	 */
	public function prepare_data( $notification_obj ) {

		// Notification Data
		$trx_id = abs( $notification_obj->transaction_id );

		$data          = [];
		$data['name']  = lwp_get_transaction_meta( $trx_id, '_user_field_name', true );
		$data['phone'] = lwp_get_transaction_meta( $trx_id, '_user_field_phone', true );
		$data['email'] = lwp_get_transaction_meta( $trx_id, '_user_field_email', true );
		$data['total'] = lwp_currency_format( true, $notification_obj->total, $notification_obj->currency );

		// Get Status based on App
		if ( $notification_obj->app == "lwdonation" ) {
			$data['status']    = lwd_get_report_meta( $trx_id, '_report_status', true );
			$data['report_id'] = lwd_get_report_meta( $trx_id, '_report_id', true );
		} else if ( $notification_obj->app == "lwcommerce" ) {
			$data['status']   = lwc_get_order_meta( $trx_id, '_order_status', true );
			$data['order_id'] = lwc_get_order_meta( $trx_id, '_order_id', true );
		}

		$data['status_text'] = lwp_get_transaction_status_text( $notification_obj->status );

		// Injecting Return with Filter
		return apply_filters( 'lokuswp/notification/whatsapp/vendorname/data', $data, $trx_id );
	}

	/**
	 * Getting Notification Template from Database
	 * based on app\status\role\locale;
	 * e.g lwdonation\pending\user\template\id_ID in DB
	 *
	 * @param $app
	 * @param $status
	 * @param $role
	 * @param $locale
	 *
	 * @return string
	 */
	public function prepare_template( $app, $status, $role, $locale ) {

		$template = json_decode( lwp_get_option( $this->id . '-' . $app ), true );

		return isset( $template[ $status ][ $role ]['template'][ $locale ] ) ? esc_attr( $template[ $status ][ $role ]['template'][ $locale ] ) : null;
	}

	/**
	 * Merge Notification Data with Template
	 * and Return Final Message
	 *
	 * @param $role
	 * @param $notification_obj
	 *
	 * @return array|string|string[]
	 */
	public function templating( $role, $notification_obj ) {

		$locale = lwp_get_locale_by_country( $notification_obj->country ); // id_ID

		// Getting Email Data, based on App
		$data   = $this->prepare_data( $notification_obj );
		$status = $data['status'];
		$total  = lwp_currency_format( true, $notification_obj->total, $notification_obj->currency );

		// Getting Notification Template
		$template = $this->prepare_template( $notification_obj->app, $status, $role, $locale );

		// Dynamic Replacing Tag based on Data, {{tag}} = value
		foreach ( $data as $tag => $value ) {
			$template = str_replace( "{{{$tag}}}", $value, $template );
		}

		$template = str_replace( "{{payment}}", lwp_get_notification_block_payment_text( $locale, $notification_obj ), $template );
		$template = str_replace( "{{summary}}", lwp_get_notification_block_summary_text( $locale, $notification_obj->cart_uuid, $total ), $template );

		// $template = str_replace( "{{billing}}", lwp_get_notification_block_billing_text( $locale, $notification_obj->transaction_id ), $template );

		return $template;
	}

	/******************************************************************************************/

	/**
	 * Execute Notification
	 * based on role
	 *
	 * @param array $notification_obj
	 *
	 * @return void
	 */
	public function execute( array $notification_obj ) {
		$notification_obj = (object) $notification_obj;


		if ( $this->status() && isset( $notification_obj->payment_id ) ) {


			// Get Personal Data
			$trx_id = abs( $notification_obj->transaction_id );
			$phone  = lwp_sanitize_phone( lwp_get_transaction_meta( $trx_id, '_user_field_phone', true ) );

			// Logic : Notification for User
			$user_template = $this->templating( "user", $notification_obj );

			if ( ! empty( $user_template ) && ! empty( $phone ) ) {
				$this->send( array(
					'recipient' => $phone,
					'template'  => $user_template,
				) );
			}

			// Logic : Notification for Admin
			$admin_template = $this->templating( "admin", $notification_obj );
			if ( ! empty( $admin_template ) && ! empty( $phone ) ) {
				$this->send( array(
					'recipient' => $phone,
					'template'  => $admin_template,
				) );
			}

		}
	}

	public function test() {
	}

	/******************************************************************************************/

	/**
	 * Send Message via REST API
	 * Put Your Integration Logic in Here
	 *
	 * @param array $notification
	 *
	 * @return bool
	 */
	public function send( array $notification ): bool {

		$settings = lwp_get_option( $this->id . "-config" );
		$token    = lwp_sanitize( $settings['token'], 'attr' );

		// Send Logic
		try {

			$request = wp_remote_post( 'https://whatsva.id/api/sendMessageText', array(
				'headers' => array( 'Content-Type' => 'application/json' ),
				'body'    => json_encode( [
					'instance_key' => $token,
					'jid'          => $notification['recipient'],
					'message'      => $notification['template']
				] )
			) );

			$response = wp_remote_retrieve_body( $request );


			if ( isset( $response ) && $response === "ok" ) {
				$this->logger( $notification['recipient'], 'Success', $notification['template'] );

				return true;
			}

		} catch ( \Throwable $th ) {
			$this->logger( $notification['recipient'], 'Failed', $response );


		}

		return false;
	}

	/******************************************************************************************/


	/**
	 * Settings Notification in LokusWP
	 * Log, Setup API, etc.
	 *
	 * @return void
	 */
	public function config() {
		if ( file_exists( dirname( __FILE__ ) . '/notification-whatsapp/configuration.php' ) ) {
			require_once dirname( __FILE__ ) . '/notification-whatsapp/configuration.php';
		}
	}

	/**
	 * Manage Notification Template
	 * based on App
	 *
	 * @param string $app
	 *
	 * @return void
	 */
	public function manage_template_notification( string $app ) {
		if ( file_exists( dirname( __FILE__ ) . '/notification-whatsapp/manage-template-' . $app . '.php' ) ) {
			require_once dirname( __FILE__ ) . '/notification-whatsapp/manage-template-' . $app . '.php';
		}
	}

	/******************************************************************************************/

	public function action_test() {
	}

}

Notification\Manager::register( new Notification_Whatsapp_VendorName() );