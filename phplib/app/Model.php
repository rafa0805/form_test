<?php
namespace App;

class Model
{
  protected $db;

  public function __construct()
  {
    try {
      $this->db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
    } catch (\PDOException $e) {
      echo 'データベース接続に失敗しました';
      exit;
    }

  }
}