<?php
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  function login($usuario, $clave) {
    $cliente = buscarUsuario($usuario);
    
    if (empty($cliente) || !password_verify($clave, $cliente[0]['clave']))
      trigger_error('Login inválido', E_USER_WARNING);
    
    session_start();
    
    $_SESSION['usuario'] = $usuario;
    $_SESSION['clave'] = $clave;

    header('Location: menu.php');
    exit;
  }

  // Busca si existe un usuario igual al introducido y lo devuelve
  function buscarUsuario($usuario) {
    $sql = "SELECT usuario, clave
              FROM cliente
              WHERE usuario = :usuario";
    $args = [':usuario' => $usuario];
    
    return operarBd($sql, $args);
  }

  if (isset($_POST['logout']) && $_POST['logout'] === 'true') {
    logout();
  }

  // Borra la sesión y recarga la página
  function logout() {
    session_start();
    // Elimina la cookie asociada a la sesión
    setcookie(session_name(), '', time() - 3600, '/');
    // Elimina variables de sesión
    session_unset();
    // Elimina la sesión
    session_destroy();
    
    header('Location: comlogincli.php');
    exit;
  }
?>