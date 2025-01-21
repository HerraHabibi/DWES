<?php
  require_once('movcomun_model.php');

  // ------------------------------------------------------------------------------------------------
  // ----------------------------------- DECLARACIÓN DE FUNCIONES -----------------------------------
  // ------------------------------------------------------------------------------------------------

  // Función para buscar un cliente en la base de datos por su EMAIL
  function buscarEmail($email) {
    $sql = "SELECT *
              FROM rclientes
              WHERE email = :email";
    $args = [':email' => $email];
    
    return operarBd($sql, $args)[0];
  }
?>