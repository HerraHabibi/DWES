<?php
  // Inicio de la sesión
  session_start();
?>

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

    <nav>
      <b>MENÚ</b>
      <ul>
        <li><a href='./sessions.php'>Login</a></li>
        <li><a href='./sessions1.php'>Página 1</a></li>
        <li><a href='./sessions2.php'>Página 2</a></li>
        <li><a href='./sessions3.php'>Página 3</a></li>
      </ul>
      <br>
    </nav>

    <?php
      if(isset($_SESSION['usuario'])) {
        echo 'Hola ' . $_SESSION['usuario'] . '<br>';

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