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

  //insertamos valores por default si es que no existen
  if(!isset($email_exist->nombre))
  {
    $wpdb->insert($table_name, array('nombre'=>'email','valor' => "$email_admin"));
  }
  if(!isset($url_exist->nombre))
  {
    $wpdb->insert($table_name, array('nombre'=>'url','valor' => ''));
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
	if(count($_POST) > 0){

    $alxform_email = trim($_POST['alxform_email']);
    $alxform_url = trim($_POST['alxform_url']);
    $wpdb->query("UPDATE $table_name SET valor = '$alxform_email' WHERE nombre = 'email'");
    $wpdb->query("UPDATE $table_name SET valor = '$alxform_url' WHERE nombre = 'url'");
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
      }

    }  

  include("admin_template.php");
}


function showForm()
{

    if(count($_POST))
    {
      global $wpdb;
      $table_name = $wpdb->prefix . "alxform_config";
      $info = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
      $email_to = $info->email;
      $url_to = $info->url;

      wp_mail($email_to, "Formulario", "hola mundo");

    }

  include('form.php');
}

add_shortcode('wp_alxform','showForm');

