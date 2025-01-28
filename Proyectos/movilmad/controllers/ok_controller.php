<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/movcomun_controller.php');
  
  comprobarSesion();

  require_once('models/ok_model.php');
  require_once('ok_controller_funciones.php');

  $devolucion = obtenerDatosDevolucion();
  $total = calcularTotal($devolucion);
  
  actualizarAlquiler($devolucion['vehiculo'], $devolucion['fechaDevolucion'], $total);
  actualizarDisponibilidad($devolucion['vehiculo']);

  require_once('views/ok_view.php');
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['volver'])) {
    redireccionar('movwelcome.php');
  }
?>