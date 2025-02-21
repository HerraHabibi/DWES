<?php
  require_once('comun_model.php');

  // Función para obtener los datos sobre los departamentos
  function datosDepartamentos() {
    $sql = "SELECT *
              FROM departments";

    return operarBd($sql);
  }

  function ultimoEmpleadoCreado() {
    $sql = "SELECT max(emp_no)
              FROM employees";

    return operarBd($sql);
  }

  function crearEmpleado($numEmpleado, $nacimiento, $nombre, $apellidos, $genero) {
    $sql = "INSERT INTO employees (emp_no, birth_date, first_name, last_name, gender, hire_date)
              VALUES (:emp_no, :birth_date, :first_name, :last_name, :gender, CURDATE())";
    $args = [':emp_no' => $numEmpleado, ':birth_date' => $nacimiento, ':first_name' => $nombre, ':last_name' => $apellidos, ':gender' => $genero];
  
    return operarBd($sql, $args);
  }

  function agregarADepartamento($numEmpleado, $departamento) {
    $sql = "INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date)
              VALUES (:emp_no, :dept_no, CURDATE(), NULL)";
    $args = [':emp_no' => $numEmpleado, ':dept_no' => $departamento];

    return operarBd($sql, $args);
  }

  function agregarSalario($numEmpleado, $salario) {
    $sql = "INSERT INTO salaries (emp_no, salary, from_date, to_date)
              VALUES (:emp_no, :salary, CURDATE(), NULL)";
    $args = [':emp_no' => $numEmpleado, ':salary' => $salario];

    return operarBd($sql, $args);
  }

  function agregarCargo($numEmpleado, $cargo) {
    $sql = "INSERT INTO titles (emp_no, title, from_date, to_date)
              VALUES (:emp_no, :title, CURDATE(), NULL)";
    $args = [':emp_no' => $numEmpleado, ':title' => $cargo];

    return operarBd($sql, $args);
  }
?>