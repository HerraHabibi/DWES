<?php
  function selectDnis() {
    $sql = "SELECT dni
              FROM emple";
    $resultado = operarBd($sql);
    
    echo "<select name='dni'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $registro) {
      echo "<option value='" . $registro['dni'] . "'>" . $registro['dni'] . "</option>";
    }
    echo "</select>";
  }

  function selectDptos() {
    $sql = "SELECT cod_dpto, nombre
              FROM dpto";
    $resultado = operarBd($sql);
    
    echo "<select name='cod_dpto'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $registro) {
      echo "<option value='" . $registro['cod_dpto'] . "'>" . $registro['nombre'] . "</option>";
    }
    echo "</select>";
  }

  function validarDni($dni) {
    if ($dni == '')
      trigger_error('Debes seleccionar un DNI', E_USER_WARNING);
  }

  function validarDpto($codDpto) {
    if ($codDpto == '')
      trigger_error('Debes seleccionar un departamento', E_USER_WARNING);
  }

  function quitarActualDpto($dni) {
    $sql = "UPDATE emple_dpto 
              SET fecha_fin = NOW()
              WHERE dni = :dni AND fecha_fin IS NULL";
    $params = [':dni' => $dni];

    $resultado = operarBd($sql, $params);
  }

  function asignarNuevoDpto($dni, $codDpto) {
    $sql = "INSERT INTO emple_dpto (dni, cod_dpto, fecha_ini, fecha_fin)
              VALUES (:dni, :cod_dpto, NOW(), NULL)";
    $params = [':dni' => strtoupper($dni), ':cod_dpto' => $codDpto];

    $valido = operarBd($sql, $params);

    if ($valido)
      echo "Se le cambió el departamento al empleado con DNI $dni a el departamento con ID $codDpto";
  }
?>