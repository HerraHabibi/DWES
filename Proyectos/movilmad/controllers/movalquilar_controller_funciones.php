<?php
  // Función para mostrar en el select los vehículos disponibles
  function selectVehiculosDisponibles() {
    $vehiculosDisponibles = obtenerVehiculosDisponibles();

    echo "<option value='' disabled selected>-- SELECCIONA --</option>";

    foreach ($vehiculosDisponibles as $vehiculo)
      echo "<option value='" . $vehiculo['matricula'] . "'>" . $vehiculo['marca'] . ' - ' . $vehiculo['modelo'] . '</option>';
  }

  // Función para mostrar la fecha y hora actual
  function mostrarFechaHora() {
    date_default_timezone_set('Europe/Madrid');
    echo date('d/m/Y H:i');
  }

  // Función para ejecutar la lógica de agregar un vehículo a la cesta
  function agregarACesta(&$cesta) {
    $vehiculo = isset($_POST['vehiculos']) ? $_POST['vehiculos'] : '';
    
    limpiar($vehiculo);
    verificarVehiculo($vehiculo);

    comprobarDisponibilidad($vehiculo);

    crearCesta($cesta, $vehiculo);

    echo 'Vehículo añadido al cesta <br>';
  }

  // Función para comprobar si se ha seleccionado un vehículo
  function verificarVehiculo($vehiculo) {
    if ($vehiculo == '')
      trigger_error('Debes seleccionar un vehículo', E_USER_WARNING);
  }

  // Funcioón para comprobar la disponibilidad del vehículo seleccionado
  function comprobarDisponibilidad($vehiculo) {
    $disponible = obtenerDisponibilidadVehiculo($vehiculo);

    if ($disponible != 'S')
      trigger_error('El vehículo ya no se encuentra disponible', E_USER_WARNING);
  }

  // Función para crear la cookie de la cesta del usuario
  function crearCesta(&$cesta, $vehiculo) {
    // Si existe la cookie del cesta la pasamos a array, sino creamos un array vacío
    $cesta = isset($_COOKIE['cesta']) ? unserialize($_COOKIE['cesta']) : array();
    
    // Creamos el cesta del usuario si es que no existe
    if (!isset($cesta[$_SESSION['usuario']]))
      $cesta[$_SESSION['usuario']] = array();

    // Verificamos que no tenga 3 vehículos en la cesta
    if (count($cesta[$_SESSION['usuario']]) == 3)
      trigger_error('No puedes agregar más de 3 vehículos al cesta', E_USER_WARNING);

    // Agregamos el vehículo al cesta en caso de que no lo tenga
    if (!in_array($vehiculo, $cesta[$_SESSION['usuario']]))
      $cesta[$_SESSION['usuario']][] = $vehiculo;
    else
      trigger_error('Ya tienes este vehículo en el cesta', E_USER_WARNING);
    
    // Pasar el array de la cesta a cookie
    setcookie('cesta', serialize($cesta), time() + (10 * 365 * 24 * 60 * 60), '/');
  }

  // Función para mostrar la cesta en caso de que tenga vehículos en ella
  function mostrarCesta($cestaUsuario) {
    if (isset($cestaUsuario))
      crearTablaVehiculos($cestaUsuario);
    else
      echo 'No tienes productos en el cesta <br>';
  }

  // Función para crear la tabla de un array de vehiculos
  function crearTablaVehiculos($vehiculos) {
    echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
    echo '<tr>';
    echo '<th>Matrícula</th>';
    echo '<th>Marca</th>';
    echo '<th>Modelo</th>';
    echo '</tr>';
    foreach ($vehiculos as $vehiculo) {
      echo '<tr>';
      echo "<td>$vehiculo</td>";
      echo '<td>' . obtenerInfoVehiculo($vehiculo)['marca'] . '</td>';
      echo '<td>' . obtenerInfoVehiculo($vehiculo)['modelo'] . '</td>';
      echo '</tr>';
    }    
    echo '</table>';
  }

  function alquilarVehiculos() {
    $cesta = isset($_COOKIE['cesta']) ? unserialize($_COOKIE['cesta']) : array();

    if (!isset($cesta[$_SESSION['usuario']]))
      trigger_error('No tienes vehículos en la cesta', E_USER_WARNING);

    $vehiculosAlquilados = obtenerVehiculosAlquiladosPorUsuario($_SESSION['usuario']);

    if (count($vehiculosAlquilados) == 3)
      trigger_error('Ya has alquilado 3 vehículos', E_USER_WARNING);

    foreach ($cesta[$_SESSION['usuario']] as $vehiculo) {
      insertarAlquilarVehiculo($_SESSION['usuario'], $vehiculo);
      cambiarDisponibilidadVehiculo($vehiculo, 'N');
    }
    
    echo 'Has alquilado los vehículos: <br>';
    crearTablaVehiculos($cesta[$_SESSION['usuario']]);

    vaciarCesta();
  }

  // Función para vaciar la cesta
  function vaciarCesta() {
    $cesta = isset($_COOKIE['cesta']) ? unserialize($_COOKIE['cesta']) : array();

    if (isset($cesta[$_SESSION['usuario']])) {
      unset($cesta[$_SESSION['usuario']]);
      if (!empty($cesta))
        setcookie('cesta', serialize($cesta), time() + (10 * 365 * 24 * 60 * 60), '/');
      else
        setcookie('cesta', '', time() - 3600, '/');
    }
  }
?>