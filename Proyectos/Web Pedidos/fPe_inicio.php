<?php
  // Limpia los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }


  function obtenerNombreCliente() {
    $cliente = consultarNombreCliente();
    echo $cliente['contactFirstName'] . ' ' . $cliente['contactLastName'];
  }

  function consultarNombreCliente() {
    $sql = "SELECT contactFirstName, contactLastName
            FROM customers
            WHERE customerNumber = :customerNumber";
    $args = [':customerNumber' => $_SESSION['usuario']];

    return operarBd($sql, $args)[0];
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

  // Redirecciona a la página pasada por parámetros
  function redireccionar($pagina) {
    header('Location: ' . $pagina);
    exit;
  }
?>