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
  function verificarCant($cantidad) {
    if ($cantidad == '')
      trigger_error('Debes establecer una cantidad', E_USER_WARNING);

    if (!is_numeric($cantidad))
      trigger_error('La cantidad debe ser un número', E_USER_WARNING);

    if (intval($cantidad) != $cantidad)
      trigger_error('La cantidad debe ser un número entero', E_USER_WARNING);

    if ($cantidad < 1)
      trigger_error('La cantidad debe ser mínimo 1', E_USER_WARNING);

    return intval($cantidad);
  }

  // Verificar que haya stock suficiente
  function comprobarStock($prod, $cantidad) {
    $res = obtenerStockProd($prod);
    
    if (empty($res))
      $stock = 0;
    else
      $stock = $res[0]['quantityInStock'];

    if ($stock < $cantidad)
      trigger_error('No hay suficiente stock', E_USER_WARNING);
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
  function crearCarrito($prod, $cantidad) {
    // Si existe la cookie del carrito la pasamos a array, sino creamos un array vacío
    $carrito = isset($_COOKIE['carrito']) ? unserialize($_COOKIE['carrito']) : array();
    
    // Creamos el carrito del cliente si es que no existe
    if (!isset($carrito[$_SESSION['usuario']]))
      $carrito[$_SESSION['usuario']] = array();

    // Si el cliente ya tenía el producto en el carrito, suma la cantidad, sino lo agrega con la cantidad.
    if (isset($carrito[$_SESSION['usuario']][$prod]))
      $carrito[$_SESSION['usuario']][$prod] += $cantidad;
    else
      $carrito[$_SESSION['usuario']][$prod] = $cantidad;

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
    foreach ($carritoCliente as $prod => $cantidad) {
      echo '<tr>';
      echo '<td>' . obtenerNombreProducto($prod) . '</td>';
      echo "<td>$cantidad</td>";
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