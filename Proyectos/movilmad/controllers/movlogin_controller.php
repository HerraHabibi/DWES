<?php
  require_once('models/movlogin_model.php');
  require_once('controllers/movcomun_controller.php');
  require_once('views/movlogin_view.php');

  // ------------------------------------------------------------------------------------------------
  // ------------------------------------- LLAMADAS A FUNCIONES -------------------------------------
  // ------------------------------------------------------------------------------------------------

  // En caso de que ya tenga la sesión iniciada redirigir al welcome
  if (isset($_SESSION['usuario'])) {
    redireccionar('views/movwelcome_view.php');
  } else {
    logout();
  }

  // Si se hace hace click en "LOGIN"
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['email'];
    $clave = $_POST['password'];

    limpiar($correo);
    limpiar($clave);

    login($correo, $clave);
    redireccionar('views/movwelcome_view.php');
  }

  // ------------------------------------------------------------------------------------------------
  // ----------------------------------- DECLARACIÓN DE FUNCIONES -----------------------------------
  // ------------------------------------------------------------------------------------------------

  // Función para iniciar sesión
  function login($email, $clave) {
    // Si alguno de los campos esté vacío da error
    if ($email == '' || $clave == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);

    // Buscar si existe el cliente
    $cliente = buscarEmail($email);
    
    // Si el cliente no existe o no es correcta la contraseña da error
    if (empty($cliente) || $clave != $cliente['idcliente'])
      trigger_error('Login inválido', E_USER_WARNING);

    // Si el cliente ha sido dado de baja da error
    if ($cliente['fecha_baja'] != null)
      trigger_error('El cliente ha sido dado de baja', E_USER_WARNING);

    // Si el cliente tiene pagos pendientes da error
    if ($cliente['pendiente_pago'] > 0)
      trigger_error('El cliente tiene pagos pendientes', E_USER_WARNING);

    // Inicia la sesión del cliente
    session_start();
    $_SESSION['usuario'] = $cliente[0]['idcliente'];
  }
  
?>