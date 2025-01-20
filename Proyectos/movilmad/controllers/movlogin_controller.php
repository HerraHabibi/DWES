<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/movcomun_controller.php');
  
  // En caso de que ya tenga la sesión iniciada redirigir al welcome
  if (isset($_SESSION['usuario'])) {
    redireccionar('views/movwelcome_view.php');
  } else {
    logout();
    // Cargar formulario
    require_once('views/movlogin_view.php');
  }
  
  // Si se hace hace click en "LOGIN"
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['email'];
    $clave = $_POST['password'];
    
    limpiar($correo);
    limpiar($clave);
    
    require_once('models/movlogin_model.php');
    login($correo, $clave);

    redireccionar('views/movwelcome_view.php');
  }
?>