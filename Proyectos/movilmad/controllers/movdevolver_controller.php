<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/movcomun_controller.php');
  
  comprobarSesion();

  require_once('models/movdevolver_model.php');
  require_once('movdevolver_controller_funciones.php');
  
  require_once('views/movdevolver_view.php');
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['devolver'])) {
    $vehiculo = isset($_POST['vehiculos']) ? $_POST['vehiculos'] : '';

    comprobarVehiculo($vehiculo);

    $precioBase = obtenerPrecioBase($vehiculo);
    $fechaDevolucion = calcularFechaDevolucion();
    $tiempoAlquiler = obtenerTiempoAlquiler($vehiculo);
    $tiempoAlquiler = arreglarTiempoAlquiler($tiempoAlquiler);
    $precio = calcularPrecioAlquiler($precioBase, $tiempoAlquiler);
    
    almacenarDevolucion($vehiculo, $fechaDevolucion, $tiempoAlquiler);

    require_once('apiRedsys.php');
    pasarelaPago($precio);
  };
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['volver'])) {
    redireccionar('movwelcome.php');
  }
?>