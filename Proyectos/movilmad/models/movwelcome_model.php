<?php
  require_once('movcomun_model.php');

  // Función para buscar el nombre de un cliente en la base de datos por su ID
  function buscarNombre($idCliente) {
    $sql = "SELECT nombre
              FROM rclientes
              WHERE idcliente = :idcliente";
    $args = [':idcliente' => $idCliente];
    
    return operarBd($sql, $args)[0]['nombre'];
  }
?>