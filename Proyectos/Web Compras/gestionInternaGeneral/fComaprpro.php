<?php
  function selectProds() {
    $sql = "SELECT id_producto, nombre
              FROM producto";

    $resultado = operarBd($sql);
    
    echo "<select name='id_producto'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $producto) {
      echo "<option value='" . $producto['id_producto'] . "'>" . $producto['nombre'] . "</option>";
    }
    echo "</select>";
  }
  
  function selectAlms() {
    $sql = "SELECT num_almacen, localidad
              FROM almacen";

    $resultado = operarBd($sql);
    
    echo "<select name='num_almacen'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $almacen) {
      echo "<option value='" . $almacen['num_almacen'] . "'>" . $almacen['localidad'] . "</option>";
    }
    echo "</select>";
  }

  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  function validarProd($codProd) {
    if ($codProd == '')
      trigger_error('Debes seleccionar un producto', E_USER_WARNING);
  }

  function validarAlm($codAlm) {
    if ($codAlm == '')
      trigger_error('Debes seleccionar un almacén', E_USER_WARNING);
  }

  function validarCantidad($cantidad) {
    if ($cantidad == '')
      trigger_error('Debes introducir una cantidad', E_USER_WARNING);

    if (!is_numeric($cantidad))
      trigger_error('La cantidad debe ser un número', E_USER_WARNING);

    if ($cantidad < 0.01)
      trigger_error('La cantidad no puede ser inferior a 1', E_USER_WARNING);
  }

  function aprovisionarProducto($codProd, $codAlm, $cantidad) {
    $sql = "SELECT cantidad
              FROM almacena
              WHERE id_producto = :id_producto AND num_almacen = :num_almacen";
    $params = [':id_producto' => $codProd, ':num_almacen' => $codAlm];

    $resultado = operarBd($sql, $params);

    if (empty($resultado)) {
      $sql = "INSERT INTO almacena (id_producto, num_almacen, cantidad)
                VALUES (:id_producto, :num_almacen, :cantidad)";
      $params = [':id_producto' => $codProd, ':num_almacen' => $codAlm, ':cantidad' => $cantidad];
                
      $valido = operarBd($sql, $params);

      if ($valido)
        echo "Se aprovisionó el producto correctamente <br>";
    } else {
      $cantidad += $resultado[0]['cantidad'];

      $sql = "UPDATE almacena
                SET cantidad = :cantidad
                WHERE id_producto = :id_producto AND num_almacen = :num_almacen";
      $params = [':cantidad' => $cantidad, ':id_producto' => $codProd, ':num_almacen' => $codAlm];

      $valido = operarBd($sql, $params);

      if ($valido)
        echo "Se aprovisionó el producto correctamente <br>";
    }
  }
?>