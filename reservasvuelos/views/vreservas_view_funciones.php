<?php
  // Función para mostrar en el select los vuelos disponibles
  function selectVuelosDisponibles() {
    $vuelos = datosVuelosDisponibles();

    echo "<option value='' selected disabled>- SELECCIONA -</option>";
    foreach ($vuelos as $vuelo)
      echo "<option value='" . $vuelo['id_vuelo'] . "'>" . $vuelo['origen'] . ' > ' . $vuelo['destino'] . "</option>";
  }

  // Función para mostrar los vuelos agregados al carrito
  function mostrarVuelosAgregados($vuelosAgregados) {
    if (isset($vuelosAgregados[$_SESSION['usuario']])) {
      $vuelos = $vuelosAgregados[$_SESSION['usuario']];
      crearTablaVuelos($vuelos);
    } else
      echo 'Aún no has agregado ningún vuelo';
  }

  // Función para crear la tabla de los vuelos agregados al carrito
  function crearTablaVuelos($vuelos) {
    echo "<table border='1' style='border-collapse: collapse; width: 810px; text-align: left;'>";
      echo '<tr>';
        echo '<th>Origen</th>';
        echo '<th>Destino</th>';
        echo '<th>Fecha de salida</th>';
        echo '<th>Fecaha de llegada</th>';
        echo '<th>Aerolínea</th>';
        echo '<th>Precio por asiento</th>';
        echo '<th>Asientos reservados</th>';
        echo '<th>Precio total</th>';
      echo '</tr>';
    foreach ($vuelos as $vuelo) {
      echo '<tr>';
        echo '<td>' . datosVuelo($vuelo['vuelo'])['origen'] . '</td>';
        echo '<td>' . datosVuelo($vuelo['vuelo'])['destino'] . '</td>';
        echo '<td>' . datosVuelo($vuelo['vuelo'])['fechahorasalida'] . '</td>';
        echo '<td>' . datosVuelo($vuelo['vuelo'])['fechahorallegada'] . '</td>';
        echo '<td>' . datosVuelo($vuelo['vuelo'])['nombre_aerolinea'] . '</td>';
        echo '<td>' . datosVuelo($vuelo['vuelo'])['precio_asiento'] . ' €</td>';
        echo '<td>' . $vuelo['asientos'] . '</td>';
        echo '<td>' . datosVuelo($vuelo['vuelo'])['precio_asiento'] * $vuelo['asientos'] . ' €</td>';
      echo '</tr>';
    }
    echo '</table>';
  }
?>