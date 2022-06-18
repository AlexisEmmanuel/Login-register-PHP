<?php
require_once 'routes.php';
try {
  $conn = new PDO('mysql:server='.DBSERVER.';dbname='.DBNAME.';', DBUSER, DBPASS);
  // echo 'ok'; // if credentials are correct this write the text to validate
} catch (PDOException $event) {
  echo 'Error: '.$event->getMessage();
}