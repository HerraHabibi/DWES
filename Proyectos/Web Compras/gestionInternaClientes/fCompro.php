<?php
  function selectNifs() {
    $resultado = nifClientes();
    
    echo "<select name='nif'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $cliente)
      echo "<option value='" . $cliente['nif'] . "'>" . $cliente['nif'] . "</option>";

    echo "</select>";
  }

  function nifClientes() {
    $sql = "SELECT nif
              FROM cliente";
              
    return operarBd($sql);
  }

  function selectProds() {
    $resultado = prods();
    
    echo "<select name='id_producto'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $producto)
      echo "<option value='" . $producto['id_producto'] . "'>" . $producto['nombre'] . "</option>";

    echo "</select>";
  }

  function prods() {
    $sql = "SELECT id_producto, nombre
              FROM producto";

    return operarBd($sql);
  }

  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  function validarNif($nif) {
    if ($nif == '')
      trigger_error('Debes seleccionar un NIF', E_USER_WARNING);
  }

  function validarProd($codProd) {
    if ($codProd == '')
      trigger_error('Debes seleccionar un producto', E_USER_WARNING);
  }

  function validarUnidades($unidades) {
    if ($unidades == '')
      trigger_error('Debes introducir una cantidad de unidades', E_USER_WARNING);

    if (!is_numeric($unidades))
      trigger_error('Las unidades deben ser un número', E_USER_WARNING);

    if ($unidades < 1)
      trigger_error('Las unidades tienen que ser mínimo 1', E_USER_WARNING);
  }

  function disponibilidadStock($codProd, $unidades){
    $resultado = verStock($codProd);

    $valido = true;

    if ($resultado[0]['stock'] < $unidades) {
      trigger_error('No hay suficiente stock para realizar la compra', E_USER_WARNING);
      $valido = false;
    }

    return $valido;
  }

  function verStock($codProd) {
    $sql = "SELECT SUM(cantidad) as stock
            FROM almacena 
            WHERE id_producto = :id_producto";
    $args = [':id_producto' => $codProd];

    return operarBd($sql, $args);
  }

  function realizarCompra($nif, $codProd, $unidades) {
    $resultado = comprobarSiYaComproElProdHoy($nif, $codProd);
    if (!empty($resultado))
      trigger_error('El cliente ya ha comprado este producto hoy', E_USER_WARNING);

    $valido = comprar($nif, $codProd, $unidades);

    if ($valido)
      echo "<p>Compra realizada correctamente</p>";
  }

  function comprobarSiYaComproElProdHoy($nif, $codProd) {
    $sql = "SELECT *
              FROM compra
              WHERE nif = :nif AND id_producto = :id_producto AND fecha_compra = CURDATE()";
    $args = [':nif' => $nif, ':id_producto' => $codProd];

    return operarBd($sql, $args);
  }

  function comprar($nif, $codProd, $unidades) {
    $sql = "INSERT INTO compra (nif, id_producto, fecha_compra, unidades)
              VALUES (:nif, :id_producto, CURDATE(), :unidades)";
    $args = [':nif' => $nif, ':id_producto' => $codProd, ':unidades' => $unidades];

    return operarBd($sql, $args);
  }

  function actualizarStock($codProd, $unidades) {
    $resultado = stockPorAlmacen($codProd);

    foreach ($resultado as $almacen) {
      $cantidadDisponible = $almacen['cantidad'];
      $codAlmacen = $almacen['num_almacen'];

      if ($cantidadDisponible >= $unidades) {
        $valido = actualizarStockAlmacenSuficiente($unidades, $codAlmacen, $codProd);

        if ($valido)
          echo "<p>Stock actualizado correctamente.</p>";

        break;

      } else {
          $valido = actualizarStockAlmacenInsuficiente($unidades, $codAlmacen, $codProd);
          $unidades -= $cantidadDisponible;
        }
      }
  }

  function stockPorAlmacen($codProd) {
    $sql = "SELECT num_almacen, cantidad 
            FROM almacena 
            WHERE id_producto = :id_producto 
            ORDER BY num_almacen ASC";
    $args = [':id_producto' => $codProd];

    return operarBd($sql, $args);
  }

  function actualizarStockAlmacenSuficiente($unidades, $codAlmacen, $codProd) {
    $sql = "UPDATE almacena 
              SET cantidad = cantidad - :cantidad 
              WHERE num_almacen = :num_almacen AND id_producto = :id_producto";
    $args = [':cantidad' => $unidades, ':num_almacen' => $codAlmacen, ':id_producto' => $codProd];

    return operarBd($sql, $args);
  }

  function actualizarStockAlmacenInsuficiente($unidades, $codAlmacen, $codProd) {
    $sql = "UPDATE almacena 
              SET cantidad = 0
              WHERE num_almacen = :num_almacen AND id_producto = :id_producto";
    $args = [':num_almacen' => $codAlmacen, ':id_producto' => $codProd];

    return operarBd($sql, $args);
  }
?>