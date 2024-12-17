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
  function verPagos($cliente, $desde, $hasta) {
    $res = obtenerPagos($cliente, $desde, $hasta);
    
    if (empty($res))
      trigger_error("El cliente $cliente no ha realizado ningún pedido", E_USER_WARNING);

    // Si ha realizado pedidos
    echo "Pedidos realizados por el cliente <b>$cliente</b>: <br>";

    echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
    echo "<tr>";
    echo "<th>ID Pago</th>";
    echo "<th>Fecha del pago</th>";
    echo "<th>Cantidad</th>";
    echo "</tr>";

    foreach ($res as $pedido) {
      echo "<tr>";
      echo "<td>" . $pedido['checkNumber'] . "</td>";
      echo "<td>" . $pedido['paymentDate'] . "</td>";
      echo "<td>" . $pedido['amount'] . "</td>";
      echo "</tr>";
    }

    echo "</table>";
  }

  // Obtener los pagos realizados por el cliente especificado, en una fecha determinada (o no)
  function obtenerPagos($cliente, $desde, $hasta) { 
    $sql = "SELECT payments.checkNumber,
                   payments.paymentDate, 
                   payments.amount
              FROM customers
              JOIN payments ON customers.customerNumber = payments.customerNumber
              WHERE customers.customerNumber = :customerNumber
                AND payments.paymentDate BETWEEN :desde AND :hasta
              ORDER BY payments.paymentDate ASC";
    
    $args = [':customerNumber' => $cliente, ':desde' => $desde, ':hasta' => $hasta];

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