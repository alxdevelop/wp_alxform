<?php 
/*
Plugin Name: wp_alxform
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
    add_menu_page("AlxForm", "AlxForm", 'manage_options', "alxform-settings", "alxForm_admin");
});


function wp_alxform_admin()
{
  include("admin_template.php");
}

