<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  // En caso de que ya tenga la sesión iniciada redirigir al menu
  if (isset($_SESSION['usuario'])) {
    redireccionar('menu.php');
  } else {
    logout();
    // Cargar formulario
    require_once('views/index_view.php');
  }
  
  // Si se hace hace click en "LOGIN"
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    
    limpiar($usuario);
    limpiar($clave);
    
    require_once('models/comun_model.php');
    require_once('models/index_model.php');
    require_once('index_controller_funciones.php');

    comprobarVacio($usuario);
    comprobarVacio($clave);

    login($usuario, $clave);

    redireccionar('menu.php');
  }
?>