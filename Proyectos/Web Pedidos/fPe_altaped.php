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
      return false;
    else
      return true;
  }

  // Verificar que se haya establecido una cantidad válida
  function verificarCant($cant) {
    if ($cant == '')
      return 'Debes establecer una cantidad';

    if (!is_numeric($cant))
      return 'La cantidad debe ser un número';

    if (intval($cant) != $cant)
      return 'La cantidad debe ser un número entero';

    if ($cant < 1)
      return 'La cantidad debe ser mínimo 1';

    return intval($cant);
  }

  // Verificar que haya stock suficiente
  function comprobarStock($prod, $cant) {
    $res = obtenerStockProd($prod);
    
    if (empty($res))
      $stock = 0;
    else
      $stock = $res[0]['quantityInStock'];

    return $stock >= $cant;
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

  function hacerPedido($carrito) {
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
    $args = [':orderNumber' => $numOrden, ':customerNumber' => $_SESSION['usuario']];

    operarBd($sql, $args);

    $numLinea = 1;

    // Insertamos el detalle del pedido
    foreach ($carrito as $numProd => $cantProd) {
      $sql = "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber) 
              VALUES (:orderNumber, :productCode, :quantityOrdered, (SELECT buyPrice FROM products WHERE productCode = :productCode), :orderLineNumber)";
      $args = [':orderNumber' => $numOrden, ':productCode' => $numProd, ':quantityOrdered' => $cantProd, ':orderLineNumber' => $numLinea];
      operarBd($sql, $args);

      $numLinea++;
    }

    // Insertamos el pago si no existe un pago realizado por el usuario con la tarjeta introducida, sino hace un update
    $sql = "SELECT amount
            FROM payments
            WHERE customerNumber = :customerNumber AND checkNumber = :checkNumber";
    $args = [':customerNumber' => $_SESSION['usuario'], ':checkNumber' => $_SESSION['tarjeta']];
    $res = operarBd($sql, $args);

    if (!empty($res)) {
      $sql = "UPDATE payments
              SET paymentDate = CURDATE(), amount = :amount
              WHERE customerNumber = :customerNumber AND checkNumber = :checkNumber";
      $args = [':customerNumber' => $_SESSION['usuario'], ':checkNumber' => $_SESSION['tarjeta'], ':amount' => $_SESSION['precioTotal']];
      operarBd($sql, $args);
      
    } else {
      $sql = "INSERT INTO payments (customerNumber, checkNumber, paymentDate, amount) 
              VALUES (:customerNumber, :checkNumber, CURDATE(), :amount)";
      $args = [':customerNumber' => $_SESSION['usuario'], ':checkNumber' => $_SESSION['tarjeta'], ':amount' => $_SESSION['precioTotal']];
      operarBd($sql, $args);
    }
  }

  function actualizarStock($prodNum, $cant) {
    $sql = "SELECT productCode, quantityInStock
            FROM products 
            WHERE productCode = :productCode";
    $args = [':productCode' => $prodNum];
    $res = operarBd($sql, $args);

    // Verificar si se obtuvo algún resultado
    if (!empty($res) && isset($res[0]['quantityInStock'])) {
      $cant_actual = $res[0]['quantityInStock'];

      if ($cant_actual >= $cant) {
        $sql_update = "UPDATE products 
                        SET quantityInStock = quantityInStock - :CANTIDAD
                        WHERE productCode = :productCode";
        $args = [':CANTIDAD' => $cant, ':productCode' => $prodNum];
        $valido = operarBd($sql_update, $args);

        if (!$valido)
          echo "<p>Error al actualizar el stock del producto $prodNum.</p>";
      } else
        echo "<p>No hay suficiente stock del producto $prodNum.</p>";
    } else
      echo "<p>Error: No se encontró información del producto $prodNum.</p>";
  }

  // Obtener precio de un producto
  function obtenerPrecioProducto($productCode) {
    $sql = "SELECT buyPrice FROM products WHERE productCode = :productCode";
    $args = [':productCode' => $productCode];
    $res = operarBd($sql, $args);

    if ($res)
      $precio = $res[0]['buyPrice'];

    return $precio; 
  }

  // Calcular el precio total de los productos en el carrito
  function calcularPrecioTotal($carrito) {
    $total = 0;

    foreach ($carrito as $producto => $cantidad)
      $total += obtenerPrecioProducto($producto) * $cantidad;

    return $total;
  }

  // Verificar si la tarjeta introducida es correcta
  function comprobarTarjeta($tarjeta) {
    $tarjeta = strtoupper($tarjeta);

    if (strlen($tarjeta) !== 7)
      return false;

    return ctype_alpha(substr($tarjeta, 0, 2)) && ctype_digit(substr($tarjeta, 2));
  }

  // Pasarela de pago
  function pasarelaPago($precioTotal) {
    // Datos de la transacción para Redsys
    $orderId = rand(1000000, 9999999); // Genera un ID único para el pedido
    $currency = '978'; // EUR (ISO 4217 code)
    $amount = intval($precioTotal * 100); // Monto en céntimos
    
    // Datos de configuración de Redsys
    $dsSignatureVersion = 'HMAC_SHA256_V1';
    $merchantCode = '263100000'; // Código de comercio
    $secretKey = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; // Clave secreta
    //sq7HjrUOBfKmC576ILgskD5srU870gJ7
    // redsys nombre:isa clave:Metal123456789Metal
    $url = 'https://sis-t.redsys.es:25443/sis/realizarPago'; // URL de pago de Redsys
    $urlOk = 'http://192.168.206.226/DWES/Proyectos/Web%20Pedidos/ok'; // URL de confirmación (pago exitoso)
    $urlKo = 'http://192.168.206.226/DWES/Proyectos/Web%20Pedidos/ko'; // URL de error
    
    $redsys = new RedsysAPI();

    $redsys->setParameter("DS_MERCHANT_AMOUNT",$amount);
    $redsys->setParameter("DS_MERCHANT_ORDER",$orderId);
    $redsys->setParameter("DS_MERCHANT_MERCHANTCODE",$merchantCode);
    $redsys->setParameter("DS_MERCHANT_CURRENCY",$currency);
    $redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE",'0');
    $redsys->setParameter("DS_MERCHANT_TERMINAL",'15');
    $redsys->setParameter("DS_MERCHANT_MERCHANTURL",$url);
    $redsys->setParameter("DS_MERCHANT_URLOK",$urlOk);
    $redsys->setParameter("DS_MERCHANT_URLKO",$urlKo);

    $params = $redsys->createMerchantParameters();
    $signature = $redsys->createMerchantSignature($secretKey);

    echo "<form name='frm' action='$url' method='POST' id='paymentForm'>";
    echo "<input type='hidden' name='Ds_SignatureVersion' value='$dsSignatureVersion'>";
    echo "<input type='hidden' name='Ds_MerchantParameters' value='$params'>";
    echo "<input type='hidden' name='Ds_Signature' value='$signature'>";
    echo "</form>";
    echo "<script type='text/javascript'>document.getElementById('paymentForm').submit();</script>";
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