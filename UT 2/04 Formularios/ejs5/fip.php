<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ5-IP en binario</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>IP en binario</h1>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <label for='ipDecimal'>IP notación decimal: </label>
      <input type='text' name='ipDecimal' id='ipDecimal'>
      <br><br>
      <button type='submit'>Enviar</button>
      <button type='reset'>Borrar</button>
      <br><br>

      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $ipDecimal = $_REQUEST['ipDecimal'];

          limpiar($ipDecimal);
          validar($ipDecimal);

          $ipDecimalSeparada = separarIp($ipDecimal);

          $ipBinarioSeparada = pasarBinario($ipDecimalSeparada);
          $ipBinarioSeparada = anadirCeros($ipBinarioSeparada);
          $ipBinario = juntarIpBinario($ipBinarioSeparada);

          imprimirIp($ipDecimal, $ipBinario);
        }

        function limpiar(&$value) {
          $value = trim($value);
          $value = stripslashes($value);
          $value = htmlspecialchars($value);
        }

        function validar($ipDecimal) {
          if (!filter_var($ipDecimal, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            die('Debes introducir una IP válida');
          }
        }

        function separarIp($ipDecimal) {
          return explode('.', $ipDecimal);
        }

        function pasarBinario($ipDecimalSeparada) {
          $ipBinario = [];

          for ($i = 0; $i < count($ipDecimalSeparada); $i++) {
            $ipBinario[$i] = decbin($ipDecimalSeparada[$i]);
          }

          return $ipBinario;
        }

        function anadirCeros($ipBinarioSeparada) {
          for ($i = 0; $i < count($ipBinarioSeparada); $i++) {
            while (strlen($ipBinarioSeparada[$i]) < 8) {
              $ipBinarioSeparada[$i] = '0'. $ipBinarioSeparada[$i];
            }
          }

          return $ipBinarioSeparada;
        }

        function juntarIpBinario($ipBinarioSeparada) {
          return implode('.', $ipBinarioSeparada);
        }

        function imprimirIp($ipDecimal, $ipBinario) {
          if (isset($ipBinario)) {
      ?>
        <label for='ipDecimalRes'>IP notación decimal: </label>
        <input type='text' name='ipDecimalRes' id='ipDecimalRes' value='<?php echo $ipDecimal; ?>' readonly>
        <br><br>
        <label for='ipBinario'>IP binario: </label>
        <input type='text' name='binario' id='ipBinario' value='<?php echo $ipBinario; ?>' readonly size='34'>
      <?php
          }
        }
      ?>
    </form>
  </body>
</html>
