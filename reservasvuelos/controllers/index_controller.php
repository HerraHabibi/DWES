<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  // En caso de que ya tenga la sesión iniciada redirigir al menu
  if (isset($_SESSION['usuario'])) {
    redireccionar('vinicio.php');
  } else {
    logout();
    // Cargar formulario
    require_once('views/index_view.php');
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['password'];
    
    limpiar($usuario);
    limpiar($clave);
    
    require_once('models/comun_model.php');
    require_once('index_controller_funciones.php');

    comprobarVacio($usuario);
    comprobarVacio($clave);

    login($usuario, $clave);

    redireccionar('vinicio.php');
  }
?>