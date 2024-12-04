<?php
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  function generarUsuario($nombre) {
    return str_replace(' ', '', strtolower($nombre));
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

  function validarUsuario($usuario) {
    if ($usuario == '')
      trigger_error('El nombre no puede estar vacio', E_USER_WARNING);
  }

  function buscarUsuarioRepetido($usuario) {
    $resultado = buscarUsuario($usuario);

    if (!empty($resultado))
      trigger_error('Ya existe un cliente con ese nombre', E_USER_WARNING);
  }

  function buscarUsuario($usuario) {
    $sql = "SELECT usuario
              FROM cliente
              WHERE usuario = :usuario";
    $params = [':usuario' => $usuario];

    return operarBd($sql, $params);
  }

  function generarClave($apellido) {
    return password_hash(strrev(str_replace(' ', '', strtolower($apellido))), PASSWORD_BCRYPT);
  }

  function registrarCliente($nif, $nombre, $apellido, $cp, $direccion, $ciudad, $usuario, $clave) {
    $valido = registrar($nif, $nombre, $apellido, $cp, $direccion, $ciudad, $usuario, $clave);

    if ($valido)
      echo "Se registró el cliente con NIF $nif correctamente. Su usuario es $usuario y la clave es " . strrev(str_replace(' ', '', strtolower($apellido)));
  }

  function registrar($nif, $nombre, $apellido, $cp, $direccion, $ciudad, $usuario, $clave) {
    $sql = "INSERT INTO cliente(nif, nombre, apellido, cp, direccion, ciudad, usuario, clave)
              VALUES(:nif, :nombre, :apellido, :cp, :direccion, :ciudad, :usuario, :clave)";
    $params = [':nif' => $nif, ':nombre' => $nombre, ':apellido' => $apellido, ':cp' => $cp, ':direccion' => $direccion, ':ciudad' => $ciudad, ':usuario' => $usuario, ':clave' => $clave];

    return operarBd($sql, $params);
  }
?>