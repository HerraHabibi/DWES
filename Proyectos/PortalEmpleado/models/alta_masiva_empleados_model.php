<?php
  function obtenerNombreDepartamento($departamento) {
    $sql = "SELECT dept_name
              FROM departments
              WHERE dept_no = :dept_no";
    $args = [':dept_no' => $departamento];

    return operarBd($sql, $args)[0]['dept_name'];
  }
?>