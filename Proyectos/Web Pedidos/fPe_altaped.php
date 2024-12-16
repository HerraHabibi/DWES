<?php
  function selectProds() {
    $resultado = prods();
    
    echo "<select name='productCode'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $producto)
      echo "<option value='" . $producto['productCode'] . "'>" . $producto['productName'] . "</option>";

    echo "</select>";
  }

  function prods() {
    $sql = "SELECT productCode, productName
              FROM products
              WHERE quantityInStock > 0";

    return operarBd($sql);
  }

  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  function verificarProd($prod) {
    if ($prod == '')
      trigger_error('Debes seleccionar un producto', E_USER_WARNING);
  }

  function verificarCant($cantidad) {
    if ($cantidad == '')
      trigger_error('Debes establecer una cantidad', E_USER_WARNING);

    if (!is_numeric($cantidad))
      trigger_error('La cantidad debe ser un número', E_USER_WARNING);

    if (intval($cantidad) != $cantidad) {
      trigger_error('La cantidad debe ser un número entero', E_USER_WARNING);
    }

    if ($cantidad < 1)
      trigger_error('La cantidad debe ser mínimo 1', E_USER_WARNING);
  }

  function comprobarStock($prod, $cantidad) {
    $res = obtenerStock($prod);
    
    if (empty($res))
      $stock = 0;
    else
      $stock = $res[0]['quantityInStock'];

    if ($stock < $cantidad)
      trigger_error('No hay suficiente stock', E_USER_WARNING);
  }

  function obtenerStock($prod) {
    $sql = "SELECT quantityInStock
              FROM products
              WHERE productCode = :productCode";
    $args = [':productCode' => $prod];

    return operarBd($sql, $args);
  }

  function crearPedido($prod, $cantidad) {
    $idPedido = intval(buscarUltPedido()) + 1;
  }

  function buscarUltPedido() {
    $res = consultarCustomerNumbers();

    // Si no hay pedidos, devuelve 0, sino devuelve el id del último pedido
    if (empty($res))
      $ultPedido = 10099;
    else
      $ultPedido = $res[0]['customerNumber'];

    return $ultPedido;
  }
?>