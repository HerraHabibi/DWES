<?php
  // Función para mostrar las opciones de los trabajadores de RRHH
  function mostrarOpcionesRrhh() {
    if(esRrhh()) {
      echo "<a href='alta_empleado'>Alta empleado</a>";
      echo "<br>";
      echo "<a href='alta_masiva_empleados'>Alta masiva empleados</a>";
      echo "<br>";
      echo "<a href='modificar_salario'>Modificar salario</a>";
      echo "<br>";
      echo "<a href='vida_laboral'>Vida laboral</a>";
      echo "<br>";
      echo "<a href='info_departamentos'>Info departamentos</a>";
      echo "<br>";
      echo "<a href='cambio_departamento'>Cambio departamento</a>";
      echo "<br>";
      echo "<a href='nuevo_jefe_departamento'>Nuevo jefe departamento</a>";
      echo "<br>";
      echo "<a href='baja_empleado'>Baja empleado</a>";
      echo "<br>";
    }
  }
?>