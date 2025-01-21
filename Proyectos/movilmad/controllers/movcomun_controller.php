<?php
  // Se inicia la sesión
  session_start();

  require_once('movcomun_controller_funciones.php');

  // Se establece el Error handler
  set_error_handler('errores', E_USER_WARNING);
?>