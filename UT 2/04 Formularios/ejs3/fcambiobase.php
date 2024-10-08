<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ3-Conversor numérico</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Conversor numérico</h1>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <label for='decimal'>Número decimal: </label>
      <input type='text' name='decimal' id='decimal'>
      <br><br>
      <label for='conversion'>Convertir a:</label>
      <br>
      <input type='radio' name='conversion' value='binario' id='binario'>
      <label for='binario'>Binario</label>
      <br>
      <input type='radio' name='conversion' value='octal' id='octal'>
      <label for='octal'>Octal</label>
      <br>
      <input type='radio' name='conversion' value='hexadecimal' id='hexadecimal'>
      <label for='hexadecimal'>Hexadecimal</label>
      <br>
      <input type='radio' name='conversion' value='todos' id='todos'>
      <label for='todos'>Todos sistemas</label>
      <br><br>
      <button type='submit'>Enviar</button>
      <button type='reset'>Borrar</button>
      <br><br>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
      }

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