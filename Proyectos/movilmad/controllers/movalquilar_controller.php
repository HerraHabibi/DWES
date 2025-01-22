<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/movcomun_controller.php');
  
  comprobarSesion();

  require_once('models/movalquilar_model.php');
  require_once('movalquilar_controller_funciones.php');
  
  require_once('views/movalquilar_view.php');
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $cesta = array();

    agregarACesta($cesta);
    mostrarCesta($cesta[$_SESSION['usuario']]);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['alquilar'])) {
    alquilarVehiculos();
    // select matricula from ralquileres where fecha_alquiler > '2025-01-22 11:00:00';
    // delete from ralquileres where fecha_alquiler > '2025-01-22 11:00:00';
    // update rvehiculos set disponible = 'S' where matricula = 'MATRICULA';
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['vaciar'])) {
    vaciarCesta();
    echo 'Se vació la cesta <br>';
  }
?>