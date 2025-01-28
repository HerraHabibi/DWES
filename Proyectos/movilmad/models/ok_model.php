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

  // Función para actualizar los datos del alquiler
  function actualizarAlquiler($matricula, $fechaDevolucion, $precioTotal) {
    $sql = "UPDATE ralquileres
              SET fecha_devolucion = :fecha_devolucion, preciototal = :preciototal, fechahorapago = NOW()
              WHERE matricula = :matricula AND fecha_devolucion IS NULL";
    $args = [':fecha_devolucion' => $fechaDevolucion, ':preciototal' => $precioTotal, ':matricula' => $matricula];

    operarBd($sql, $args);
  }

  // Función para actualizar la disponibilidad de un vehículo
  function actualizarDisponibilidad($matricula) {
    $sql = "UPDATE rvehiculos
              SET disponible = 'S'
              WHERE matricula = :matricula";
    $args = [':matricula' => $matricula];

    operarBd($sql, $args);
  }
?>