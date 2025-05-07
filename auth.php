<?php
require_once __DIR__.'/init.php';
if(!isset($_SESSION['user'])){
  header('Location: login.php');
  exit;
}