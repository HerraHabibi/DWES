<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Registro - Web Pedidos</title>
  </head>
  <body>
    <?php
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_registro.php';
    ?>

    <?php
      if(isset($_SESSION['usuario'])) {
        redireccionar('pe_inicio.php');

      } else {
        logout();
    ?>
        <h1>Registro</h1>

        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
          <b>Nombre: </b><input type='text' name='nombre'>
          <br><br>
          <b>Apellido/Contraseña: </b><input type='text' name='clave'>
          <br><br>
          <button type='submit' name='action' value='registrar'>Registrarse</button>
          <button type='submit' name='action' value='inicioSesion'>Ir al inicio de sesión</button>
        </form>
    <?php
      }
    ?>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'registrar') {
          $nombre = $_POST['nombre'];
          $clave = $_POST['clave'];
          
          limpiar($nombre);
          limpiar($clave);

          $nuevoCustomerNumber = intval(buscarUltimoCustomer()) + 1;

          $valido = registrar($nuevoCustomerNumber, $nombre, $clave);
          
          if ($valido) {
            crearCookiesLogin($nuevoCustomerNumber);
            echo "<h3>Bienvenid@ $nombre</h3>";
            echo "Tu usuario es: $nuevoCustomerNumber y tu clave es: $clave";

            ?>
              <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
                <button type='submit' name='action' value='login'>Iniciar sesión</button>
              </form>
            <?php
          }
        }
        
        if (isset($_POST['action']) && $_POST['action'] === 'login') {
          login($_COOKIE['usuario']);
          redireccionar('pe_inicio.php');
        }

        if (isset($_POST['action']) && $_POST['action'] === 'inicioSesion') {
          redireccionar('pe_login.php');
        }
      }
    ?>
  </body>
</html>