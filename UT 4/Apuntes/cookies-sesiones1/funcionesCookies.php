<?php
  // Si existe el usuario el usuario logeado se crean las cookies y se recarga la página, sino muestra un error
  function login($usuario, $pass) {
    $resultado = buscarUsuario($usuario, $pass);
    
    if (empty($resultado))
      trigger_error('Login inválido', E_USER_WARNING);

    setcookie('usuario', $usuario, time() + (86400 * 30), '/');
    setcookie('pass', $pass, time() + (86400 * 30), '/');

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }

  // Busca si existe un usuario con el nombre y contraseña introducidos y lo devuelve
  function buscarUsuario($usuario, $pass) {
    $sql = "SELECT usuario, pass
              FROM usuarios
              WHERE usuario = '$usuario' AND pass = '$pass'";
    
    return operarBd($sql);
  }

  // Borra las cookies de usuario y contraseña y recarga la página
  function logout() {
    setcookie('usuario', '', time() - 3600, '/');
    setcookie('pass', '', time() - 3600, '/');
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
  }
?>