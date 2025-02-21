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
  
  // Función para comprobar si un campo esta vacio
  function comprobarVacio($valor) {
    if ($valor == '')
      trigger_error('Campo obligatorio no rellenado', E_USER_WARNING);
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
    echo datosEmpleado($_SESSION['usuario'])[0]['first_name'] . ' ' . datosEmpleado($_SESSION['usuario'])[0]['last_name'];
  }

  // Función que devuelve TRUE si el usuario pertenece RRHH y sino devuelve FALSE
  function esRrhh() {
    $esRrhh = false;

    if ($_SESSION['rrhh'] == true)
      $esRrhh = true;

    return $esRrhh;
  }

  // Función para comprobar si el usuario pertenece a RRHH, sino lo redirige al menu
  function redireccionarNoRrhh() {
    if(!esRrhh())
      redireccionar('menu.php');
  }
?>