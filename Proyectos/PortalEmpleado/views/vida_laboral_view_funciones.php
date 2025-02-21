<?php
  function mostrarDatosEmpleado($numEmpleado) {
    $datosEmpleado = datosEmpleado($numEmpleado)[0];

    echo "<table border='1' style='border-collapse: collapse; width: 700px; text-align: left;'>";
    echo '<tr>';
    echo '<th>Número de empleado</th>';
    echo '<th>Nombre</th>';
    echo '<th>Apellidos</th>';
    echo '<th>Fecha de nacimiento</th>';
    echo '<th>Género</th>';
    echo '<th>Fecha de contratación</th>';
    echo '</tr>';
  
    echo '<tr>';
    echo '<td>' . $datosEmpleado['emp_no'] . '</td>';
    echo '<td>' . $datosEmpleado['first_name'] . '</td>';
    echo '<td>' . $datosEmpleado['last_name'] . '</td>';
    echo '<td>' . $datosEmpleado['birth_date'] . '</td>';
    echo '<td>' . $datosEmpleado['gender'] . '</td>';
    echo '<td>' . $datosEmpleado['hire_date'] . '</td>';
    echo '</tr>';
    echo '</table>';
  }
    
  function mostrarDepartamentosEmpleado($numEmpleado) {
    $departamentosEmpleado = departamentosEmpleado($numEmpleado);

    echo "<table border='1' style='border-collapse: collapse; width: 500px; text-align: left;'>";
    echo '<tr>';
    echo '<th>Departamento</th>';
    echo '<th>Desde</th>';
    echo '<th>Hasta</th>';
    echo '</tr>';
  
    foreach($departamentosEmpleado as $departamentosEmpleado) {
      echo '<tr>';
      echo '<td>' . $departamentosEmpleado['department'] . '</td>';
      echo '<td>' . $departamentosEmpleado['from_date'] . '</td>';
      echo '<td>' . $departamentosEmpleado['to_date'] . '</td>';
    }
    echo '</table>';
  }
  
  function mostrarSalariosEmpleado($numEmpleado) {
    $salariosEmpleado = salariosEmpleado($numEmpleado);

    echo "<table border='1' style='border-collapse: collapse; width: 500px; text-align: left;'>";
    echo '<tr>';
    echo '<th>Salario</th>';
    echo '<th>Desde</th>';
    echo '<th>Hasta</th>';
    echo '</tr>';
  
    foreach($salariosEmpleado as $salarioEmpleado) {
      echo '<tr>';
      echo '<td>' . $salarioEmpleado['salary'] . ' €</td>';
      echo '<td>' . $salarioEmpleado['from_date'] . '</td>';
      echo '<td>' . $salarioEmpleado['to_date'] . '</td>';
    }
    echo '</table>';
  }

  function mostrarCargosEmpleado($numEmpleado) {
    $cargosEmpleado = cargosEmpleado($numEmpleado);

    echo "<table border='1' style='border-collapse: collapse; width: 500px; text-align: left;'>";
    echo '<tr>';
    echo '<th>Salario</th>';
    echo '<th>Desde</th>';
    echo '<th>Hasta</th>';
    echo '</tr>';
  
    foreach($cargossEmpleado as $cargoEmpleado) {
      echo '<tr>';
      echo '<td>' . $cargoEmpleado['salary'] . ' €</td>';
      echo '<td>' . $cargoEmpleado['from_date'] . '</td>';
      echo '<td>' . $cargoEmpleado['to_date'] . '</td>';
    }
    echo '</table>';
  }

  function mostrarSiEsJefe($numEmpleado) {
    $jefe = obtenerSiEsjefe($numEmpleado);

    if (!empty($jefe))
      echo 'Es jefe del departamento de ' . $jefe[0]['department'];
    else
      echo 'No es jefe de departamento';
  }
?>