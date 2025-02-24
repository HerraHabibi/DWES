<?php
  // Función para obtener las reservas hechas por un cliente
  function obtenerReservas($dni) {
    $sql = "SELECT DISTINCT id_reserva
              FROM reservas
              WHERE dni_cliente = :dni_cliente";
    $args = [':dni_cliente' => $dni];

    return operarBd($sql, $args);
  }

  // Función para obtener los datos de los vuelos de una reserva
  function datosVuelosReserva($reserva) {
    $sql = "SELECT aerolineas.nombre_aerolinea nombre_aerolinea, vuelos.origen origen, vuelos.destino destino, vuelos.fechahorasalida fechahorasalida, vuelos.fechahorallegada fechahorallegada, reservas.num_asientos num_asientos
              FROM reservas
              JOIN vuelos ON vuelos.id_vuelo = reservas.id_vuelo
              JOIN aerolineas ON aerolineas.id_aerolinea = vuelos.id_aerolinea
              WHERE id_reserva = :id_reserva";
    $args = [':id_reserva' => $reserva];

    return operarBd($sql, $args);
  }
?>