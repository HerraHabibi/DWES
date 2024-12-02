<?php
  // Si existe el usuario el usuario logeado se crea la sesión y se recarga la página, sino muestra un error
  function login($usuario, $pass) {
    $resultado = buscarUsuario($usuario, $pass);
    
    if (empty($resultado))
      trigger_error('Login inválido', E_USER_WARNING);

    $_SESSION["usuario"] = $usuario;
    $_SESSION["pass"] = $pass;

    // Se inicia la sesión
    session_start();
  }

  // Busca si existe un usuario con el nombre y contraseña introducidos y lo devuelve
  function buscarUsuario($usuario, $pass) {
    $sql = "SELECT usuario, pass
              FROM usuarios
              WHERE usuario = '$usuario' AND pass = '$pass'";
    
    return operarBd($sql);
  }

  // Borra la sesión y recarga la página
  function logout() {
    // Elimina la cookie asociada a la sesión
    setcookie(session_name(), '', time() - 3600, '/');
    // Elimina variables de sesión
    session_unset();
    // Elimina la sesión
    session_destroy();
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
  }
?>