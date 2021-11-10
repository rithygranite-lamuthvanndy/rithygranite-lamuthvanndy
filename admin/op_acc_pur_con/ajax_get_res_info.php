<?php include_once '../../config/database.php'; ?>
<?php 
if(isset($_GET['p_res_id'])){
	$v_res_id=$_GET['p_res_id'];
	$sql=$connect->query("SELECT A.*,dep_name,typr_name,SUM(rei_qty*rei_price) AS amo
		FROM tbl_acc_request_form AS A 
		LEFT JOIN tbl_acc_request_item AS B ON A.req_id=B.rei_number
		LEFT JOIN tbl_acc_department_list AS C ON A.dep_id=C.dep_id
		LEFT JOIN tbl_acc_type_request_list AS D ON A.type_req_id=D.typr_id
		WHERE req_id='$v_res_id'");
	$row_result=mysqli_fetch_object($sql);
  	// @$myObj->vou_no=$row_result->req_number;
  	@$myObj->dep_name=$row_result->dep_name;
  	@$myObj->type_of_req=$row_result->typr_name;
  	@$myObj->res_by=$row_result->req_request_name;
  	@$myObj->app_by=$row_result->req_approved_by;
  	@$myObj->amo=$row_result->amo;
  	@$myJSON=json_encode($myObj);
  	echo $myJSON;
}
 ?>