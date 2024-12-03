<?php
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  function validarNif($nif) {
    $regex = '/^[0-9]{8}[A-Za-z]$/';

    if (!preg_match($regex, $nif))
      trigger_error('Debes introducir un DNI válido', E_USER_WARNING);
  }

  function buscarNifRepetido($nif) {
    $resultado = buscarNif($nif);

    if (!empty($resultado))
      trigger_error('Ya existe un cliente con ese NIF', E_USER_WARNING);
  }

  function buscarNif($nif) {
    $sql = "SELECT nif
              FROM cliente
              WHERE nif = :nif";
    $params = [':nif' => $nif];

    return operarBd($sql, $params);
  }

  function registrarCliente($nif, $nombre, $cp, $direccion, $ciudad) {
    $valido = registrar($nif, $nombre, $cp, $direccion, $ciudad);

    if ($valido)
      echo "Se registró el cliente con NIF $nif correctamente";
  }

  function registrar($nif, $nombre, $cp, $direccion, $ciudad) {
    $sql = "INSERT INTO cliente(nif, nombre, cp, direccion, ciudad)
              VALUES(:nif, :nombre, :cp, :direccion, :ciudad)";
    $params = [':nif' => $nif, ':nombre' => $nombre, ':cp' => $cp, ':direccion' => $direccion, ':ciudad' => $ciudad];

    return operarBd($sql, $params);
  }
?>