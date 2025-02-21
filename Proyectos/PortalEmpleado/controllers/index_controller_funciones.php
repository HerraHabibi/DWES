<?php
  // Función para iniciar sesión
  function login($usuario, $clave) {
    // Buscar si existe el empleado
    $datos = datosEmpleado($usuario);
    
    // Si el empleado no existe o no es correcta la contraseña da error
    if (empty($datos) || $clave != $datos[0]['last_name'])
      trigger_error('Login inválido', E_USER_WARNING);

    $datos = $datos[0];
  
    // Buscar el nombre del departamento
    $departamento = buscarNombreDepartamentoPorUsuario($datos['emp_no']);
    
    // Inicia la sesión del cliente
    session_start();
    $_SESSION['usuario'] = $datos['emp_no'];

    // Define si pertenece o no a recursos humanos
    if ($departamento == 'Human Resources')
      $_SESSION['rrhh'] = true;
    else
      $_SESSION['rrhh'] = false;
  }
?>