<?php
  require_once('movcomun_model.php');
  
  // Función para obtener información del vehiculo por su matricula
  function obtenerInfoVehiculo($matricula) {
    $sql = "SELECT marca, modelo, preciobase
              FROM rvehiculos
              WHERE matricula = :matricula";
    $args = [':matricula' => $matricula];

    return operarBd($sql, $args)[0];
  }

  // Función para actualizar la fecha de devolución de un vehículo
  function actualizarFechaDevolucion($matricula) {
    $sql = "UPDATE ralquileres
              SET fecha_devolucion = NOW(), 
              WHERE matricula = :matricula";
    $args = [':matricula' => $matricula];

    operarBd($sql, $args);
  }

  // Función para actualizar la disponibilidad de un vehículo
?>