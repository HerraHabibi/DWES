<?php
  function validarFecha($fecha) {
    if ($fecha == '')
      trigger_error('Debes introducir una fecha', E_USER_WARNING);
  }

  function verTrabajadoresEnFecha($fecha) {
    $sql = "SELECT emple.nombre AS empleado, dpto.nombre AS departamento
              FROM emple
              INNER JOIN emple_dpto ON emple.dni = emple_dpto.dni
              INNER JOIN dpto ON emple_dpto.cod_dpto = dpto.cod_dpto
              WHERE emple_dpto.fecha_ini <= :fecha
                AND (emple_dpto.fecha_fin IS NULL OR emple_dpto.fecha_fin >= :fecha)";
    $resultado = operarBd($sql, array(':fecha' => $fecha));

    if (empty($resultado))
      echo "Ningún empleado trabajaba el día $fecha";
    else {
      echo "<bold>Empleados en la fecha $fecha</bold>";
      echo "<ul>";
      foreach ($resultado as $registro) {
        echo '<li>' . $registro['empleado'] . ": " . $registro['departamento'] . '</li>';
      }
      echo "</ul>";
    }
  }
?>