<?php 
    include_once '../../config/database.php';
?>
<?php
    $target_dir = "../../file/file_attatch_document/";
    // Create Folder
    if(isset($_POST['createFolder'])){
        $obj=json_decode(json_encode($_POST['createFolder']));
        $v_date=date('Y-m-d H:i:s');
        $v_title= $obj->v_folder_name;
        $v_type= 1;
        $v_creator= $_SESSION['user']->user_id;
        $v_doc_department= $obj->v_department;
        $v_child_id= $obj->v_child_id;
        $v_user_id = @$_SESSION['user']->user_id;
        $v_sql_insert= "INSERT INTO tbl_doc_document
                        (
                            docdoc_date,
                            docdoc_child_id,
                            docdoc_title,
                            docdoc_type,
                            docdoc_creator,
                            docdoc_department,
                            user_id
                        ) VALUES 
                        (
                            '$v_date',
                            '$v_child_id',
                            '$v_title',
                            '$v_type',
                            '$v_creator',
                            '$v_doc_department',
                            '$v_user_id'
                        )";
        // echo $v_sql_insert;
        if($connect->query($v_sql_insert)){
            echo "Create Folder Completely";
        }
        else{
            echo $connect->error;
        }
    }
    // Delete Folder
    if (isset($_POST['deleteFolder'])) {
        $obj = json_decode(json_encode($_POST['deleteFolder']));
        $v_child_id = $obj->child_id_clicked;
        $v_sql = "SELECT docdoc_old_file_name FROM tbl_doc_document WHERE docdoc_id='$v_child_id'";
        $row_old = mysqli_fetch_object($connect->query($v_sql));
        $v_old_image = @$row_old->docdoc_old_file_name;
        if (@$v_old_image != 'blank.png') {
            if (file_exists($target_dir . $v_old_image)) {
                unlink($target_dir . $v_old_image);
            }
        }
        $v_sql_delete= "DELETE FROM tbl_doc_document WHERE docdoc_id='$v_child_id'";
        if ($connect->query($v_sql_delete)) {
            echo "Delete Folder Completely";
        } else {
            echo $connect->error;
        }
    }

    // Upload File 
	$v_parent_id=@$_POST['txt_id'];
    
	// Upload file
	// $target_file = $target_dir . basename(@$_FILES["file"]["name"]);
	$v_image=@$_FILES["file"];
    $ext = pathinfo($v_image["name"], PATHINFO_EXTENSION);
    $old_name= $v_image["name"];
	$new_name = date("Ymd")."_".rand(1111,9999).'.'.$ext;

    $v_date = date('Y-m-d H:i:s');
    $v_title = $new_name;
    $v_type = 2;
    $v_doc_department = @$_POST['txt_department'];
    $v_child_id = $v_parent_id;
    $v_user_id = @$_SESSION['user']->user_id;
	if(move_uploaded_file($v_image["tmp_name"], $target_dir.$new_name)) {
        if($v_parent_id){
            $v_sql_insert = "INSERT INTO tbl_doc_document
                        (
                            docdoc_date,
                            docdoc_child_id,
                            docdoc_title,
                            docdoc_old_file_name,
                            docdoc_type,
                            docdoc_creator,
                            docdoc_department,
                            user_id
                        ) VALUES 
                        (
                            '$v_date',
                            '$v_child_id',
                            '$old_name',
                            '$v_title',
                            '$v_type',
                            '$v_creator',
                            '$v_doc_department',
                            '$v_user_id'
                        )";
            if ($connect->query($v_sql_insert)) {
                echo "Upload File Completely";
            } else {
                echo $connect->error;
            }
        }
        $_SESSION['fddddd']= $v_parent_id;
    }
    else{
            $_SESSION['saved_image_name']=$new_name;
    }
    ?>