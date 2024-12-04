<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Alta almacenes - Web Compras</title>
    <link rel='stylesheet' href='../css/comun.css'>
  </head>
  <body>
    <?php
      include '../handlerErrores.php';
      include '../conexionBd.php';
      include 'fComregcli.php';
    ?>

    <nav>
      <a href='../gestionInternaClientes.html'>Atrás</a>
      <a href='comregcli.php'>Registro de clientes</a>
      <a href='comlogincli.php'>Login</a>
    </nav>

    <div>
      <b>Registrarse</b>
      <br><br>
    </div>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>NIF: </b><input type='text' name='nif'>
      <br><br>
      <b>Nombre: </b><input type='text' name='nombre'>
      <br><br>
      <b>Apellido: </b><input type='text' name='apellido'>
      <br><br>
      <b>CP: </b><input type='text' name='cp'>
      <br><br>
      <b>Dirección: </b><input type='text' name='direccion'>
      <br><br>
      <b>Ciudad: </b><input type='text' name='ciudad'>
      <br><br>
      <input type='submit' value='Registrar cliente'>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nif = $_POST['nif'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $cp = $_POST['cp'];
        $direccion = $_POST['direccion'];
        $ciudad = $_POST['ciudad'];
        
        limpiar($nif);
        limpiar($nombre);
        limpiar($apellido);
        limpiar($cp);
        limpiar($direccion);
        limpiar($ciudad);
        
        $usuario = generarUsuario($nombre);

        validarNif($nif);
        buscarNifRepetido($nif);
        validarUsuario($usuario);
        buscarUsuarioRepetido($usuario);

        $clave = generarClave($apellido);

        registrarCliente($nif, $nombre, $apellido, $cp, $direccion, $ciudad, $usuario, $clave);
      }
    ?>
  </body>
</html>