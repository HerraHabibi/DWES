<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ2-Conversor binario</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Conversor binario</h1>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <label for='decimal'>Número decimal: </label>
      <input type='text' name='decimal' id='decimal'>
      <br><br>
      <button type='submit'>Enviar</button>
      <button type='reset'>Borrar</button>
      <br><br>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $decimal = $_REQUEST['decimal'];
        
        $binario = decbin($decimal);

        echo "
          <form>
            <label for='decimal'>Número decimal: </label>
            <input type='text' name='decimal' id='decimal' value='$decimal' readonly>
            <br><br>
            <label for='binario'>Número binario: </label>
            <input type='text' name='binario' id='binario' value='$binario' readonly>
          <form>
        ";
      }
    ?>
  </body>
</html>