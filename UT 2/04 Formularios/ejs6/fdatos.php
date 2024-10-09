<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ6-Datos alumnos</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Datos alumnos</h1>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <label for='nombre'>Nombre: </label>
      <input type='text' name='nombre' id='nombre'>
      * Obligatorio
      <br><br>
      <label for='apellido1'>Apellido 1: </label>
      <input type='text' name='apellido1' id='apellido1'>
      <br><br>
      <label for='apellido2'>Apellido 2: </label>
      <input type='text' name='apellido2' id='apellido2'>
      <br><br>
      <label for='email'>Email: </label>
      <input type='email' name='email' id='email'>
      * Obligatorio
      <br><br>
      Sexo:
      <input type='radio' id='mujer' name='sexo' value='M'>
      <label for='mujer'>Mujer</label>
      <input type='radio' id='hombre' name='sexo' value='H'>
      <label for='hombre'>Hombre</label>
      * Obligatorio
      <br><br>
      <button type='submit'>Enviar</button>
      <button type='reset'>Borrar</button>
      <br><br>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_REQUEST['nombre'];
        $apellido1 = $_REQUEST['apellido1'];
        $apellido2 = $_REQUEST['apellido2'];
        $email = $_REQUEST['email'];
        $sexo = isset($_REQUEST['sexo']) ? $_REQUEST['sexo'] : null;

        $archivo = 'datos.txt';
      
        limpiar($nombre);
        limpiar($apellido1);
        limpiar($apellido2);
        limpiar($email);

        validar($nombre);
        validar($email);
        validar($sexo, true);

        imprimirDatos($nombre, $apellido1, $apellido2, $email, $sexo);

        guardarAlumno($archivo, $nombre, $apellido1, $apellido2, $email, $sexo);
      }

      function limpiar(&$value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
      }

      function validar($value) {
        if ($value == '') {
          die('Debes rellenar los campos obligatorios');
        }
      }

      function imprimirDatos($nombre, $apellido1, $apellido2, $email, $sexo) {
        if (isset($nombre) && isset($email) && isset($sexo)) {
    ?>
      <table border='1'>
        <tr>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Email</th>
          <th>Sexo</th>
        </tr>
        <tr>
          <td><?php echo $nombre;?></td>
          <td><?php echo "$apellido1 $apellido2";?></td>
          <td><?php echo $email;?></td>
          <td><?php echo $sexo;?></td>
        </tr>
      </table>
      </table>
    <?php
        }
      }

      function guardarAlumno($archivo, $nombre, $apellido1, $apellido2, $email, $sexo) {
        $datos = "$nombre|$apellido1|$apellido2|$email|$sexo\n";
        file_put_contents($archivo, $datos,FILE_APPEND);
      }
    ?>
  </body>
</html>