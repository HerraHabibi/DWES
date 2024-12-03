<?php
  function selectNifs() {
    $sql = "SELECT nif
              FROM cliente";
              
    $resultado = operarBd($sql);
    
    echo "<select name='nif'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $cliente)
      echo "<option value='" . $cliente['nif'] . "'>" . $cliente['nif'] . "</option>";

    echo "</select>";
  }

  function validarNif($nif) {
    if ($nif == '')
      trigger_error('Debes seleccionar un NIF', E_USER_WARNING);
  }

  function validarDesde($desde) {
    if ($desde == '')
      trigger_error('Debes seleccionar una fecha de inicio', E_USER_WARNING);
  }

  function validarHasta($hasta) {
    if ($hasta == '')
      trigger_error('Debes seleccionar una fecha de fin', E_USER_WARNING);
  }

  function consultarCompras($nif, $desde, $hasta) {
    $resultado = verCompras($nif, $desde, $hasta);

    if (empty($resultado)) {
      echo "El cliente con NIF <b>$nif</b> no compró entre el " . date('d/m/Y', strtotime($desde)) . " y el " . date('d/m/Y', strtotime($hasta)) . "<br>";
    
    } else {
      echo "Entre el " . date('d/m/Y', strtotime($desde)) . " y el " . date('d/m/Y', strtotime($desde)) . " el cliente con NIF <b>$nif</b> compró: <br><br>";

      echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
      echo "<tr>";
      echo "<th>Producto</th>";
      echo "<th>Cantidad</th>";
      echo "</tr>";

      foreach ($resultado as $producto) {
        echo "<tr>";
        echo "<td>" . $producto['nombre'] . "</td>";
        echo "<td>" . $producto['unidades'] . "</td>";
        echo "</tr>";
      }

      echo "</table>";
    }
  }

  function verCompras($nif, $desde, $hasta) {
    $sql = "SELECT producto.nombre, compra.unidades
              FROM compra
              JOIN producto ON producto.id_producto = compra.id_producto
              WHERE compra.nif = :nif AND compra.fecha_compra BETWEEN :desde AND :hasta";
    $args = [':nif' => $nif, ':desde' => $desde, ':hasta' => $hasta];

    return operarBd($sql, $args);
  }
?>