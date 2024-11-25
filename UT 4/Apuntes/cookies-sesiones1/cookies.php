<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Cookies - Login</title>
  </head>
  <body>
    <?php
      include 'handlerErrores.php';
      include 'conexionBd.php';
      include 'funcionesCookies.php';
    ?>

    <div>
      <b>COOKIES - LOGIN</b>
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
      if(isset($_COOKIE['usuario'])) {
        echo 'Hola ' . $_COOKIE['usuario'] . '<br>';

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

        logearse($usuario, $pass);
      }
    ?>
  </body>
</html>