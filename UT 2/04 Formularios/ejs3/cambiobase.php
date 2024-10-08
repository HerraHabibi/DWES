<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ3-Conversor numérico</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Conversor numérico</h1>
    <?php
      $decimal = $_REQUEST['decimal'];
      $conversion = $_REQUEST['conversion'];
      $tabla = cambiarBase($decimal, $conversion);

      echo "
        <form>
          <label for='decimal'>Número decimal: </label>
          <input type='text' name='decimal' id='decimal' value='$decimal' readonly>
          <br><br>
          <table border='1'>
            $tabla
          </table>
        </form>
      ";

      function cambiarBase($decimal, $conversion) {
        switch ($conversion) {
          case 'binario':
            $binario = decbin($decimal);
            $tabla = "<tr><td>Binario</td><td>$binario</td></tr>";
            break;

          case 'octal':
            $octal = decoct($decimal);
            $tabla = "<tr><td>Octal</td><td>$octal</td></tr>";
            break;
          
          case 'hexadecimal':
            $hexadecimal = strtoupper(dechex($decimal));
            $tabla = "<tr><td>Hexadecimal</td><td>$hexadecimal</td></tr>";
            break;

          case 'todos':
            $binario = decbin($decimal);
            $octal = decoct($decimal);
            $hexadecimal = strtoupper(dechex($decimal));
            $tabla = "
                      <tr><td>Binario</td><td>$binario</td></tr>
                      <tr><td>Octal</td><td>$octal</td></tr>
                      <tr><td>Hexadecimal</td><td>$hexadecimal</td></tr>
                      ";
            break;
        }

        return $tabla;
      }
    ?>
  </body>
</html>