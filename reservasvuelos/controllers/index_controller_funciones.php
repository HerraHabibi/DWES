<?php
  // Función para iniciar sesión
  function login($usuario, $clave) {
    // Buscar si existe el empleado
    $datos = datosCliente($usuario);
    
    // Si el empleado no existe o no es correcta la contraseña da error
    if (empty($datos) || $clave != substr($datos[0]['dni'], 0, 4))
      trigger_error('Login inválido', E_USER_WARNING);

    // Inicia la sesión del cliente
    session_start();
    $_SESSION['usuario'] = $datos[0]['email'];
  }
?>