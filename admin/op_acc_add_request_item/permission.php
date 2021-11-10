<?php
	$get_action_permission = $connect->query("SELECT * FROM tbl_permission WHERE p_position=".$_SESSION['user']->user_position." AND p_module='$left_active'");
	$row_action_permission = mysqli_fetch_object($get_action_permission);


    function button_add(){
    	global $row_action_permission;
    	if($row_action_permission->p_add){
    		return '<br><a class="btn btn-primary" id="addnew" data-toggle="modal" href="#modal-id">Add New</a><br><br>';
    	}
    }
    function button_edit($id,$rei_num){
    	global $row_action_permission;
    	if($row_action_permission->p_edit){
	        return '<a href="edit.php?edit_id='.$id.'&sent_id='.$rei_num.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a>';
	    }else{
	    	return '<a class="btn btn-xs btn-warning disabled" title="edit"><i class="fa fa-edit"></i></a> ';
	    }
    }
    function button_delete($id1,$id2){
    	global $row_action_permission;
    	if($row_action_permission->p_delete){
        	return '<<a href="delete.php?del_id='.$id1.'&sent_id='.$id2.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
        }else{
        	return '<a class="btn btn-xs btn-danger disabled" title="delete"><i class="fa fa-trash"></i></a> ';
        }
    }
    function allow_view(){
    	global $row_action_permission;
    	if(!$row_action_permission->p_view){
    		exit();
    	}
    }
    allow_view();
?>