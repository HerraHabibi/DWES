<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  redireccionarNoRrhh();
  
  require_once('models/modificar_salario_model.php');
  require_once('modificar_salario_controller_funciones.php');
  require_once('views/modificar_salario_view.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numEmpleado = $_POST['numEmpleado'] ?? '';
    $salario = $_POST['salario'];

    limpiar($numEmpleado);
    limpiar($salario);

    comprobarVacio($numEmpleado);
    comprobarVacio($salario);

    comprobarMismoDia($numEmpleado);
    comprobarMismoSalario($numEmpleado, $salario);

    $valido = modificarSalarioAntiguo($numEmpleado);
    if ($valido)
      $valido = asignarNuevoSalario($numEmpleado, $salario);

    if ($valido)
      echo "Se ha modificado el salario del empleado $numEmpleado correctamente";
    else
      echo "Error al modificar el salario del empleado $numEmpleado";
  }
?>