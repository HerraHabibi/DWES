<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  
  require_once('models/comun_model.php');
  require_once('views/vinicio_view.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reservar']))
      redireccionar('vreservas.php');

    else if (isset($_POST['consultar']))
      redireccionar('vconsultas.php');

    else if (isset($_POST['salir'])) {
      logout();
      redireccionar('.');
    }
  }
?>