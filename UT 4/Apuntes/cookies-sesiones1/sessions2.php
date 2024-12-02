<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Sessions - Página 1</title>
  </head>
  <body>
    <?php
      include 'handlerErrores.php';
      include 'conexionBd.php';
      include 'funcionesSessions.php';
    ?>

    <div>
      <b>SESSIONS - PÁGINA 1</b>
      <br><br>
    </div>

    <a href='./sessionsMenu.php'>Volver al menú</a>
    <br><br>

    <?php
      if(!isset($_SESSION['usuario'])) {
        echo 'Necesitas <a href="./sessions.php">iniciar sesión</a> para acceder a esta página.<br>';

      } else {
        echo 'Hola ' . $_SESSION['usuario'] . '<br>';
    ?>
        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
          <input type='submit' value='Cerrar sesión'>
        </form>
    <?php
      }
    ?>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        logout();
      }
    ?>
  </body>
</html>