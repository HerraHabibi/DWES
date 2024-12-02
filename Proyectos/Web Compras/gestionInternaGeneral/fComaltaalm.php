<?php
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  // Función que devuelve el código del último almacén creado
  function buscarUltimoAlm() {
    // Definir la query y ejecutarla
    $sql = "SELECT num_almacen
              FROM almacen";
    $resultado = operarBd($sql);

    // Si no hay almacenes, devuelve 0
    if (empty($resultado))
      return '0';

    // Sino devuelve el código del último almacén
    foreach ($resultado as $almacen)
      $ultAlm = $almacen['num_almacen'];

    return $ultAlm;
  }

  // Función que devuelve el código del nuevo almacén
  function calcularCodNuevoAlm($ultAlm) {
    return intval($ultAlm) + 1;
  }

  // Función para insertar el nuevo almacén en la base de datos
  function insertarAlm($codAlm, $locAlm) {
    $sql = "INSERT INTO almacen (num_almacen, localidad)
              VALUES (:num_almacen, :localidad)";
    $params = [':num_almacen' => $codAlm, ':localidad' => $locAlm];

    $valido = operarBd($sql, $params);

    if ($valido)
      echo "Se creó un almacén en <b>$locAlm</b> <br>";
  }
?>