<?php
  // Función para limpiar los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  function selectDptos() {
    $sql = "SELECT cod_dpto, nombre
              FROM dpto";
    $resultado = operarBd($sql);
    
    echo "<select name='cod_dpto'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    echo "<option value='null'>Ninguno</option>";
    foreach ($resultado as $registro) {
      echo "<option value='" . $registro['cod_dpto'] . "'>" . $registro['nombre'] . "</option>";
    }
    echo "</select>";
  }

  function formatearFechaNac(&$nacimiento) {
    $nacimiento = date('Y-m-d', strtotime($nacimiento));
  }

  function validarDpto(&$codDpto) {
    if ($codDpto == '')
      trigger_error('Debes seleccionar un departamento', E_USER_WARNING);

    else if ($codDpto == 'null')
      $codDpto = null;
  }

  function insertarEmple($dni, $nombre, $salario, $nacimiento) {
    $sql = "INSERT INTO emple (dni, nombre, salario, fecha_nac)
              VALUES (:dni, :nombre, :salario, :fecha_nac)";
    $params = [':dni' => strtoupper($dni), ':nombre' => strtoupper($nombre), ':salario' => floatval($salario), ':fecha_nac' => $nacimiento];

    $valido = operarBd($sql, $params);

    if ($valido)
      echo "Se agregó el empleado $nombre correctamente <br>";
  }

  function insertarEmpleDpto($dni, $codDpto, $nombre) {
    if ($codDpto == null) {
      echo "No se le asignó ningún departamento al empleado $nombre";
      return;
    }

    $sql = "INSERT INTO emple_dpto (dni, cod_dpto, fecha_ini, fecha_fin)
              VALUES (:dni, :cod_dpto, NOW(), NULL)";
    $params = [':dni' => strtoupper($dni), ':cod_dpto' => $codDpto];

    $valido = operarBd($sql, $params);

    if ($valido)
      echo "Se le asigno el departamento con ID $codDpto al empleado $nombre";
  }
?>