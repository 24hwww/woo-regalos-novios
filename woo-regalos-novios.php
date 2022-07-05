<?php
/**
 * Plugin Name: Woo Regalos Novios
 * Plugin URI: https://facebook.com/24hwww
 * Description: Woo Regalos Novios
 * Version: 1.0
 * Author: Leonardo Reyes
 * Author URI: https://github.com/24hwww
 * Developer: 24hwww
 * Developer URI: https://facebook.com/24hwww
 * Text Domain: woo-regalos-novios
**/

defined( 'ABSPATH' ) or die( 'Prohibido acceso directo.' );

define('WC_RN_BASE', plugin_basename( __FILE__ ));
define('WC_RN_BASE_SLASH', plugin_dir_path( __FILE__ ));
define('WC_RN_BASE_URL', plugin_dir_url( __FILE__ ));
define('WC_RN_BASE_PATH', dirname(__FILE__));
define('WC_RN_DOMAIN', 'woo-regalos-novios');
define('WC_RN_TITLE', 'Woo Regalos Novios');
define('WC_RN_VERSION', '1.0');

add_action('admin_init', function(){
	if ( !class_exists( 'WooCommerce' ) ):
		deactivate_plugins( WC_RN_BASE );
		if ( isset( $_GET['activate'] ) ){
		unset( $_GET['activate'] );
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		add_action( 'admin_notices', function(){
			$class = 'notice notice-error';
			$message = __( 'No se puede activar el plugin: '.WC_RN_TITLE.', debe estar activado el WooCommerce.' );
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
		});
		return;
		}
	endif;
});

if (!class_exists('Class_Backend_Woo_RN')) {
	require_once WC_RN_BASE_PATH . '/class/class-backend-woo-rn.php';
	add_action( 'plugins_loaded', [ 'Class_Backend_Woo_RN', 'init' ]);
}
if (!class_exists('Class_Frontend_Woo_RN')) {
	require_once WC_RN_BASE_PATH . '/class/class-frontend-woo-rn.php';
	add_action( 'plugins_loaded', [ 'Class_Frontend_Woo_RN', 'init' ]);
}
