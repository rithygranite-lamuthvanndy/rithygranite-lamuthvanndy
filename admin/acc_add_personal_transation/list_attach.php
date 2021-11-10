<?php 
    $menu_active =122;
    $left_active =0;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';

    if(isset($_POST['btn_submit'])){
        $v_title = @$_POST['txt_title'];
        $v_image = @$_FILES['txt_file'];
        $v_doc_id = @$_POST['txt_parent_id'];
        if($v_image["name"] != ""){
            $new_name = date("Ymd")."_".rand(1111,9999).$v_image["name"];
            move_uploaded_file($v_image["tmp_name"], "../../file/file_director_transation/".$new_name);


            $connect->query("INSERT INTO tbl_acc_director_transation_file(title,name,main_id) 
                VALUES('$v_title','$new_name','$v_doc_id')");
        }else{
            $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Please Choose Image ...
                </div>';
        }
    }else if(@$_GET['del_id'] != ""){
        $del_id = @$_GET['del_id'];
        $connect->query("DELETE FROM tbl_acc_director_transation_file WHERE id='$del_id'");

        $old_file = @$_GET['old_file'];
        if(file_exists('../../file/file_director_transation/'.$old_file)){
            unlink('../../file/file_director_transation/'.$old_file);
        }
    }


    // get old data 
    $v_id = @$_GET['sent_id'];
    // $old_data = $connect->query("SELECT * FROM tbl_acc_director_transation_file WHERE id='$v_id'");
    // $row_old_data = mysqli_fetch_object($old_data);


?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Attach File</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a data-toggle="modal" href='#modal_add' id="sample_editable_1_new" class="btn green">
                <i class="fa fa-plus"></i>
            </a>
            <a href="index.php" id="sample_editable_1_new" class="btn red">
                <i class="fa fa-undo"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Title</th>
                        <th>Attach File</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                            B.*,A.id,B.id AS file_id
                            FROM tbl_acc_director_transation AS A 
                            LEFT JOIN tbl_acc_director_transation_file AS B ON B.main_id=A.id
                            WHERE B.main_id = $v_id
                            ORDER BY title DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->title.'</td>';
                                echo '<td><a href="../../file/file_director_transation/'.$row->name.'">DOWNLOAD <i class="fa fa-download"></i></a></td>';
                                echo '<td class="text-center">';
                                    echo '<a href="?del_id='.$row->file_id.'&old_file='.$row->name.'&sent_id='.@$_GET['sent_id'].'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="modal_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close text-danger" data-dismiss="modal" aria-hidden="true">12  &times;</button>
                <h4 class="modal-title">Upload</h4>
            </div>
            <div class="modal-body">
               <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_parent_id" value="<?= $v_id ?>">
                    <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" name="txt_title" required autocomplete="off">
                        <label>Title :
                            <span class="required" aria-required="true"></span>
                        </label>
                    </div>
                    <div class="form-group form-md-line-input">
                        <input required="" type="file" class="form-control" name="txt_file" placeholder="date record..."  autocomplete="off">
                        <label>Upload File :
                            <span class="required" aria-required="true"></span>
                        </label>

                    </div>
                    <div class="form-group text-center">
                        <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                        <button data-dismiss="modal" class="btn red"><i class="fa fa-undo fa-fw"></i>Close</button>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
