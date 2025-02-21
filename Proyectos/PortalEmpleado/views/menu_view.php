<?php
  require_once('menu_view_funciones.php');
?>

<html>
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Menu</title>
  </head>
        
  <body>
    <h1>Portal Empleados</h1>
    <h2>Menu</h2>

    <b>Bienvenido/a:</b> <?php mostrarNombre(); ?>
    <br>
    <b><a href='controllers/logout_controller.php'>Cerrar Sesión</a></b>
    <br><br>

    <?php
      mostrarOpcionesRrhh();
    ?>
    
    <a href='mi_nomina'>Mi nómina</a>
    <br>
    <a href='historial_laboral'>Historial laboral</a>
  </body>
</html>