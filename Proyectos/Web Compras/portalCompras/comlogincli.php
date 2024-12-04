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
      include 'fComlogincli.php';
    ?>

    <nav>
      <a href='../gestionInternaClientes.html'>Atrás</a>
      <a href='comregcli.php'>Registro de clientes</a>
      <a href='comlogincli.php'>Login</a>
    </nav>

    <div>
      <b>Iniciar sesión</b>
      <br><br>
    </div>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Usuario: </b><input type='text' name='usuario'>
      <br><br>
      <b>Contraseña: </b><input type='text' name='clave'>
      <br><br>
      <input type='submit' value='Iniciar sesión'>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        
        limpiar($usuario);
        limpiar($clave);

        login($usuario, $clave);
      }
    ?>
  </body>
</html>