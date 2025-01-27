<?php
  // Función para obtener los datos de la devolución en un array
  function obtenerDatosDevolucion() {
    return unserialize($_COOKIE['devolucion']);
  }

  function calcularTotal($devolucion) {
    return $devolucion['tiempoAlquiler'] * obtenerInfoVehiculo($devolucion['vehiculo'])['preciobase'];
  }

  function mostrarMarcaVehiculo($vehiculo) {
    echo obtenerInfoVehiculo($vehiculo)['marca'];
  }

  function mostrarModeloVehiculo($vehiculo) {
    echo obtenerInfoVehiculo($vehiculo)['modelo'];
  }

  function mostrarTiempoAlquiler($tiempoAlquiler) {
    echo $tiempoAlquiler . ' min.';
  }

  function mostrarPrecioBase($vehiculo) {
    echo obtenerInfoVehiculo($vehiculo)['preciobase'] . ' €';
  }

  function mostrarPrecioTotal($total) {
    echo $total . ' €';
  }

  // Función para borrar la cookie de la devolución
  function borrarCookieDevolucion() {
    setcookie('devolucion', '', time() - 3600, '/');
  }
?>