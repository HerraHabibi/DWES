<?php
  require_once('comun_model.php');

  function departamentosEmpleado($numEmpleado) {
    $sql = "SELECT departments.dept_name department, dept_emp.from_date from_date, dept_emp.to_date to_date
              FROM dept_emp
              JOIN departments ON dept_emp.dept_no = departments.dept_no
              WHERE emp_no = :emp_no";
    $args = [':emp_no' => $numEmpleado];

    return operarBd($sql, $args);
  }

  function salariosEmpleado($numEmpleado) {
    $sql = "SELECT salary, from_date, to_date
              FROM salaries
              WHERE emp_no = :emp_no";
    $args = [':emp_no' => $numEmpleado];

    return operarBd($sql, $args);
  }

  function cargosEmpleado($numEmpleado) {
    $sql = "SELECT title, from_date, to_date
              FROM titles
              WHERE emp_no = :emp_no";
    $args = [':emp_no' => $numEmpleado];

    return operarBd($sql, $args);
  }

  function obtenerSiEsjefe($numEmpleado) {
    $sql = "SELECT departments.dept_name department
              FROM dept_manager
              JOIN departments ON departments.dept_no = dept_manager.dept_no
              WHERE dept_manager.emp_no = :emp_no AND dept_manager.to_date IS NULL";
    $args = [':emp_no' => $numEmpleado];

    return operarBd($sql, $args);
  }
?>