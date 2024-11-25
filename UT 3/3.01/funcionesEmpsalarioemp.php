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

  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    $value = strtoupper($value);
  }

  function validarDni($dni) {
    if ($dni == '')
      trigger_error('Debes seleccionar un DNI', E_USER_WARNING);
  }

  function validarPorcentaje($porcentaje) {
    if ($porcentaje == '' || !is_numeric($porcentaje) || $porcentaje == 0)
      trigger_error('Debes introducir un porcentaje', E_USER_WARNING);
  }

  function modificarSalario($dni, $porcentaje) {
    $sql = "UPDATE emple
              SET salario = salario * (1 + ($porcentaje / 100))
              WHERE dni = '$dni'";
    operarBd($sql);

    echo "El salario del empleado $dni se ha modificado un $porcentaje%";
  }
?>