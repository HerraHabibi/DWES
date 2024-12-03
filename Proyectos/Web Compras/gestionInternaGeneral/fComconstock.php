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

  function consultarStock($codProd) {
    
    $resultado = buscarProd($codProd);
    $nombreProducto = obtenerNombreProducto($codProd);

    if (empty($resultado)) {
      echo "El producto <b>$nombreProducto</b> no se encuentra en stock <br>";
    
    } else {
      echo "<b>$nombreProducto</b> se encuentra en: <br><br>";

      echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
      echo "<tr>";
      echo "<th>Localidad</th>";
      echo "<th>Cantidad</th>";
      echo "</tr>";

      foreach ($resultado as $almacena) {
        echo "<tr>";
        echo "<td>" . $almacena['localidad'] . "</td>";
        echo "<td>" . $almacena['cantidad'] . "</td>";
        echo "</tr>";
      }

      echo "</table>";
    }
  }

  function buscarProd($codProd) {
    $sql = "SELECT almacen.localidad, almacena.cantidad
              FROM almacen
              JOIN almacena ON almacen.num_almacen = almacena.num_almacen
              WHERE almacena.id_producto = :id_producto";
    $params = [':id_producto' => $codProd];

    return operarBd($sql, $params);
  }

  function obtenerNombreProducto($codProd) {
    $sql = "SELECT nombre
            FROM producto
            WHERE id_producto = :id_producto";
    $params = [':id_producto' => $codProd];

    $resultado = operarBd($sql, $params);

    return $resultado[0]['nombre'];
}
?>