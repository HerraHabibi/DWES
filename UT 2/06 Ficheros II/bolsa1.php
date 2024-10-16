<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ3-Recoger alumnos almacenados en un txt y crear una tabla</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Alumnos</h1>
    <table border='1'>

  <!-- MAIN -->
      <?php
        $archivo = file('ibex35.txt');

        $columnas = [23, 9, 8, 8, 12, 9, 9, 13, 8, null];

        tituloTabla($archivo, $columnas);
        leerDatos($archivo, $columnas);
      ?>

  <!-- FUNCIONES -->
      <?php
        function tituloTabla($archivo, $columnas) {
          $fila = obtenerFila($archivo[0], $columnas);
      ?>
      <tr>
      <?php
          foreach($fila as $valor) {
      ?>
        <th><?php echo ($valor); ?></th>
      <?php
          }
      ?>
      </tr>
      <?php
        }
      ?>

      <?php
        function leerDatos($archivo, $columnas) {
          $datos = array_slice($archivo, 1);

          foreach($datos as $linea) {
            $fila = obtenerFila($linea, $columnas);
      ?>
      <tr>
      <?php
            foreach($fila as $valor) {
      ?>
        <td><?php echo ($valor); ?></td>
      <?php
            }
      ?>
      </tr>
      <?php
          }
        }
      ?>

      <?php
        function obtenerFila($linea, $columnas) {
          $fila = [];
          $inicio = 0;

          foreach ($columnas as $longitud) {
            if ($longitud == null)
              $fila[] = trim(substr($linea, $inicio));
          
            else {
                $fila[] = trim(substr($linea, $inicio, $longitud));
                $inicio += $longitud;
            }
          }

          return $fila;
        }
      ?>
    </table>
  </body>
</html>