<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Class_Frontend_Woo_RN{
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
  }

  public static function init() {
    $instance = self::instance();
  }

}
