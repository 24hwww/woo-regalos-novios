<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Class_Backend_Woo_RN{
  private static $_instance = null;
	public $id_menu = '';

  public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
  public function __construct() {
		$this->id_menu = 'regalos-novios';
    register_activation_hook( __FILE__, function(){
      add_role( 'novios', 'Novios', get_role( 'customer' )->capabilities );
      flush_rewrite_rules();
    });
  }

  public static function init() {
    $instance = self::instance();

    add_action( 'init', [$instance,'agregar_cpt_regalos_func']);

  }

  public function agregar_cpt_regalos_func(){
        register_post_type('regalos',
            array(
                'labels'      => array(
                    'name'          => __( 'Regalos', '' ),
                    'singular_name' => __( 'Regalos', '' ),
                ),
                'public'      => true,
                'has_archive' => 'regalos',
                'menu_icon'   => 'dashicons-buddicons-tracking',
                'rewrite'     => array( 'slug' => 'regalo' ),
            )
        );

  }

}
