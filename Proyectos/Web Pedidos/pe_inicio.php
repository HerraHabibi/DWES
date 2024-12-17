<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Inicio - Web Pedidos</title>
  </head>
  <body>
    <?php
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_inicio.php';
    ?>

    <?php
      if(!isset($_SESSION['usuario'])) {
        logout();
        redireccionar('pe_login.php');

      } else {
        if (isset($_COOKIE['usuario']))
          setcookie('usuario', '', time() - 3600, '/');
        if (isset($_COOKIE['clave']))
          setcookie('clave', '', time() - 3600, '/');
    ?>
        <h1>Inicio</h1>
        <h2>¡Hola <?php echo $_SESSION['usuario']; ?>!</h2>

        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
          <button type='submit' name='action' value='cerrarSesion'>Cerrar sesión</button>
        </form>
        <ol start='2'>
          <li><a href='pe_altaped.php'>Hacer pedido</a></li>
          <li><a href='pe_consped.php'>Consultar la información de los pedidos de un cliente</a></li>
          <li><a href='pe_consprodstock.php'>Consultar stock de un producto</a></li>
          <li><a href='pe_constock.php'>Consultar stock de una línea de productos</a></li>
          <li><a href='pe_topprod.php'>Consultar unidades compradas de cada producto entre dos fechas</a></li>
        </ol>
    <?php
      }
    ?>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'cerrarSesion') {
          logout();
          redireccionar('pe_login.php');
        }
      }
    ?>
  </body>
</html>