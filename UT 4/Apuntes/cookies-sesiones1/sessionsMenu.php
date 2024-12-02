<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Sessions - Menú</title>
  </head>
  <body>
    <?php
      include 'handlerErrores.php';
      include 'conexionBd.php';
      include 'funcionesSessions.php';
    ?>

    <div>
      <b>SESSIONS - MENÚ</b>
      <br><br>
    </div>

    <?php
      if(isset($_SESSION['usuario'])) {
        echo 'Hola ' . $_SESSION['usuario'] . '!<br><br>';
    ?>

      <nav>
        <b>MENÚ</b>
        <ul>
          <li><a href='./sessions1.php'>Página 1</a></li>
          <li><a href='./sessions2.php'>Página 2</a></li>
          <li><a href='./sessions3.php'>Página 3</a></li>
        </ul>
        <br>
      </nav>

    <?php
      } else {
        echo 'Necesitas <a href="./sessions.php">iniciar sesión</a> para acceder a esta página.<br>';
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