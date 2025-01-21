<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/movcomun_controller.php');
  
  comprobarSesion();
  require_once('models/movwelcome_model.php');
  require_once('views/movwelcome_view.php');
?>