<?php 
/*
Plugin Name: AlxForm
Plugin URI:
Description: Formulario de contacto
Author: @alxdevelop
Version: 0.1
Author URI:
*/


global $alxform_db_version;
$alxform_db_version = "0.1";


function wp_alxform_install()
{
  global $wpdb;
  global $alxform_db_version;
  //obtenemos la version de la DB instalada
  $installed_ver = get_option("alxform_db_version");

  add_option("alxform_db_version", $alxform_db_version);


  if($installed_ver != $alxform_db_version)
  {

    //nombre de la tabla
    $table_name = $wpdb->prefix . "alxform_config";
    
    //sql para crear tabla
    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      nombre varchar(99) NOT NULL,
      valor varchar(300) NOT NULL,
      PRIMARY KEY (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);

    update_option("alxform_db_version", $alxform_db_version);
  
  }


    
}



function wp_alxform_install_data()
{
  global $wpdb;
  $table_name = $wpdb->prefix . "alxform_config";

  //add the admin email
  $email_admin = get_option('admin_email');

  //validamos que no existan esos campos
  $email_exist = $wpdb->get_row("SELECT * FROM $table_name WHERE nombre = 'email'");
  $url_exist = $wpdb->get_row("SELECT * FROM $table_name WHERE nombre = 'url'");
  $title_exist = $wpdb->get_row("SELECT * FROM $table_name WHERE nombre = 'title'");
  $button_exist = $wpdb->get_row("SELECT * FROM $table_name WHERE nombre = 'button'");

  //insertamos valores por default si es que no existen
  if(!isset($email_exist->nombre))
  {
    $wpdb->insert($table_name, array('nombre'=>'email','valor' => "$email_admin"));
  }
  if(!isset($url_exist->nombre))
  {
    $wpdb->insert($table_name, array('nombre'=>'url','valor' => ''));
  }
  if(!isset($title_exist->nombre))
  {
    $wpdb->insert($table_name, array('nombre'=>'title','valor' => 'Contactanos'));
  }
  if(!isset($button_exist->nombre))
  {
    $wpdb->insert($table_name, array('nombre'=>'button','valor' => 'Enviar'));
  }


}

register_activation_hook(__FILE__,'wp_alxform_install');
register_activation_hook(__FILE__,'wp_alxform_install_data');


add_action('admin_menu', 
  function(){
    add_menu_page("AlxForm", "AlxForm", 'manage_options', "alxform-settings", "wp_alxform_admin");
});


function wp_alxform_admin()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "alxform_config";
    $alxform_email = "";
    $alxform_url = "";
    $alxform_title = "";
    $alxform_button = "";
	if(count($_POST) > 0){

    $alxform_email = trim($_POST['alxform_email']);
    $alxform_url = trim($_POST['alxform_url']);
    $alxform_title = trim($_POST['alxform_title']);
    $alxform_button = trim($_POST['alxform_button']);
    $wpdb->query("UPDATE $table_name SET valor = '$alxform_email' WHERE nombre = 'email'");
    $wpdb->query("UPDATE $table_name SET valor = '$alxform_url' WHERE nombre = 'url'");
    $wpdb->query("UPDATE $table_name SET valor = '$alxform_title' WHERE nombre = 'title'");
    $wpdb->query("UPDATE $table_name SET valor = '$alxform_button' WHERE nombre = 'button'");
		echo "<div class='updated'><p><strong>Configuración guardada</strong></p></div>";
	}else {  
    
    $config = $wpdb->get_results("SELECT * FROM $table_name");

      foreach($config as $conf)
      {
        if($conf->nombre == 'email')
        {
          $alxform_email = $conf->valor;  
        }
        else if($conf->nombre == 'url')
        {
          $alxform_url = $conf->valor;
        }
        else if($conf->nombre == 'title')
        {
          $alxform_title = $conf->valor;
        }
        else if($conf->nombre == 'button')
        {
          $alxform_button = $conf->valor;
        }
      }

    }  

  include("admin_template.php");
}


function showForm()
{

  //agregamos los estilos CSS 
  wp_register_style('alxform_css_frontend',plugins_url('wp_alxform/css/alxform_front.css'));
  wp_enqueue_style('alxform_css_frontend');

  //agregamos los JS
  wp_register_script('alxform_js_frontend',plugins_url('wp_alxform/js/alxform_form.js'));
  wp_enqueue_script('alxform_js_frontend',array('jquery'));

    global $wpdb;
    $table_name = $wpdb->prefix . "alxform_config";

    //obtenemos el valor del titulo
    $title = $wpdb->get_row("SELECT valor FROM $table_name WHERE nombre = 'title'");
    if($title == ''){ 
      $title = 'Contacto';
    }else{
      $title = $title->valor;
    }

    //obtenemos el valor del texto del boton
    $button = $wpdb->get_row("SELECT valor FROM $table_name WHERE nombre = 'button'");
    if($button == ''){ 
      $button = 'Enviar';
    }else{
      $button = $button->valor;
    }

    if(count($_POST))
    {
      $info = $wpdb->get_results("SELECT * FROM $table_name");
      //var_dump($info);
      foreach ($info as $data) {
        if($data->nombre == 'email')
        {
          $email_to = $data->valor;
        }
        else if($data->nombre == 'url')
        {
          $url_to = $data->valor;
        }
      }

      wp_mail($email_to, "Formulario", "hola mundo");


    }

  include('form.php');
}

add_shortcode('wp_alxform','showForm');

include_once dirname(__FILE__) . '/alxform_widget.php';
