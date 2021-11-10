<?php include_once '../../config/database.php'; ?>
<?php 
	$v_position = @$_GET['p'];
	$v_module = @$_GET['m'];

	$v_view = $v_value = ((@$_GET['v'])=='true')?('1'):('0');
	$v_add = $v_value = ((@$_GET['a'])=='true')?('1'):('0');
	$v_edit = $v_value = ((@$_GET['e'])=='true')?('1'):('0');
	$v_delete = $v_value = ((@$_GET['d'])=='true')?('1'):('0');

	$connect->query("DELETE FROM tbl_permission WHERE p_position='$v_position' AND p_module='$v_module'");
	$connect->query("INSERT INTO tbl_permission(p_position,p_module,p_view,p_add,p_edit,p_delete) VALUES('$v_position','$v_module','$v_view','$v_add','$v_edit','$v_delete')");

	echo 'Hello';
 ?>