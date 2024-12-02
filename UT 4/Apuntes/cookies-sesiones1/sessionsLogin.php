<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Sessions - Login</title>
  </head>
  <body>
    <?php
      include 'handlerErrores.php';
      include 'conexionBd.php';
      include 'funcionesSessions.php';
    ?>

    <div>
      <b>SESSIONS - LOGIN</b>
      <br><br>
    </div>

    <?php
      if(isset($_SESSION['usuario'])) {
        echo 'Sesión iniciada con el usuario ' . $_SESSION['usuario'] . '<br>';

        header('Location: sessionsMenu.php');
        exit;

      } else {
    ?>
        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
          <div>
            <b>Usuario: </b><input type='text' name='usuario'>
            <br><br>
            <b>Contraseña: </b><input type='password' name='pass'>
            <br><br>
            <input type='submit' value='Iniciar sesión'>
          </div>
        </form>
    <?php
      }
    ?>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario = $_POST['usuario'];
        $pass = $_POST['pass'];

        login($usuario, $pass);
      }
    ?>
  </body>
</html>