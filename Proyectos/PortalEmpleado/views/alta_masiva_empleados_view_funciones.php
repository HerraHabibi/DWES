<?php
  function mostrarEmpleadosAgregados($empleadosCreados) {
    if (isset($empleadosCreados[$_SESSION['usuario']])) {
      $empleados = $empleadosCreados[$_SESSION['usuario']];
      crearTablaEmpleados($empleados);
    } else
      echo 'Aún no has agregado ningún empleado';
  }

  function crearTablaEmpleados($empleados) {
    echo "<table border='1' style='border-collapse: collapse; width: 810px; text-align: left;'>";
      echo '<tr>';
        echo '<th>Nombre</th>';
        echo '<th>Apellidos</th>';
        echo '<th>Género</th>';
        echo '<th>Nacimiento</th>';
        echo '<th>Departamento</th>';
        echo '<th>Salario</th>';
        echo '<th>Cargo</th>';
      echo '</tr>';
    foreach ($empleados as $empleado) {
      echo '<tr>';
        echo '<td>' . $empleado['nombre'] . '</td>';
        echo '<td>' . $empleado['apellidos'] . '</td>';
        echo '<td>' . $empleado['genero'] . '</td>';
        echo '<td>' . $empleado['nacimiento'] . '</td>';
        echo '<td>' . obtenerNombreDepartamento($empleado['departamento']) . '</td>';
        echo '<td>' . $empleado['salario'] . '</td>';
        echo '<td>' . $empleado['cargo'] . '</td>';
      echo '</tr>';
    }
    echo '</table>';
  }
?>