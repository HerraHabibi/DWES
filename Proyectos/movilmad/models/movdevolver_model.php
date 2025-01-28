<?php
  require_once('movcomun_model.php');

  // Función para obtener los vehículos alquilados actuales por un cliente
  function obtenerVehiculosAlquiladosCliente($idcliente) {
    $sql = "SELECT rvehiculos.matricula, rvehiculos.marca, rvehiculos.modelo
              FROM rvehiculos
              JOIN ralquileres
                ON rvehiculos.matricula = ralquileres.matricula
              WHERE ralquileres.idcliente = :idcliente
                AND ralquileres.fecha_devolucion IS NULL";
    $args = [':idcliente' => $idcliente];

    return operarBd($sql, $args);
  }

  // Función para obtener la fecha de devolución de un vehículo
  function obtenerHoraDevolucion() {
    $sql = "SELECT NOW() AS fecha_devolucion";

    return operarBd($sql)[0]['fecha_devolucion'];
  }

  // Función para obtener el tiempo de alquiler de un vehículo
  function obtenerTiempoAlquiler($matricula) {
    $sql = "SELECT TIMESTAMPDIFF(MINUTE, fecha_alquiler, NOW()) AS tiempo_alquiler
              FROM ralquileres
              WHERE matricula = :matricula
                AND fecha_devolucion IS NULL";
    $args = [':matricula' => $matricula];

    return operarBd($sql, $args)[0]['tiempo_alquiler'];
  }

  // Función para obtener el precio base de un vehículo
  function obtenerPrecioBase($vehiculo) {
    $sql = "SELECT preciobase
              FROM rvehiculos
              WHERE matricula = :matricula";
    $args = [':matricula' => $vehiculo];

    return operarBd($sql, $args)[0]['preciobase'];
  }
?>