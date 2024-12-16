<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Login - Web Pedidos</title>
    <style>
      body {
        background-color: #274923;
      }
    </style>
  </head>
  <body>
    <?php
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_login.php';
    ?>

    <?php
      if(isset($_SESSION['usuario'])) {
        redireccionar('pe_inicio.php');

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
          <button type='submit' name='action' value='registro'>Ir al registro</button>
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

        if (isset($_POST['action']) && $_POST['action'] === 'registro') {
          redireccionar('pe_registro.php');
        }
      }
    ?>
  </body>
</html>