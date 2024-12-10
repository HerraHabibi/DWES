<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Login - Web Pedidos</title>
    <link rel='stylesheet' href='css/login.css'>
  </head>
  <body>
    <?php
      session_start();
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_login.php';
    ?>

    <?php
      if(isset($_SESSION['usuario'])) {
        // redireccionar('pe_inicio.php');
    ?>
        <h1>¡Hola <?php echo $_SESSION['usuario']; ?>!</h1>
        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
          <button type='submit' name='action' value='cerrarSesion'>Cerrar sesión</button>
        </form>
    <?php
      } else {
        logout();
    ?>
        <h1>Iniciar sesión</h1>

        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
          <b>Usuario: </b><input type='text' name='usuario'>
          <br><br>
          <b>Contraseña: </b><input type='text' name='clave'>
          <br><br>
          <button type='submit' name='action' value='iniciarSesion'>Iniciar sesión</button>
          <br><br>
        </form>
    <?php
      }
    ?>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'iniciarSesion') {
          $usuario = $_POST['usuario'];
          $clave = $_POST['clave'];
          
          limpiar($usuario);
          limpiar($clave);

          login($usuario, $clave);
          redireccionar('pe_inicio.php');
        }

        if (isset($_POST['action']) && $_POST['action'] === 'cerrarSesion') {
          logout();
          redireccionar('pe_login.php');
        }
      }
    ?>
  </body>
</html>