<?php
  // Función para limpiar los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    $value = strtoupper($value);
  }

  // Función que devuelve el código del últomo departamento creado
  function buscarUltimoDpto() {
    // Definir la query y ejecutarla
    $sql = "SELECT cod_dpto
              FROM dpto";
    $resultado = operarBd($sql);

    // Si no hay departamentos, devuelve D000
    if (empty($resultado))
      return 'D000';

    // Sino devuelve el código del último departamento
    foreach ($resultado as $row)
      $ultDpto = $row['cod_dpto'];

    return $ultDpto;
  }

  // Función que devuelve el código del nuevo departamento
  function calcularCodNuevoDpto($ultDpto) {
    $ultDpto = intval(substr($ultDpto, 1));

    $nuevoDpto = strval($ultDpto + 1);
    $nuevoDpto = str_pad($nuevoDpto, 3, '0', STR_PAD_LEFT);
    $nuevoDpto = 'D' . $nuevoDpto;

    return $nuevoDpto;
  }

  // Función para insertar el nuevo departamento en la base de datos
  function insertarDpto($codDpto, $nomDpto) {
    $sql = "INSERT INTO dpto (cod_dpto, nombre) VALUES (:cod_dpto, :nombre)";
    $params = [':cod_dpto' => $codDpto, ':nombre' => $nomDpto];

    $valido = operarBd($sql, $params);

    if ($valido)
      echo "Se creó el departamento de $nomDpto correctamente";
  }
?>