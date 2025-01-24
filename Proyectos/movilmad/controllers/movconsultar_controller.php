<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/movcomun_controller.php');
  
  comprobarSesion();

  require_once('models/movconsultar_model.php');
  require_once('movconsultar_controller_funciones.php');
  
  require_once('views/movconsultar_view.php');
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['consultar'])) {
    $desde = $_POST['fechadesde'];
    $hasta = $_POST['fechahasta'];

    limpiar($desde);
    limpiar($hasta);

    comprobarFechas($desde, $hasta);
    compararFechas($desde, $hasta);

    $desde = $desde . ' 00:00:00';
    $hasta = $hasta . ' 23:59:59';

    $alquileres = obtenerAlquileresFecha($_SESSION['usuario'], $desde, $hasta);
    mostrarAlquileres($alquileres);
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['volver'])) {
    redireccionar('movwelcome.php');
  }
?>