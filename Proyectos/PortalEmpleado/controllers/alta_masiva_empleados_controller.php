<?php
  // Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
  require_once('controllers/comun_controller.php');
  
  comprobarSesion();
  redireccionarNoRrhh();
  
  require_once('models/alta_empleado_model.php');
  require_once('models/alta_masiva_empleados_model.php');
  require_once('alta_masiva_empleados_controller_funciones.php');
  require_once('views/alta_masiva_empleados_view.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
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

    $empleadosCreados = array();
    agregarEmpleado($empleadosCreados, $nombre, $apellidos, $genero, $nacimiento, $departamento, $salario, $cargo);
    mostrarEmpleadosAgregados($empleadosCreados);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['anadir'])) {
    $empleadosCreados = isset($_COOKIE['empleadosCreados']) ? unserialize($_COOKIE['empleadosCreados']) : array();
    $empleadosCreados = isset($empleadosCreados[$_SESSION['usuario']]) ? $empleadosCreados[$_SESSION['usuario']] : array();

    if(empty($empleadosCreados))
      echo 'Aún no has agregado ningún empleado';
    else {
      $ultimo = ultimoEmpleadoCreado();
      if(!empty($ultimo))
        $numEmpleado = $ultimo[0]['max(emp_no)'] + 1;
      else
        $numEmpleado = 10001;
    
      foreach ($empleadosCreados as $empleadoCreado) {
        $valido = crearEmpleado($numEmpleado, $empleadoCreado['nacimiento'], $empleadoCreado['nombre'], $empleadoCreado['apellidos'], $empleadoCreado['genero']);
        if ($valido) {
          $valido = agregarADepartamento($numEmpleado, $empleadoCreado['departamento']);
            if ($valido) {
              $valido = agregarSalario($numEmpleado, $empleadoCreado['salario']);
              if ($valido)
                $valido = agregarCargo($numEmpleado, $empleadoCreado['cargo']);
            }
        }
        
        if ($valido) {
          echo 'Empleado ' . $empleadoCreado['nombre'] . ' ' . $empleadoCreado['apellidos'] . ' creado correctamente <br>';
          $numEmpleado++;
          eliminarEmpleadoDeCookie($empleadoCreado);
        }
        else
          echo 'Error al crear el empleado ' . $empleadoCreado['nombre'] . ' ' . $empleadoCreado['apellidos'] . '<br>';
      }

      vaciarEmpleadosCreados();
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ver'])) {
    $empleadosCreados = isset($_COOKIE['empleadosCreados']) ? unserialize($_COOKIE['empleadosCreados']) : array();
    mostrarEmpleadosAgregados($empleadosCreados);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrar'])) {
    vaciarEmpleadosCreados();
    echo 'Empleados eliminados';
  }
?>