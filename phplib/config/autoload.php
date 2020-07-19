<?php

spl_autoload_register(function($class) {
  $prefix = 'App\\';
  if (strpos($class, $prefix) === 0) {
    $className = substr($class, strlen($prefix));
    $filePath = __DIR__ . '/../app/' . str_replace('\\', '/', $className . '.php');
  } 
  if (file_exists($filePath)) {
    require $filePath;
  } else {
    echo 'No such class: ' . $class;
    exit;
  }
});