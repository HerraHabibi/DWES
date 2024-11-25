<?php
  // Busca si existe un usuario con el nombre y contraseña introducidos, si existe se crean las cookies y se recarga la página, sino muestra un error
  function logearse($usuario, $pass) {
    $sql = "SELECT usuario, pass
              FROM usuarios
              WHERE usuario = '$usuario' AND pass = '$pass'";
    $resultado = operarBd($sql);
    
    if (empty($resultado))
      trigger_error('Login inválido', E_USER_WARNING);

    setcookie('usuario', $usuario, time() + (86400 * 30), '/');
    setcookie('pass', $pass, time() + (86400 * 30), '/');

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }

  // Borra las cookies de usuario y contraseña y recarga la página
  function deslogearse() {
    setcookie('usuario', '', time() - 3600, '/');
    setcookie('pass', '', time() - 3600, '/');
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
  }
?>