<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ6-Datos alumnos</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Datos alumnos</h1>
    <?php
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