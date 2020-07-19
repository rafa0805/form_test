<?php

require(__DIR__ . '/../config/config.php');

$app = new \App\Controller\IndexController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $res = $app->post();
    header('Content-Type: application/json');
    echo json_encode($res);
    exit;
  } catch (Exception $e) {
    header($SERVER['SERVER_PROTCOL']. '500 Internal Server Error', true, 500);
    echo $e->getMessage();
    exit;
  }
}