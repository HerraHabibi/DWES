<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  
  require_once('models/comun_model.php');
  require_once('models/vconsultas_model.php');
  require_once('views/vconsultas_view.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['consultar'])) {
      $reserva = $_POST['reserva'] ?? '';

      limpiar($reserva);
      comprobarVacio($reserva);

      mostrarVuelosReserva($reserva);
    }

    if (isset($_POST['volver']))
      redireccionar('vinicio.php');
  }
?>