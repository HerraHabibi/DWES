<?php
  // Función para iniciar sesión
  function login($email, $clave) {
    // Si alguno de los campos esté vacío da error
    if ($email == '' || $clave == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);
  
    // Buscar si existe el cliente
    $cliente = buscarPorEmail($email);
    
    // Si el cliente no existe o no es correcta la contraseña da error
    if (empty($cliente) || $clave != $cliente[0]['idcliente'])
      trigger_error('Login inválido', E_USER_WARNING);

    $cliente = $cliente[0];
  
    // Si el cliente ha sido dado de baja da error
    if ($cliente['fecha_baja'] != null)
      trigger_error('El cliente ha sido dado de baja', E_USER_WARNING);
  
    // Si el cliente tiene pagos pendientes da error
    if ($cliente['pendiente_pago'] > 0)
      trigger_error('El cliente tiene pagos pendientes', E_USER_WARNING);
  
    // Inicia la sesión del cliente
    session_start();
    $_SESSION['usuario'] = $cliente['idcliente'];
  }
?>