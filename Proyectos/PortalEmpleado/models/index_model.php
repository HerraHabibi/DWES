<?php	
  // Función para buscar el nombre del departamento al que pertenece un empleado
  function buscarNombreDepartamentoPorUsuario($usuario) {
    $sql = "SELECT dept_name
              FROM departments
              JOIN dept_emp ON departments.dept_no = dept_emp.dept_no
              WHERE emp_no = :emp_no";
    $args = [':emp_no' => $usuario];
    
    return operarBd($sql, $args)[0]['dept_name'];
  }
?>