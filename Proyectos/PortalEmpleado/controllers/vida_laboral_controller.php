<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  redireccionarNoRrhh();
  
  require_once('models/vida_laboral_model.php');
  require_once('views/vida_laboral_view.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numEmpleado = $_POST['numEmpleado'] ?? '';

    limpiar($numEmpleado);

    comprobarVacio($numEmpleado);

    if (isset($_POST['datos']))
      mostrarDatosEmpleado($numEmpleado);
    
    else if (isset($_POST['departamentos']))
      mostrarDepartamentosEmpleado($numEmpleado);
    
    else if (isset($_POST['salarios']))
      mostrarSalariosEmpleado($numEmpleado);

    else if (isset($_POST['cargos']))
      mostrarCargosEmpleado($numEmpleado);

    else if (isset($_POST['jefe']))
      mostrarSiEsJefe($numEmpleado);
  }
?>