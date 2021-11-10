<?php 
    $menu_active =122;
    $left_active =0;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';



    if(@$_GET['del_id'] != ""){
        $del_id = @$_GET['del_id'];
        $connect->query("DELETE FROM tbl_doc_attach_file WHERE docatt_id='$del_id'");
    }
    if(@$_GET['del_file'] != ""){
        $file_id = @$_GET['del_file'];
        if($file_id != "blank.png"){
            if(file_exists("../../file/file_attatch_document/".$file_id)){
                unlink("../../file/file_attatch_document/".$file_id);
            }
        }
    }




    $v_id = @$_GET['sent_id'];
    if(isset($_POST['btn_att'])){
        $title = @$_POST['txt_title'];
        $v_attatch_file = @$_FILES['txt_file'];
        if($v_attatch_file["name"] != ""){
            $new_name = date("Ymd")."_".rand(1111,9999)."-".$v_attatch_file["name"];
            $new_name = preg_replace("/ /", "_", $new_name);
            if(move_uploaded_file($v_attatch_file["tmp_name"], "../../file/file_attatch_document/".$new_name)){
                $connect->query("INSERT INTO tbl_doc_attach_file (docatt_title,docatt_document_id,docatt_attach) VALUES('$title','$v_id','$new_name')");
            }else{
                $new_name = "blank.png";
            }
        }
    }


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
            <a data-toggle="modal" href='#md_attatch_file' class="btn green">
                <i class="fa fa-plus"></i>
            </a>
            <a  href='index.php' class="btn red">
                <i class="fa fa-arrow-left"></i>
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
                               *
                            FROM  tbl_doc_attach_file AS A 
                            LEFT JOIN tbl_working_record AS B ON A.docatt_document_id=B.wr_id
                            WHERE B.wr_id = '$v_id'
                            ORDER BY docatt_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->docatt_title.'</td>';
                                echo '<td><a href="../../file/file_attatch_document/'.$row->docatt_attach.'">'.$row->docatt_attach.'</a></td>';
                                echo '<td class="text-center">';
                                    echo '<a href="'.$_SERVER['PHP_SELF'].'?sent_id='.$v_id.'&del_id='.$row->docatt_id.'&del_file='.$row->docatt_attach.'" onclick="return confirm(\'are you sure to delete this file?\')" href="#.php?edit_id='.$row->docatt_id.'" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
<div class="modal fade" id="md_attatch_file">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Attatch File</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" role="form" enctype="multipart/form-data">
                
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" required="" class="form-control" name="txt_title">
                    </div>
                    <div class="form-group">
                        <label for="">Attatchment</label>
                        <input type="file" required="" class="form-control" name="txt_file">
                    </div>
                    
                    <br>
                    
                
                    <button type="submit" name="btn_att" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <br>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>