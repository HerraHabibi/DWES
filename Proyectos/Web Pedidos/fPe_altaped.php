<?php
  // Obtener el nombre del cliente actual
  function obtenerNombreCliente() {
    $sql = "SELECT contactFirstName
            FROM customers
            WHERE customerNumber = :customerNumber";
    $args = [':customerNumber' => $_SESSION['usuario']];

    return operarBd($sql, $args)[0]['contactFirstName'];
  }

  // Obtener el nombre de un producto pasándole su código por parámetros
  function obtenerNombreProducto($prod) {
    $sql = "SELECT productName
            FROM products
            WHERE productCode = :productCode";
    $args = [':productCode' => $prod];

    return operarBd($sql, $args)[0]['productName'];
  }

  // Crear una select con los productos que tienen stock
  function selectProdsConStock() {
    $res = consultarProdsConStock();
    
    echo "<select name='productCode'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($res as $producto)
      echo "<option value='" . $producto['productCode'] . "'>" . $producto['productName'] . "</option>";

    echo "</select>";
  }

  // Devuelve un array con los productos que tienen stock
  function consultarProdsConStock() {
    $sql = "SELECT productCode, productName
              FROM products
              WHERE quantityInStock > 0";

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

  // Verificar que se haya establecido una cantidad válida
  function verificarCant($cant) {
    if ($cant == '')
      trigger_error('Debes establecer una cantidad', E_USER_WARNING);

    if (!is_numeric($cant))
      trigger_error('La cantidad debe ser un número', E_USER_WARNING);

    if (intval($cant) != $cant)
      trigger_error('La cantidad debe ser un número entero', E_USER_WARNING);

    if ($cant < 1)
      trigger_error('La cantidad debe ser mínimo 1', E_USER_WARNING);

    return intval($cant);
  }

  // Verificar que haya stock suficiente
  function comprobarStock($prod, $cant) {
    $res = obtenerStockProd($prod);
    
    if (empty($res))
      $stock = 0;
    else
      $stock = $res[0]['quantityInStock'];

    if ($stock < $cant)
      trigger_error('No hay suficiente stock', E_USER_WARNING);
    
    return true;
  }

  // Obtener el stock de un producto
  function obtenerStockProd($prod) {
    $sql = "SELECT quantityInStock
              FROM products
              WHERE productCode = :productCode";
    $args = [':productCode' => $prod];

    return operarBd($sql, $args);
  }

  // Crear el carrito del cliente
  function crearCarrito($prod, $cant) {
    // Si existe la cookie del carrito la pasamos a array, sino creamos un array vacío
    $carrito = isset($_COOKIE['carrito']) ? unserialize($_COOKIE['carrito']) : array();
    
    // Creamos el carrito del cliente si es que no existe
    if (!isset($carrito[$_SESSION['usuario']]))
      $carrito[$_SESSION['usuario']] = array();

    // Si el cliente ya tenía el producto en el carrito, suma la cantidad, sino lo agrega con la cantidad.
    if (isset($carrito[$_SESSION['usuario']][$prod]))
      $carrito[$_SESSION['usuario']][$prod] += $cant;
    else
      $carrito[$_SESSION['usuario']][$prod] = $cant;

    // Pasar el array del carrito a cookie
    setcookie('carrito', serialize($carrito), time() + (10 * 365 * 24 * 60 * 60), '/');
  }

  // Mostrar en una tabla el carrito del cliente
  function mostrarCarrito() {
    $carrito = isset($_COOKIE['carrito']) ? unserialize($_COOKIE['carrito']) : array();

    if (isset($carrito[$_SESSION['usuario']]))
      crearTablaCarrito($carrito[$_SESSION['usuario']]);
    else
      echo 'No tienes productos en el carrito';
  }

  // Creación de la tabla del carrito del usuario
  function crearTablaCarrito($carritoCliente) {
    echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
    echo '<tr>';
    echo '<th>Producto</th>';
    echo '<th>Cantidad</th>';
    echo '</tr>';
    foreach ($carritoCliente as $prod => $cant) {
      echo '<tr>';
      echo '<td>' . obtenerNombreProducto($prod) . '</td>';
      echo "<td>$cant</td>";
      echo '</tr>';
    }    
    echo '</table>';
  }

  // Eliminar el carrito del cliente
  function eliminarCarrito() {
    $carrito = isset($_COOKIE['carrito']) ? unserialize($_COOKIE['carrito']) : array();

    if (isset($carrito[$_SESSION['usuario']])) {
      unset($carrito[$_SESSION['usuario']]);
      if (!empty($carrito))
        setcookie('carrito', serialize($carrito), time() + (10 * 365 * 24 * 60 * 60), '/');
      else
        setcookie('carrito', '', time() - 3600, '/');
    }
  }

  function hacerPedido($carrito){
    // Generamos el numero de orden
    $sql = "SELECT orderNumber FROM orders ORDER BY orderNumber DESC LIMIT 1";
    $numOrden = operarBd($sql);

    if ($numOrden)
      $numOrden = $numOrden[0]['orderNumber'] + 1;
    else
      $numOrden = 1;

    // Insertamos el pedido
    $sql = "INSERT INTO orders (orderNumber, orderDate, requiredDate, shippedDate, status, comments, customerNumber) 
            VALUES (:orderNumber, CURDATE(), CURDATE() + INTERVAL 3 DAY, NULL, 'Shipped', NULL, :customerNumber)";
    $valores = [':orderNumber' => $numOrden, ':customerNumber' => $_SESSION['usuario']];

    $valido = operarBd($sql, $valores);

    if ($valido) {
      $numLinea = 1;

      // Insertamos el detalle del pedido
      foreach ($carrito as $numProd => $cantProd) {
        $sql = "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber) 
                VALUES (:orderNumber, :productCode, :quantityOrdered, (SELECT buyPrice FROM products WHERE productCode = :productCode), :orderLineNumber)";
        $valores = [':orderNumber' => $numOrden, ':productCode' => $numProd, ':quantityOrdered' => $cantProd, ':orderLineNumber' => $numLinea];
        $valido = operarBd($sql, $valores);

        $numLinea++;
      }

      if ($valido)
        echo "<p>Pedido realizado correctamente</p>";
    }
  }

  function actualizarStock($prodNum, $cant) {
    $sql = "SELECT productCode, quantityInStock
            FROM products 
            WHERE productCode = :productCode";
    $valores = [':productCode' => $prodNum];
    $datos = operarBd($sql, $valores);

    // Verificar si se obtuvo algún resultado
    if (!empty($datos) && isset($datos[0]['quantityInStock'])) {
      $cant_actual = $datos[0]['quantityInStock'];

      if ($cant_actual >= $cant) {
        $sql_update = "UPDATE products 
                        SET quantityInStock = quantityInStock - :CANTIDAD
                        WHERE productCode = :productCode";
        $valores_update = [':CANTIDAD' => $cant, ':productCode' => $prodNum];
        $valido = operarBd($sql_update, $valores_update);

        if (!$valido)
          trigger_error("Error al actualizar el stock del producto $prodNum.", E_USER_ERROR);
      } else
        echo "<p>No hay suficiente stock del producto $prodNum.</p>";
    } else
      echo "<p>Error: No se encontró información del producto $prodNum.</p>";
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