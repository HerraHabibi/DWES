<?php
  // Función para comprobar si las fechas introducidas están vacías
  function comprobarFechas(&$desde, &$hasta) {
    if ($desde == '')
      $desde = '1000-01-01';

    if ($hasta == '')
      $hasta = date('Y-m-d');
  }

  function compararFechas($desde, $hasta) {
    if (date('Y-m-d', strtotime($desde)) > date('Y-m-d', strtotime($hasta)))
      trigger_error('La fecha de inicio debe ser anterior a la de fin', E_USER_WARNING);
  }

  function mostrarAlquileres($alquileres) {
    if (empty($alquileres))
      echo 'No has alquilado ningún vehículo entre estas fechas<br>';

    else {
      echo "<table border='1' style='border-collapse: collapse; text-align: center;'>";
      echo '<tr>';
      echo '<th>Matrícula</th>';
      echo '<th>Fecha de alquiler</th>';
      echo '<th>Fecha de devolución</th>';
      echo '<th>Precio total</th>';
      echo '<th>Fecha hora pago</th>';
      echo '</tr>';
      foreach ($alquileres as $alquiler) {
        formatearHora($alquiler['fecha_alquiler']);

        if ($alquiler['fecha_devolucion'] != null) {
          formatearHora($alquiler['fecha_devolucion']);
          formatearHora($alquiler['fechahorapago']);
        } else {
          $alquiler['fecha_devolucion'] = 'PENDIENTE';
          $alquiler['preciototal'] = '-';
          $alquiler['fechahorapago'] = '-';
        }

        echo '<tr>';
        echo '<td>' . $alquiler['matricula'] . '</td>';
        echo '<td>' . $alquiler['fecha_alquiler'] . '</td>';
        echo '<td>' . $alquiler['fecha_devolucion'] . '</td>';
        echo '<td>' . $alquiler['preciototal'] . '</td>';
        echo '<td>' . $alquiler['fechahorapago'] . '</td>';
        echo '</tr>';
      }
      echo '</table>';
    }
  }

  function formatearHora(&$fechaHora) {
    $timestamp = strtotime($fechaHora);
    $fechaHora = date('d/m/Y H:i:s', $timestamp);
  }
?>