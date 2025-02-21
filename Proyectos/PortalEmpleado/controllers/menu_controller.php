<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  require_once('models/comun_model.php');
  require_once('views/menu_view.php');
?>