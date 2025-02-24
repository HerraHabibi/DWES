<?php
  // Función para agregar un vuelo a la cookie
  function agregarVuelo(&$vuelosAgregados,  $vuelo, $asientos) {
    // Si existe la cookie de los vuelos la pasamos a array, sino creamos un array vacío
    $vuelosAgregados = isset($_COOKIE['vuelosAgregados']) ? unserialize($_COOKIE['vuelosAgregados']) : array();
    
    // Creamos el array de vuelos del usuario si es que no existe
    if (!isset($vuelosAgregados[$_SESSION['usuario']]))
      $vuelosAgregados[$_SESSION['usuario']] = array();

    $yaEnCesta = false;
    
    // Si se elige un vuelo que ya estaba agregado se suman los asientos
    foreach ($vuelosAgregados[$_SESSION['usuario']] as &$vueloAgregado) {
      if ($vueloAgregado['vuelo'] == $vuelo) {
          $vueloAgregado['asientos'] += $asientos;
          $yaEnCesta = true;
          break;
      }
    }

    // Sino se añade al array
    if (!$yaEnCesta)
      $vuelosAgregados[$_SESSION['usuario']][] = array(
        'vuelo' => $vuelo,
        'asientos' => $asientos,
      );
    
    // Pasar el array de los vuelos a cookie
    setcookie('vuelosAgregados', serialize($vuelosAgregados), time() + (10 * 365 * 24 * 60 * 60), '/');
  }

  // Función para vaciar los vuelos agregados
  function vaciarVuelos() {
    $vuelosAgregados = isset($_COOKIE['vuelosAgregados']) ? unserialize($_COOKIE['vuelosAgregados']) : array();

    if (isset($vuelosAgregados[$_SESSION['usuario']])) {
      unset($vuelosAgregados[$_SESSION['usuario']]);
      if (!empty($vuelosAgregados))
        setcookie('vuelosAgregados', serialize($vuelosAgregados), time() + (10 * 365 * 24 * 60 * 60), '/');
      else
        setcookie('vuelosAgregados', '', time() - 3600, '/');
    }
  }

  // Función para comprobar si hay asientos disponibles
  function comprobarAsientosDisponibles() {
    $vuelosAgregados = isset($_COOKIE['vuelosAgregados']) ? unserialize($_COOKIE['vuelosAgregados']) : array();
    
    if (!isset($vuelosAgregados[$_SESSION['usuario']]))
      trigger_error('Aún no has hecho ninguna reserva', E_USER_WARNING);

    foreach ($vuelosAgregados[$_SESSION['usuario']] as $vueloAgregado) {
      if ($vueloAgregado['asientos'] > datosVuelo($vueloAgregado['vuelo'])['asientos_disponibles'])
        trigger_error('No hay asientos disponibles para hacer esta compra', E_USER_WARNING);
    }
  }

  // Función para hacer la reserva
  function hacerReserva() {
    $vuelosAgregados = isset($_COOKIE['vuelosAgregados']) ? unserialize($_COOKIE['vuelosAgregados']) : array();
    $vuelosAgregados = $vuelosAgregados[$_SESSION['usuario']];

    $dni = buscarDni($_SESSION['usuario']);

    $idReserva = obtenerUltIdReserva();
    $idReserva = generarIdReserva($idReserva);

    $precioTotal = 0;

    foreach ($vuelosAgregados as $vueloAgregado) {
      $precio = datosVuelo($vueloAgregado['vuelo'])['precio_asiento'] * $vueloAgregado['asientos'];

      anadirReserva($idReserva, $vueloAgregado['vuelo'], $dni, $vueloAgregado['asientos'], $precio);
      ocuparAsientos($vueloAgregado['vuelo'], $vueloAgregado['asientos']);

      $precioTotal += $precio;
    }

    return $precioTotal;
  }

  // Función para generar el id de la reserva
  function generarIdReserva($idReserva) {
    if (!empty($idReserva))
      $idReserva = intval(substr($idReserva, 1) + 1);
    else
      $idReserva = 1;

    $idReserva = 'R' . str_pad($idReserva, 4, '0', STR_PAD_LEFT);

    return $idReserva;
  }
?>