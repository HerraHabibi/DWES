<?php
  // Función para agregar un empleado a la cookie de los empleados que se van a insertar
  function agregarEmpleado(&$empleadosCreados, $nombre, $apellidos, $genero, $nacimiento, $departamento, $salario, $cargo) {
    // Si existe la cookie de los empleados la pasamos a array, sino creamos un array vacío
    $empleadosCreados = isset($_COOKIE['empleadosCreados']) ? unserialize($_COOKIE['empleadosCreados']) : array();
    
    // Creamos el array de empleados del usuario si es que no existe
    if (!isset($empleadosCreados[$_SESSION['usuario']]))
      $empleadosCreados[$_SESSION['usuario']] = array();

    // Agregamos el empleado al array
    $empleadosCreados[$_SESSION['usuario']][] = array(
      'nombre' => $nombre,
      'apellidos' => $apellidos,
      'genero' => $genero,
      'nacimiento' => $nacimiento,
      'departamento' => $departamento,
      'salario' => $salario,
      'cargo' => $cargo
    );
    
    // Pasar el array de los empleados a cookie
    setcookie('empleadosCreados', serialize($empleadosCreados), time() + (10 * 365 * 24 * 60 * 60), '/');
  }

  // Función para vaciar la cookie de los empleados
  function vaciarEmpleadosCreados() {
    $empleadosCreados = isset($_COOKIE['empleadosCreados']) ? unserialize($_COOKIE['empleadosCreados']) : array();

    if (isset($empleadosCreados[$_SESSION['usuario']])) {
      unset($empleadosCreados[$_SESSION['usuario']]);
      if (!empty($empleadosCreados))
        setcookie('empleadosCreados', serialize($empleadosCreados), time() + (10 * 365 * 24 * 60 * 60), '/');
      else
        setcookie('empleadosCreados', '', time() - 3600, '/');
    }
  }

  // Función para eliminar un empleado de la cookie del usuario
  function eliminarEmpleadoDeCookie($empleadoCreado) {
    $empleadosCreados = unserialize($_COOKIE['empleadosCreados']);
    $empleadosCreados = $empleadosCreados[$_SESSION['usuario']];

    unset($empleadosCreados[array_search($empleadoCreado, $empleadosCreados)]);
    setcookie('empleadosCreados', serialize($empleadosCreados), time() + (10 * 365 * 24 * 60 * 60), '/');
  }
?>