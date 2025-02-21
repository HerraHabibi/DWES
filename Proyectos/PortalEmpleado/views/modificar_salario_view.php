<?php
  require_once('comun_view_funciones.php');
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
        selectEmpleados();
      ?>

      <br><br>

      <label for='salario'>Salario</label>
      <input type='number' name='salario' id='salario' min='10000' step='1000'>

      <br><br>

      <input type='submit' value='Modificar salario'>
    </form>
  </body>
</html>