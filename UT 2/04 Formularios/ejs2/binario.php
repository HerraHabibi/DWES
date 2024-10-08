<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ2-Conversor binario</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Conversor binario</h1>
    <?php  
      $decimal = $_REQUEST['decimal'];
  
      $binario = decbin($decimal);

      echo "
        <form>
          <label for='decimal'>Número decimal: </label>
          <input type='text' name='decimal' id='decimal' value='$decimal' readonly>
          <br><br>
          <label for='binario'>Número binario: </label>
          <input type='text' name='binario' id='binario' value='$binario' readonly>
        </form>
      ";
    ?>
  </body>
</html>