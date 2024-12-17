<?php
  // Crear una select con los productos que tienen stock
  function selectProds() {
    $resultado = prods();
    
    echo "<select name='productCode'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $producto)
      echo "<option value='" . $producto['productCode'] . "'>" . $producto['productName'] . "</option>";

    echo "</select>";
  }

  // Devuelve un array con los productos que tienen stock
  function prods() {
    $sql = "SELECT productCode, productName
              FROM products";

    return operarBd($sql);
  }

  // Limpiar los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  // Verificar que se haya seleccionado un producto
  function verificarProd($prod) {
    if ($prod == '')
      trigger_error('Debes seleccionar un producto', E_USER_WARNING);
  }

  // Verificar que haya stock suficiente
  function verStock($prod) {
    $res = obtenerStock($prod);
    $nombreProd = obtenerNombreProd($prod);
    
    if (empty($res))
      $stock = 0;
    else
      $stock = $res[0]['quantityInStock'];

    echo "Hay <b>$stock</b> unidades de <b>$nombreProd</b> en stock<br>";
  }

  // Obtener el stock de un producto
  function obtenerStock($prod) {
    $sql = "SELECT quantityInStock
              FROM products
              WHERE productCode = :productCode";
    $args = [':productCode' => $prod];

    return operarBd($sql, $args);
  }

  function obtenerNombreProd($prod) {
    $sql = "SELECT productName
              FROM products
              WHERE productCode = :productCode";
    $args = [':productCode' => $prod];

    return operarBd($sql, $args)[0]['productName'];
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