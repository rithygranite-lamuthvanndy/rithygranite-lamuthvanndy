<?php 
    $layout_title = "Welcome";
    $menu_active =44;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2>Welcome: Admin</h2>
			<hr>
        </div>
    
        <div class="col-xs-6">
            <h3 style="font-family:'Khmer OS';">ទំរងលិខិតស្នើសុំរដ្ឋបាល</h3>
            <hr>
            <div class="table-responsive">
                <table class="table no-margin" >
                
                <?php
                                $i = 0;
                                $get_data = $connect->query("SELECT 
                                       *
                                    FROM   tbl_admin_document_sample AS A  
                                    LEFT JOIN tbl_admin_check_name_list AS B ON A.docs_employee_check=B.cnl_id
                                    LEFT JOIN  tbl_admin_department_list AS C ON A.docs_department=C.dep_id
                                    ORDER BY docs_id DESC");
                                while ($row = mysqli_fetch_object($get_data)) {
                                        
                                        echo '<tr><td>'.$row->docs_title_name.'</td><td></td><td class="text-right"><small>'.$row->docs_date_record.'</small></td><tr>';
                                        echo '<tr>';
                                        echo '<td>'.(++$i).':.</td>';
                                        echo '<td><p style="text-indent: 0px; text-align: left; word-break: break-all; hyphens: auto;">'.$row->docs_description.'</p></td>';
                                        if($row->docs_attach_file == null){
                                            echo '<td><a href="#" class="btn btn-xs btn-warning" title="edit"></a></td>';
                                        }else{
                                            echo '<td class="text-right"><a href="index.php?edit_id='.$row->docs_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i> មានឯកសារ</a></td>';
                                        }
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<td>'.$row->dep_name.'</td><td>..........</td><td class="text-right text-indent">'.$row->cnl_name.'</td></tr>';
                                }
                    ?>
                    </table>
                </div>
        </div>
        <?php
        $get_id=0;
        if(@$_GET['edit_id'] == null){
            $old_data = $connect->query("SELECT 
                    * 
                FROM tbl_admin_document_sample 
                ORDER BY docs_id ASC limit 1");        

            $row_old_data = mysqli_fetch_object($old_data);
        }else{
            $edit_id = @$_GET['edit_id'];
            $old_data = $connect->query("SELECT 
                    * 
                FROM tbl_admin_document_sample
                WHERE docs_id='$edit_id'");

            $row_old_data = mysqli_fetch_object($old_data);
        }
        ?>    
        <div class="col-xs-6 text-right">
            <embed src="../../file/file_document_sample/<?= $row_old_data->docs_attach_file ?> "
                type="application/pdf"
                frameBorder="0"
                scrolling="auto"
                height="700px"
                width="50%"></embed>
        </div>
    </div>
</div>



<?php include_once '../layout/footer.php' ?>
