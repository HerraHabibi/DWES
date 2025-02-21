<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  redireccionarNoRrhh();
  
  require_once('models/alta_empleado_model.php');
  require_once('views/alta_empleado_view.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $genero = $_POST['genero'] ?? '';
    $nacimiento = $_POST['nacimiento'];
    $departamento = $_POST['departamento'] ?? '';
    $salario = $_POST['salario'];
    $cargo = $_POST['cargo'];

    limpiar($nombre);
    limpiar($apellidos);
    limpiar($genero);
    limpiar($nacimiento);
    limpiar($departamento);
    limpiar($salario);
    limpiar($cargo);

    comprobarVacio($nombre);
    comprobarVacio($apellidos);
    comprobarVacio($genero);
    comprobarVacio($nacimiento);
    comprobarVacio($departamento);
    comprobarVacio($salario);
    comprobarVacio($cargo);

    $ultimo = ultimoEmpleadoCreado();
    if(!empty($ultimo))
      $numEmpleado = $ultimo[0]['max(emp_no)'] + 1;
    else
      $numEmpleado = 10001;

    $valido = crearEmpleado($numEmpleado, $nacimiento, $nombre, $apellidos, $genero);
    if ($valido) {
      $valido = agregarADepartamento($numEmpleado, $departamento);
      if ($valido) {
        $valido = agregarSalario($numEmpleado, $salario);
        if ($valido)
          $valido = agregarCargo($numEmpleado, $cargo);
      }
    }

    if ($valido)
      echo "Empleado $nombre $apellidos creado correctamente";
    else
      echo "Error al crear el empleado $nombre $apellidos";
  }
?>