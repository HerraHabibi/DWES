<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ6-Decir nombre del fichero, directorio, tamaño, y fecha modificación</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Datos alumnos</h1>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <label for='fichero'>Fichero (Path/Nombre): </label>
      <input type='text' name='fichero' id='fichero'>
      <br><br>
      <button type='submit'>Enviar</button>
      <button type='reset'>Borrar</button>
      <br><br>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fichero = $_REQUEST['fichero'];
        
        limpiar($fichero);

        comprobarFichero($fichero);
        obtenerInformacion($fichero);
      }

      function limpiar(&$value) {
        $value = trim($value);
        $value = htmlspecialchars($value);
      }

      function comprobarFichero($fichero) {
        if (!file_exists($fichero)) {
          echo "El fichero no existe.";
          die();
        }
      }

      function obtenerInformacion($fichero) {
        echo "<h1>Operaciones ficheros</h1>";
        echo "Nombre: " . basename($fichero) . "<br>";
        echo "Directorio: " . dirname($fichero) . "<br>";
        echo "Tamaño: " . formatoSize(filesize($fichero)) . "<br>";
        echo "Fecha última modificación: " . date("d/m/Y H:i", filemtime($fichero)) . "<br>";
      }

      function formatoSize($bytes) {
        $unidades = ['bytes', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($unidades) - 1) {
          $bytes /= 1024;
          $i++;
        }
        return round($bytes, 2) . ' ' . $unidades[$i];
      }
    ?>
  </body>
</html>