<?php 
/*
Plugin Name: AlxForm
Plugin URI:
Description: Formulario de contacto
Author: @alxdevelop
Version: 0.1
Author URI:
*/

global $db_version;
$db_version = "0.1";

function wp_alxform_install()
{
  global $wpdb;

  $version_db = get_option('db_version');

  add_option("db_version", $db_version);

  if($version_db != $db_version)
  {
    $table = $wpdb->prefix . "alxform_config";

    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      email varchar(99) NOT NULL,
      url varchar(300) NOT NULL,
      PRIMARY KEY (id)
    );";

    if(!function_exists('dbDelta'))
    {
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }

    dbDelta($sql);

    update_option("db_version", $db_version);
    
  }

}

register_activation_hook(__FILE__,'wp_alxform_install');


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
    $wpdb->query("UPDATE $table_name SET email = '$alxform_email', url = '$alxform_url' WHERE id = 1");
		echo "<div class='updated'><p><strong>Configuración guardada</strong></p></div>";
	}else {  
    $rows = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
    $alxform_email = $rows->email;
    $alxform_url = $rows->url;
    }  

  include("admin_template.php");
}

