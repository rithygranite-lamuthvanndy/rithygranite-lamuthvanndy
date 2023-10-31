<?php include_once('../../config/database.php'); ?>

<?php 

    $v_block_code_id=@$_GET['block_code_id'];

    if($v_block_code_id){
        $v_sql="SELECT A.*,
        B.name AS location_name,
        C.name AS floor_name,
        D.name AS grade_type_name,
        E.name AS color_name
        FROM tbl_inv_block_from_mine_detail AS A 
        LEFT JOIN tbl_inv_location_list AS B ON A.location_id=B.id
        LEFT JOIN tbl_inv_floor_list AS C ON A.floor_id=C.id
        LEFT JOIN tbl_inv_grade_type_list AS D ON A.grade_type_id=D.id
        LEFT JOIN tbl_inv_color_list AS E ON A.color_id=E.id
        WHERE A.id='$v_block_code_id'
        ";
        $result=$connect->query($v_sql);
        $row_bfm_detail=mysqli_fetch_object($result);

        @$myObj->location_name=$row_bfm_detail->location_name;
        @$myObj->floor_name=$row_bfm_detail->floor_name;
        @$myObj->grade_type_name=$row_bfm_detail->grade_type_name;
        @$myObj->color_name=$row_bfm_detail->color_name;

        @$myJSON=json_encode($myObj);
        echo $myJSON;
    }
?>