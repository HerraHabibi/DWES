<?php
  require_once('comun_view_funciones.php');
  require_once('info_departamentos_view_funciones.php');
?>

<html>
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Modificar salario</title>
  </head>
        
  <body>
    <h1>Portal Empleados</h1>
    <h2>Modificar salario</h2>

    <a href='menu'>Volver</a>

    <br><br>

    <form method='POST'>
      <?php
        selectDepartamentos();
      ?>

      <br><br>

      <input type='submit' value='Ver información'>
    </form>
  </body>
</html>