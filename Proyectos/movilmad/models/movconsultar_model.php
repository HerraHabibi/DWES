<?php
  require_once('movcomun_model.php');

  function obtenerAlquileresFecha($idcliente, $desde, $hasta) {
    $sql = "SELECT matricula, fecha_alquiler, fecha_devolucion, preciototal, fechahorapago
              FROM ralquileres
              WHERE idcliente = :idcliente AND fecha_alquiler BETWEEN :desde AND :hasta";
    $args = [':idcliente' => $idcliente, ':desde' => $desde, ':hasta' => $hasta];
    
    return operarBd($sql, $args);
  }
?>