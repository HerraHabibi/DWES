<?php
  require_once('comun_view_funciones.php');
?>

<html>
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Alta empleado</title>
  </head>
        
  <body>
    <h1>Portal Empleados</h1>
    <h2>Alta empleado</h2>

    <a href='menu'>Volver</a>

    <br><br>

    <form method='POST'>
      <label for='nombre'>Nombre</label>
      <input type='text' id='nombre' name='nombre'>

      <br><br>

      <label for='apellidos'>Apellidos</label>
      <input type='text' id='apellidos' name='apellidos'>

      <br><br>

      <label for='genero'>Género</label>
      <select name='genero' id='genero'>
        <option value='' selected disabled>- SELECCIONA -</option>
        <option value='M'>Hombre</option>
        <option value='F'>Mujer</option>
        <option value='O'>Otro</option>
      </select>

      <br><br>

      <label for='nacimiento'>Fecha de nacimiento</label>
      <input type='date' name='nacimiento' id='nacimiento'>

      <br><br>

      <?php
        selectDepartamentos();
      ?>

      <br><br>

      <label for='salario'>Salario</label>
      <input type='number' name='salario' id='salario' min='10000' step='1000'>

      <br><br>

      <label for='cargo'>Cargo</label>
      <input type='text' name='cargo' id='cargo'>

      <br><br>

      <input type='submit' value='Dar de alta'>
    </form>
  </body>
</html>