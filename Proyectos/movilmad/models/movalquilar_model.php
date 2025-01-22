<?php
  require_once('movcomun_model.php');

  // Función para obtener todos los vehículos disponibles
  function obtenerVehiculosDisponibles() {
    $sql = "SELECT matricula, marca, modelo
              FROM rvehiculos
              WHERE disponible = 'S'";
    
    return operarBd($sql);
  }

  // Función para obtener la disponibilidad de un vehículo por su matrícula
  function obtenerDisponibilidadVehiculo($matricula) {
    $sql = "SELECT disponible
              FROM rvehiculos
              WHERE matricula = :matricula";
    $args = [':matricula' => $matricula];
    
    return operarBd($sql, $args)[0]['disponible'];
  }

  // Función para obtener la marca y el modelo de un vehículo por su matrícula
  function obtenerInfoVehiculo($matricula) {
    $sql = "SELECT marca, modelo
              FROM rvehiculos
              WHERE matricula = :matricula";
    $args = [':matricula' => $matricula];
    
    return operarBd($sql, $args)[0];
  }

  // Función para obtener los vehículos alquilados por un usuario
  function obtenerVehiculosAlquiladosPorUsuario($idCliente) {
    $sql = "SELECT matricula
              FROM ralquileres
              WHERE idcliente = :idcliente AND fecha_devolucion IS NULL";
    $args = [':idcliente' => $idCliente];
    
    return operarBd($sql, $args);
  }

  function insertarAlquilarVehiculo($idCliente, $matricula) {
    $sql = "INSERT INTO ralquileres (idcliente, matricula, fecha_alquiler, fecha_devolucion, preciototal, fechahorapago)
              VALUES (:idcliente, :matricula, NOW(), NULL, NULL, NULL)";
    $args = [':idcliente' => $idCliente, ':matricula' => $matricula];
    
    return operarBd($sql, $args);
  }

  function cambiarDisponibilidadVehiculo($matricula, $disponible) {
    $sql = "UPDATE rvehiculos
              SET disponible = :disponible
              WHERE matricula = :matricula";
    $args = [':matricula' => $matricula, ':disponible' => $disponible];
    
    return operarBd($sql, $args);
  }
?>