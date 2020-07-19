<?php
namespace App;

class Controller
{
  private $_values;

  public function __construct() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    $this->_values = new \stdClass;
  }

  protected function set_values($key, $value) {
    $this->_values->$key = $value;
  }

  protected function get_values($key) {
    return $this->_values->$key;
  }
  
}