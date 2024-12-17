<?php
  // Limpiar los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  // Verificar que se haya seleccionado una fecha
  function verificarFecha($fecha) {
    if ($fecha == '')
      trigger_error('Debes seleccionar las dos fechas', E_USER_WARNING);
  }

  // Mostrar 
  function verProdsCompradosEntre($desde, $hasta) {
    $res = obtenerProdsCompradosEntre($desde, $hasta);
    
    if (empty($res))
      trigger_error("No se han vendido productos entre $desde y $hasta", E_USER_WARNING);

    // Si existen productos con stock suficiente
    echo "Productos que has comprado entre el <b>". date('d/m/Y', strtotime($desde)) . "</b> y el <b>". date('d/m/Y', strtotime($hasta)) . "</b>: <br>";

    echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
    echo "<tr>";
    echo "<th>Producto</th>";
    echo "<th>Cantidad</th>";
    echo "</tr>";

    foreach ($res as $producto) {
      echo "<tr>";
      echo "<td>" . $producto['productName'] . "</td>";
      echo "<td>" . $producto['quantityOrdered'] . "</td>";
      echo "</tr>";
    }

    echo "</table>";
  }

  // Obtener los productos comprados por el cliente actual entre las fechas indicadas
  function obtenerProdsCompradosEntre($desde, $hasta) {
    $sql = "SELECT products.productName, orderdetails.quantityOrdered
              FROM orderdetails
              INNER JOIN orders ON orderdetails.orderNumber = orders.orderNumber 
              INNER JOIN products ON orderdetails.productCode = products.productCode
              WHERE orders.customerNumber = :usuario
                AND orders.orderDate BETWEEN :desde AND :hasta";
    $args = [':desde' => $desde, ':hasta' => $hasta, ':usuario' => $_SESSION['usuario']];

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