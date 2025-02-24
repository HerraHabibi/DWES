<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  
  require_once('models/comun_model.php');
  require_once('vreservas_controller_funciones.php');
  require_once('models/vreservas_model.php');
  require_once('views/vreservas_view.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ver'])) {
      $vuelosAgregados = isset($_COOKIE['vuelosAgregados']) ? unserialize($_COOKIE['vuelosAgregados']) : array();
      mostrarVuelosAgregados($vuelosAgregados);
    }

    if (isset($_POST['agregar'])) {
      $vuelo = $_POST['vuelos'] ?? '';
      $asientos = $_POST['asientos'];

      limpiar($vuelo);
      limpiar($asientos);

      comprobarVacio($vuelo);
      comprobarVacio($asientos);

      $vuelosAgregados = array();
      agregarVuelo($vuelosAgregados, $vuelo, $asientos);
      mostrarVuelosAgregados($vuelosAgregados);
    }

    if (isset($_POST['comprar'])) {
      comprobarAsientosDisponibles();
      $precioTotal = hacerReserva();
      vaciarVuelos();
      echo 'Se han pagado los vuelos correctamente. Precio total: ' . $precioTotal . '€';
    }

    if (isset($_POST['vaciar'])) {
      vaciarVuelos();
      echo 'Se han eliminado los vuelos agregados';
    }

    if (isset($_POST['volver']))
      redireccionar('vinicio.php');
  }
?>