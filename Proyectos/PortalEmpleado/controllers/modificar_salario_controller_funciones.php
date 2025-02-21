<?php
  function comprobarMismoDia($numEmpleado) {
    $diaModificacion = obtenerDiaUltimaModificacion($numEmpleado);

    if (!empty($diaModificacion)) {
      $diaModificacion = $diaModificacion[0]['from_date'];
      
      if ($diaModificacion == date('Y-m-d'))
        trigger_error('No se puede modificar el salario de un empleado más de una vez en el mismo día', E_USER_WARNING);
    }
  }

  function comprobarMismoSalario($numEmpleado, $salario) {
    $salarioAntiguo = obtenerSalarioEmpleado($numEmpleado);

    if (!empty($salarioAntiguo)) {
      $salarioAntiguo = $salarioAntiguo[0]['salary'];

      if ($salario == $salarioAntiguo)
        trigger_error('Debes seleccionar un salario diferente al anterior', E_USER_WARNING);
    }
  }
?>