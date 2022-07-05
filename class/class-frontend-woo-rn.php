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

    add_action( 'woocommerce_product_meta_end', [$instance,'btn_agregar_como_regalo_func'], 10 );

    add_action( 'template_redirect', [$instance,'procesar_agregar_como_regalo_func'], 10 );

  }

  public function btn_agregar_como_regalo_func(){
    global $post;
    ob_start();
    ?>
    <form action="#" method="post">
      <label>
      <button class="button alt" name="agregar_como_regalo" type="submit"><?php echo __('Agregar como Regalo','woocommerce'); ?></button>
      </label>
      <?php wp_nonce_field( 'seguridad_agregar_como_regalo', 'agregar_regalo' ); ?>
    </form>
    <?php if ( is_user_logged_in() ) { ?>

    <a href="<?php echo get_post_type_archive_link('regalos'); ?>">Ver mi lista de Regalos</a>

    <?php } else { ?>
    <!--<a href="#" title="" rel="home"></a>-->
    <?php } ?>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
  }

  public function procesar_agregar_como_regalo_func(){
    global $post;
    if ( is_product() ){
      $seguridad_regalo = isset($_POST['agregar_regalo']) ? esc_html($_POST['agregar_regalo']) : '';
      $post_regalo = isset($_POST['agregar_como_regalo']) ? true : false;
      if ( is_user_logged_in() ) {

        if($post_regalo !== false):

          if(!wp_verify_nonce( $seguridad_regalo, 'seguridad_agregar_como_regalo' )){
            wc_add_notice( __( 'Envio no seguro.', 'woocommerce' ), 'error' );
          }else{
          /*** ***/

            

          /*** ***/
          }

        endif;

      }else{

        if($post_regalo !== false){
          wc_add_notice( __( 'Debe iniciar sesión para agregar regalo.', 'woocommerce' ), 'error' );
        }

      }
    }
  }

}
