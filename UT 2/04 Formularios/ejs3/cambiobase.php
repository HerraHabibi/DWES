<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ3-Conversor numérico</title>
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
  <body>
    <h1>Conversor numérico</h1>
    <?php  
     require 'fcambiobase.php';

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
    ?>
  </body>
</html>