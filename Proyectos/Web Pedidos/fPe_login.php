<?php
  // Limpia los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  // Iniciar sesión
  function login($usuario, $clave) {
    // Convierte la cookie de intentos en array asociativo, si no existe crea un array vacío
    $intentos = isset($_COOKIE['intentos']) ? unserialize($_COOKIE['intentos']) : array();

    // Si el usuario ha intentado 3 veces o da error
    if (isset($intentos[$usuario]) && $intentos[$usuario] >= 3)
      trigger_error('Has excedido el número de intentos', E_USER_WARNING);

    // Si alguno de los campos esté vacío da error
    if ($usuario == '' || $clave == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);

    // Busca si existe el usuario
    $cliente = buscarUsuario($usuario);
    
    // Si el usuario no existe da error
    if (empty($cliente))
      trigger_error('El usuario no existe', E_USER_WARNING);

    // Comprueba la contraseña
    comprobarLogin($cliente, $usuario, $clave, $intentos);
    
    /* ---------------- */
    /* Usuario correcto */
    /* ---------------- */

    // Si el usuario tiene intentos fallidos los elimina
    if (isset($intentos[$usuario])) {
      unset($intentos[$usuario]);
      var_dump($intentos);
      // Convierte el array en cookie y la almacena
      setcookie('intentos', serialize($intentos), time() + 60, '/');
    }

    // Inicia la sesión del usuario
    session_start();
    
    $_SESSION['usuario'] = $usuario;
    $_SESSION['clave'] = $clave;
  }

  // Busca si existe un usuario igual al introducido y devuelve: el nombre de usuario, el apellido (clave de los usuarios ya creados) y la clave encriptada
  function buscarUsuario($usuario) {
    $sql = "SELECT CustomerNumber, ContactLastName, claveEncriptada
              FROM Customers
              WHERE CustomerNumber = :usuario";
    $args = [':usuario' => $usuario];
    
    return operarBd($sql, $args);
  }

  // Comprueba la contraseña del usuario introducido
  function comprobarLogin($cliente, $usuario, $clave, $intentos) {
        // Comprueba si la contraseña que utiliza es una clave no encriptada y si no es correcta da error
    if (($cliente[0]['claveEncriptada'] == null && $clave != $cliente[0]['ContactLastName']) ||
        // Comprueba si la contraseña que utiliza es una clave encriptada y si no es correcta da error
        ($cliente[0]['claveEncriptada'] != null && $clave != $cliente[0]['claveEncriptada'])) {
          
          // Si el usuario ya tiene intentos previos se le incrementa en 1, sino se le asigna 1
          $intentos[$usuario] = isset($intentos[$usuario]) ? $intentos[$usuario] + 1 : 1;
          var_dump($intentos);
          // Convierte el array en cookie y la almacena
          setcookie('intentos', serialize($intentos), time() + 60, '/');

          trigger_error('Login inválido', E_USER_WARNING);
    }
  }

  // Borra la sesión y recarga la página
  function logout() {
    // Elimina la cookie asociada a la sesión
    setcookie(session_name(), '', time() - 3600, '/');
    // Elimina variables de sesión
    session_unset();
    // Elimina la sesión
    session_destroy();
  }

  function redireccionar($pagina) {
    header('Location: ' . $pagina);
    exit;
  }
?>