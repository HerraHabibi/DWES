<?php
  // Archivo de configuración de la BBDD
  require_once 'movconfig.php';

  // Conexión con la BBDD
  $dbServer = DB_SERVER;
  $dbName = DB_DATABASE;
  $dbUsername = DB_USERNAME;
  $dbPassword = DB_PASSWORD;

  try {
    $conexion = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword); 	 	 	 	 	 	
    $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 	 	 	 	 	 	
  } catch (PDOException $error) {
    echo $error->getMessage();	 	 	 	 	
  }
?>