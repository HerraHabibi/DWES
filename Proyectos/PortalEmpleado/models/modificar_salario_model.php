<?php
  require_once('comun_model.php');

  function obtenerDiaUltimaModificacion($numEmpleado) {
    $sql = "SELECT from_date
              FROM salaries
              WHERE emp_no = :emp_no AND to_date IS NULL";
    $args = [':emp_no' => $numEmpleado];

    return operarBd($sql, $args);
  }

  function obtenerSalarioEmpleado($numEmpleado) {
    $sql = "SELECT salary
              FROM salaries
              WHERE emp_no = :emp_no AND to_date IS NULL";
    $args = [':emp_no' => $numEmpleado];

    return operarBd($sql, $args);
  }

  function modificarSalarioAntiguo($numEmpleado) {
    $sql = "UPDATE salaries
              SET to_date = CURDATE()
              WHERE emp_no = :emp_no AND to_date IS NULL";
    $args = [':emp_no' => $numEmpleado];

    return operarBd($sql, $args);
  }

  function asignarNuevoSalario($numEmpleado, $salario) {
    $sql = "INSERT salaries (emp_no, salary, from_date, to_date)
              VALUES (:emp_no, :salary, CURDATE(), NULL)";
    $args = [':emp_no' => $numEmpleado, ':salary' => $salario];

    return operarBd($sql, $args);
  }
?>