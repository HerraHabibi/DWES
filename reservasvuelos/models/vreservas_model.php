<?php
  // Función para obtener los vuelos disponibles
  function datosVuelosDisponibles() {
    $sql = "SELECT *
              FROM vuelos
              WHERE asientos_disponibles > 0";
    
    return operarBd($sql);
  }

  // Función para obtener todos los datos de un vuelo
  function datosVuelo($vuelo) {
    $sql = "SELECT vuelos.origen origen, vuelos.destino destino, vuelos.fechahorasalida fechahorasalida, vuelos.fechahorallegada fechahorallegada, aerolineas.nombre_aerolinea nombre_aerolinea, vuelos.precio_asiento precio_asiento, vuelos.asientos_disponibles asientos_disponibles
              FROM vuelos
              JOIN aerolineas ON aerolineas.id_aerolinea = vuelos.id_aerolinea
              WHERE id_vuelo = :id_vuelo";
    $args = [':id_vuelo' => $vuelo];

    return operarBd($sql, $args)[0];
  }

  // Función para obtener el ultimo id de reserva
  function obtenerUltIdReserva() {
    $sql = "SELECT id_reserva
              FROM reservas
              ORDER BY 1 DESC
              LIMIT 1";
    
    return operarBd($sql)[0]['id_reserva'];
  }

  // Función para añadir una reserva
  function anadirReserva($idReserva, $vuelo, $dni, $asientos, $precio) {
    $sql = "INSERT INTO reservas (id_reserva, id_vuelo, dni_cliente, fecha_reserva, num_asientos, preciototal)
              VALUES (:id_reserva, :id_vuelo, :dni_cliente, NOW(), :num_asientos, :preciototal)";
    $args = [':id_reserva' => $idReserva, ':id_vuelo' => $vuelo, ':dni_cliente' => $dni, ':num_asientos' => $asientos, ':preciototal' => $precio];
  
    return operarBd($sql, $args);
  }

  // Función para ocupar los asientos de un vuelo
  function ocuparAsientos($vuelo, $asientos) {
    $sql = "UPDATE vuelos
              SET asientos_disponibles = asientos_disponibles - :asientos
              WHERE id_vuelo = :id_vuelo";
    $args = [':asientos' => $asientos, ':id_vuelo' => $vuelo];
  
    return operarBd($sql, $args);
  }
?>