<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ3-Recoger alumnos almacenados en un txt y crear una tabla</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Alumnos</h1>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <label for='valorBursatil'>Introduce un valor bursátil</label>
      <input type='text' id='valorBursatil' name='valorBursatil'>
      <button type='submit'>Enviar</button>
      <button type='reset'>Borrar</button>
      <br><br>
    </form>

    

  <!-- MAIN -->
  <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $valorBursatil = $_REQUEST['valorBursatil'];
        $archivo = file('ibex35.txt');

        $columnas = [23, 9, 8, 8, 12, 9, 9, 13, 8, null];

        limpiar($valorBursatil);

        $linea = buscarBursatil($archivo, $columnas, $valorBursatil);
        tituloTabla($archivo, $columnas);
        leerDatos($linea, $columnas);
      }
      ?>

  <!-- FUNCIONES -->
      <?php
        function limpiar(&$value) {
          $value = trim($value);
          $value = stripslashes($value);
          $value = htmlspecialchars($value);
        }
      ?>

      <?php
        function buscarBursatil($archivo, $columnas, $valorBursatil) {
          foreach($archivo as $linea) {
            $fila = obtenerFila($linea, $columnas);
            if ($fila[0] == $valorBursatil)
              return fila[0];
          }
          return null;
        }
      ?>

      <?php
        function tituloTabla($archivo, $columnas) {
          $fila = obtenerFila($archivo[0], $columnas);
      ?>
    <table border='1'>
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
        function leerDatos($linea, $columnas) {
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