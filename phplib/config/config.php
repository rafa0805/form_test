<?php
ini_set('display_errors', 1);

require(__DIR__ . '/functions.php');
require(__DIR__ . '/autoload.php');
require(__DIR__ . '/data_sets.php');

if ( !file_exists('../db.json' ) ) {
  return;
} else {
  $json_contents = file_get_contents('../db.json');
  $json_data = json_decode( $json_contents, TRUE );
  assert( isset( $json_data['db_server'] ) );
  assert( isset( $json_data['db_user'] ) );
  assert( isset( $json_data['db_password'] ) );
  assert( isset( $json_data['db_name'] ) );
  assert( is_string( $json_data['db_server'] ) );
  assert( is_string( $json_data['db_user'] ) );
  assert( is_string( $json_data['db_password'] ) );
  assert( is_string( $json_data['db_name'] ) );
}

define('DSN', 'mysql:host=' . $json_data['db_server'] . ';dbname=' . $json_data['db_name'] . ';charset=utf8');
define('DB_USERNAME', $json_data['db_user']);
define('DB_PASSWORD', $json_data['db_password']);
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
// define('DSN', 'mysql:host=localhost;dbname=bp;charset=utf8');
// define('DB_USERNAME', 'bp_user');
// define('DB_PASSWORD', 'aaaaaa');
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

session_start();