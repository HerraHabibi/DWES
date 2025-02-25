<?php
  // Limpia los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  // Verifica que los inputs no esten vacios
  function verificarInputs($nombre, $clave) {
    if ($nombre == '' || $clave == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);
  }

  // Busca el código del último costumer registrado y lo devuelve y sino devuelve 0
  function buscarUltimoCustomer() {
    $resultado = consultarCustomerNumbers();

    // Si no hay customers, devuelve 0
    if (empty($resultado))
      return '0';

    // Sino devuelve el customNumber del último customer
    $ultCustomer = $resultado[0]['customerNumber'];

    return $ultCustomer;
  }

  // Devuelve el último customerNumber registrado
  function consultarCustomerNumbers() {
    $sql = "SELECT customerNumber
              FROM customers
              ORDER BY 1 DESC
              LIMIT 1";
              
    return operarBd($sql);
  }

  // Registra un nuevo customer con la clave encriptada
  function registrar($nuevoCustomerNumber, $nombre, $clave) {
    $sql = "INSERT INTO customers(customerNumber, customerName, contactLastName, contactFirstName, phone, addrebLine1, city, country, claveEncriptada)
              VALUES(:customerNumber, :customerName, :contactLastName, :contactFirstName, :phone, :addrebLine1, :city, :country, :claveEncriptada)";
    $params = [':customerNumber' => $nuevoCustomerNumber, ':customerName' => $nombre, ':contactLastName' => $clave, ':contactFirstName' => $nombre, ':phone' => '600000000', ':addrebLine1' => 'C. Verde', ':city' => 'Madrid', ':country' => 'España', ':claveEncriptada' => password_hash($clave, PASSWORD_DEFAULT)];

    return operarBd($sql, $params);
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