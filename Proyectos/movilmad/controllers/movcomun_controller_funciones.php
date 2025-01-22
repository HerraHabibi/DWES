<?php
  // Función para indicar por pantalla los posibles errores que ocurran
  function errores($errno, $errstr) {
    echo "<strong>ERROR:</strong> $errstr <br>";
    die();
  }

  // Función para redirigir a otra página
  function redireccionar($pagina) {
    header('Location: ' . $pagina);
    exit;
  }

  // Función para cerrar sesión
  function logout() {
    setcookie(session_name(), '', time() - 3600, '/');
    session_unset();
    session_destroy();
  }

  // Función para limpiar los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  // Función para comprobar si hay un usuario logueado, sino lo redirige al login
  function comprobarSesion() {
    if(!isset($_SESSION['usuario'])) {
      logout();
      redireccionar('.');
    }
  }

  // Función para mostrar el nombre del cliente
  function mostrarNombre() {
    echo obtenerNombre($_SESSION['usuario']);
  }
?>