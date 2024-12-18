<?php
  function selectProds() {
    $sql = "SELECT id_producto, nombre
              FROM producto";
              
    $resultado = operarBd($sql);
    
    echo "<select name='id_producto'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $producto)
      echo "<option value='" . $producto['id_producto'] . "'>" . $producto['nombre'] . "</option>";

    echo "</select>";
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

  function crearCookieCarrito($codProd, $unidades) {
    $carrito = array();

    $carrito = obtenerCarrito();
    
    $nuevoProducto = [$codProd, $unidades];
    $carrito[] = $nuevoProducto;

    var_dump($carrito);
    echo $codProd;
    // Serializar el carrito
    $carritoSerializado = serialize($carrito);
    
    // Crear o actualizar la cookie con duración de 7 días
    setcookie('carrito', $carritoSerializado, time() + (7 * 24 * 60 * 60), "/");
  }

  function obtenerCarrito() {
    if (isset($_COOKIE['carrito']))
      $carrito = unserialize($_COOKIE['carrito']);
    else
      $carrito = array();

    return $carrito;
  }

  function buscarNif($usuario) {
    $sql = "SELECT nif
              FROM cliente
              WHERE usuario = :usuario";
    $args = [':usuario' => $usuario];

    $resultado = operarBd($sql, $args);

    return $resultado[0]['nif'];
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
      $valido = actualizarCompra($resultado[0]['NIF'], $resultado[0]['ID_PRODUCTO'], $resultado[0]['FECHA_COMPRA'], $unidades);

    else
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

  function actualizarCompra($nif, $codProd, $fechaCompra, $unidades) {
    $sql = "UPDATE compra
            SET unidades = unidades + :unidades
            WHERE nif = :nif AND id_producto = :id_producto AND fecha_compra = :fecha_compra";
    $args = [':nif' => $nif, ':id_producto' => $codProd, ':fecha_compra' => $fechaCompra, ':unidades' => $unidades];

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