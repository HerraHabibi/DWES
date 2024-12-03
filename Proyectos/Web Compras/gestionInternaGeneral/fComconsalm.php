<?php
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

  function validarAlm($codAlm) {
    if ($codAlm == '')
      trigger_error('Debes seleccionar un almacén', E_USER_WARNING);
  }

  function verProductos($codAlm) {
    
    $resultado = buscarProds($codAlm);
    $nombreLocalidad = obtenerNombreLocalidad($codAlm);

    if (empty($resultado)) {
      echo "El almacén de <b>$nombreLocalidad</b> no tiene productos <br>";
    
    } else {
      echo "<b>$nombreLocalidad</b> tiene los productos: <br><br>";

      echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
      echo "<tr>";
      echo "<th>Producto</th>";
      echo "<th>Cantidad</th>";
      echo "</tr>";

      foreach ($resultado as $producto) {
          echo "<tr>";
          echo "<td>" . $producto['nombre'] . "</td>";
          echo "<td>" . $producto['cantidad'] . "</td>";
          echo "</tr>";
      }

      echo "</table>";
    }
  }

  function buscarProds($codAlm) {
    $sql = "SELECT producto.nombre, almacena.cantidad
              FROM almacena
              JOIN producto ON almacena.id_producto = producto.id_producto
              WHERE almacena.num_almacen = :num_almacen";
    $params = [':num_almacen' => $codAlm];

    return operarBd($sql, $params);
  }

  function obtenerNombreLocalidad($codAlm) {
    $sql = "SELECT localidad
            FROM almacen
            WHERE num_almacen = :num_almacen";
    $params = [':num_almacen' => $codAlm];

    $resultado = operarBd($sql, $params);

    return $resultado[0]['localidad'];
  }
?>