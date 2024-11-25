<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Cookies - Página 2</title>
  </head>
  <body>
    <?php
      include 'handlerErrores.php';
      include 'conexionBd.php';
      include 'funcionesCookies.php';
    ?>

    <div>
      <b>COOKIES - PÁGINA 2</b>
      <br><br>
    </div>

    <nav>
      <b>MENÚ</b>
      <ul>
        <li><a href='./cookies.php'>Login</a></li>
        <li><a href='./cookies1.php'>Página 1</a></li>
        <li><a href='./cookies2.php'>Página 2</a></li>
        <li><a href='./cookies3.php'>Página 3</a></li>
      </ul>
      <br>
    </nav>

    <?php
      if(!isset($_COOKIE['usuario'])) {
        echo 'Necesitas iniciar sesión para acceder a esta página.<br>';

      } else {
        echo 'Hola ' . $_COOKIE['usuario'] . '<br>';
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