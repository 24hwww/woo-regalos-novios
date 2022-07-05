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

    add_action( 'template_include', [$instance,'plantilla_lista_regalos_func'], 10 );

    add_shortcode( 'form_buscar_regalos', [$instance,'form_buscar_regalos_func']);

  }

  public function btn_agregar_como_regalo_func(){
    global $post;
    $current_user_id = get_current_user_id();

    $url_lista_regalos = add_query_arg( array(
        'usuario' => $current_user_id,
    ), get_post_type_archive_link('regalos') );


    ob_start();
    ?>
    <form action="#" method="post">
      <label>
      <button class="button alt" name="agregar_como_regalo" type="submit"><?php echo __('Agregar como Regalo','woocommerce'); ?></button>
      </label>
      <?php wp_nonce_field( 'seguridad_agregar_como_regalo', 'agregar_regalo' ); ?>
    </form>
    <?php if ( is_user_logged_in() ) { ?>

    <a href="<?php echo $url_lista_regalos; ?>">Ver mi lista de Regalos</a>

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
          $current_user_id = get_current_user_id();
          $product_id = $post->ID;

          $producto_title = wp_strip_all_tags( get_the_title($product_id) );

          $regalos = get_posts( array(
            'post_type' => 'regalos',
            'post_status' => 'publish',
            'numberposts' => -1,
            'post_author' => $current_user_id
          ));

          // $args_regalos = array(
          //   'post_title'    => $producto_title,
          //   'post_content'  => '',
          //   'post_status'   => 'publish',
          //   'post_author'   => $current_user_id,
          //   'post_type' => 'regalos'
          // );
          //
          // $regalo_id = wp_insert_post($args_regalos);
          // if(!is_wp_error($regalo_id)){
          //
          //   wc_add_notice( __( 'Producto: '.$producto_title. ' agregado como regalo!', 'woocommerce' ), 'success' );
          //   update_post_meta($regalo_id, '_producto_regalo_id', $product_id );
          //
          // }else{
          //   wc_add_notice( __( $regalo_id->get_error_message(), 'woocommerce' ), 'error' );
          // }

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

  public function plantilla_lista_regalos_func($original_template){
    if(is_post_type_archive('regalos')) {
      return plugin_dir_path(__DIR__) . 'templates/archive-regalos.php';
    }
    return $original_template;
  }

  public function form_buscar_regalos_func(){
    // $url_lista_regalos = add_query_arg( array(
    //     'usuario' => $current_user_id,
    // ), get_post_type_archive_link('regalos') );
    $url_lista_regalos = get_post_type_archive_link('regalos');
    ob_start();
    ?>

    <form method="POST">

    </form>

    <?php
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
  }

}
