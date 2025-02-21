<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  redireccionarNoRrhh();
  
  require_once('models/info_departamentos_model.php');
  require_once('views/info_departamentos_view.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codDept = $_POST['codDept'] ?? '';

    limpiar($codDept);

    comprobarVacio($codDept);

    mostrarInfoDept($codDept);
  }
?>