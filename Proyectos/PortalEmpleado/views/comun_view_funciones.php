<?php
  function selectDepartamentos() {
    $departamentos = datosDepartamentos();

    echo "<label for='departamento'>Departamento </label>";
    echo "<select id='departamento' name='departamento'>";
      echo "<option value='' selected disabled>- SELECCIONA -</option>";
      foreach ($departamentos as $departamento)
        echo "<option value='" . $departamento['dept_no'] . "'>" . $departamento['dept_name'] . "</option>";
    echo "</select>";
  }

  function selectEmpleados() {
    $empleados = datosEmpleados();

    echo "<label for='numEmpleado'>Empleado </label>";
    echo "<select id='numEmpleado' name='numEmpleado'>";
      echo "<option value='' selected disabled>- SELECCIONA -</option>";
      foreach ($empleados as $empleado)
        echo "<option value='" . $empleado['emp_no'] . "'>" . $empleado['emp_no'] . ' - ' . $empleado['first_name'] . ' ' . $empleado['last_name'] . "</option>";
    echo "</select>";
  }
?>