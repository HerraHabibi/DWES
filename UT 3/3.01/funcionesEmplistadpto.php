<?php
  function validarDpto($codDpto) {
    if ($codDpto == '')
      trigger_error('Debes seleccionar un departamento', E_USER_WARNING);
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

  function visualizarTrabajadores($codDpto) {
    $sql = "SELECT emple_dpto.dni, emple.nombre
              FROM emple_dpto
              INNER JOIN emple ON emple_dpto.dni = emple.dni
              WHERE emple_dpto.cod_dpto = '$codDpto'
              AND emple_dpto.fecha_fin IS NULL";
    $resultado = operarBd($sql);

    if (empty($resultado))
      echo 'No hay trabajadores en este departamento';

    else
      foreach ($resultado as $trabajador) {
        echo '<li>' . $trabajador['dni'] . ' - ' . $trabajador['nombre'] . '</li>';
      }
  }
?> 