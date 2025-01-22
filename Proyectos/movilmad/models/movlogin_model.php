<?php
  require_once('movcomun_model.php');

  // Función para buscar un cliente en la base de datos por su EMAIL
  function buscarPorEmail($email) {
    $sql = "SELECT *
              FROM rclientes
              WHERE email = :email";
    $args = [':email' => $email];
    
    return operarBd($sql, $args);
  }
?>