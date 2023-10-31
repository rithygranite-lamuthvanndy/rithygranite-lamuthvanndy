<?php include '../../config/database.php'; ?>
<?php 
if(isset($_GET['v_emp_id'])){
  $v_id=$_GET['v_emp_id'];
  $sql=$connect->query("SELECT * FROM tbl_hr_employee_list MA
  LEFT JOIN tbl_hr_position_list AS B ON MA.empl_position=B.po_id
   LEFT JOIN tbl_hr_department_sub AS C ON MA.empl_department=C.dep_id
  WHERE empl_id='$v_id'");
  $row_result=mysqli_fetch_object($sql);
  @$myObj->empl_po=$row_result->po_name;
  @$myObj->empl_department=$row_result->dep_name;
  @$myObj->empl_salary1=$row_result->empl_salary;
  @$myJSON=json_encode($myObj);
  echo $myJSON;
}

?>



