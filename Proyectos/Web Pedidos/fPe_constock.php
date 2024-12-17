<?php
  // Crear una select con los productos que tienen stock
  function selectProdLine() {
    $res = prodLines();
    
    echo "<select name='productLine'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($res as $lineaProd)
      echo "<option value='" . $lineaProd['productLine'] . "'>" . $lineaProd['productLine'] . "</option>";

    echo "</select>";
  }

  // Devuelve un array con los productos que tienen stock
  function prodLines() {
    $sql = "SELECT DISTINCT productLine
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
  function verificarLineaProd($lineaProd) {
    if ($lineaProd == '')
      trigger_error('Debes seleccionar un producto', E_USER_WARNING);
  }

  // Verificar que haya stock suficiente
  function verStock($lineaProd) {
    $res = obtenerStock($lineaProd);
    
    if (empty($res))
      trigger_error("No hay stock en la línea de productos $lineaProd", E_USER_WARNING);

    // Si existen productos con stock suficiente
    echo "Stock de <b>$lineaProd</b>: <br>";

    echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
    echo "<tr>";
    echo "<th>Producto</th>";
    echo "<th>Cantidad</th>";
    echo "</tr>";

    foreach ($res as $producto) {
      echo "<tr>";
      echo "<td>" . $producto['productName'] . "</td>";
      echo "<td>" . $producto['quantityInStock'] . "</td>";
      echo "</tr>";
    }

    echo "</table>";
  }

  // Obtener el stock de un producto
  function obtenerStock($lineaProd) {
    $sql = "SELECT productName, quantityInStock
              FROM products
              WHERE productLine = :productLine";
    $args = [':productLine' => $lineaProd];

    return operarBd($sql, $args);
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