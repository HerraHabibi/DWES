<?php
  // Select de los clientes
  function selectCustomers() {
    $res = obtenerClientes();

    echo "<select name='customerNumber'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($res as $cliente)
      echo "<option value='" . $cliente['customerNumber'] . "'>" . $cliente['customerNumber'] . "</option>";

    echo "</select>";
  }

  // Obtener los clientes
  function obtenerClientes() {
    $sql = "SELECT customerNumber
              FROM customers
              ORDER BY 1";

    return operarBd($sql);
  }

  // Limpiar los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  // Verificar que se haya seleccionado un cliente
  function verificarCliente($cliente) {
    if ($cliente == '')
      trigger_error('Debes seleccionar un cliente', E_USER_WARNING);
  }

  // Mostrar los pedidos de un cliente
  function verPedidos($cliente) {
    $res = obtenerPedidos($cliente);
    
    if (empty($res))
      trigger_error("El cliente $cliente no ha realizado ningún pedido", E_USER_WARNING);

    // Si ha realizado pedidos
    echo "Pedidos realizados por el cliente <b>$cliente</b>: <br>";

    echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
    echo "<tr>";
    echo "<th>Número de pedido</th>";
    echo "<th>Fecha de pedido</th>";
    echo "<th>Estado del pedido</th>";
    echo "<th>Número de línea</th>";
    echo "<th>Nombre del producto</th>";
    echo "<th>Cantidad pedida</th>";
    echo "<th>Precio</th>";
    echo "</tr>";

    foreach ($res as $pedido) {
      echo "<tr>";
      echo "<td>" . $pedido['orderNumber'] . "</td>";
      echo "<td>" . $pedido['orderDate'] . "</td>";
      echo "<td>" . $pedido['status'] . "</td>";
      echo "<td>" . $pedido['orderLineNumber'] . "</td>";
      echo "<td>" . $pedido['productName'] . "</td>";
      echo "<td>" . $pedido['quantityOrdered'] . "</td>";
      echo "<td>" . $pedido['priceEach'] . "</td>";
      echo "</tr>";
    }

    echo "</table>";
  }

  // Obtener los pedidos realizados por el cliente especificado
  function obtenerPedidos($cliente) { 
    $sql = "SELECT orders.orderNumber, 
                   orders.orderDate, 
                   orders.status, 
                   orderdetails.orderLineNumber, 
                   products.productName, 
                   orderdetails.quantityOrdered, 
                   orderdetails.priceEach
              FROM orders
              JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber
              JOIN products ON orderdetails.productCode = products.productCode
              WHERE orders.customerNumber = :customerNumber
              ORDER BY orders.orderNumber ASC, orderdetails.orderLineNumber ASC";
    
    $args = [':customerNumber' => $cliente];

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