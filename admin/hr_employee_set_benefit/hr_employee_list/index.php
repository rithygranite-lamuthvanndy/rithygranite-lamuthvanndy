<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Employee List</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php?view=<?= @$_GET['view'] ?>" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row">
                        <th class="text-center">N&deg;</th>
                        <th class="text-center">Card ID</th>
                        <th class="text-center">Photo</th>
                        <th class="text-center">Name EN</th>
                        <th class="text-center">Name KH</th>
                        <th class="text-center">Sex</th>
                        <th class="select-filter text-center">National</th>
                        <th class="select-filter text-center">Position</th>
                        <th class="select-filter text-center">Department</th>
                        <th class="text-center">Date of Birth</th>
                        <th class="text-center">Date of Work</th>
                        <th class="text-center">ID Card & Passport</th>
                        <th class="text-center">Phone 1</th>
                        <th class="text-center">Phone2</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                            A.*,B.po_name,C.dep_name,D.sex_name,E.national_name
                            FROM tbl_hr_employee_list AS A 
                            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                            LEFT JOIN tbl_hr_department_list AS C ON A.empl_department=C.dep_id
                            left join tbl_hr_sex_list as D on A.empl_sex=D.sex_id
                            left join tbl_hr_national_list as E on A.empl_national=E.national_id
                            ORDER BY empl_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->empl_id.'" data_status="'.$row->empl_id.'" role="button" data-toggle="modal">'.$row->empl_card_id.'</a></td>';                                
                                echo '<td>';
                                    echo '<img width="150px;" src="../../img/img_empl/'.$row->empl_pic.'" alt="Blank">';
                                    echo '&nbsp;&nbsp;';
                                    echo '<a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal" onclick="view_iframe_upload_image('.$row->empl_id.')"><i class="fa fa-upload"></i></a>';
                                echo '</td>';
                                echo '<td>'.$row->empl_emloyee_en.'</td>';
                                echo '<td>'.$row->empl_emloyee_kh.'</td>';
                                echo '<td>'.$row->sex_name.'</td>';
                                echo '<td>'.$row->national_name.'</td>';
                                echo '<td>'.$row->po_name.'</td>';
                                echo '<td>'.$row->dep_name.'</td>';
                                echo '<td>'.$row->empl_date_birth.'</td>';
                                echo '<td>'.$row->empl_date_work.'</td>';
                                echo '<td>'.$row->empl_id_card.'</td>';
                                echo '<td>'.$row->empl_phone.'</td>';
                                echo '<td>'.$row->empl_phone2.'</td>';
                                echo '<td>'.$row->empl_email.'</td>';
                                echo '<td>'.$row->empl_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->empl_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->empl_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php 
    if(@$_GET['view']=='iframe')
        include_once '../layout/footer_frame.php';
    else
        include_once '../layout/footer.php';
 ?>
<script type="text/javascript">
    function view_iframe_upload_image(e){
        document.getElementById('result_modal').src = 'upload.php?empl_id='+e;
    }
    $(document).ready(function() {
        $('#modal').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
    function load_iframe(obj){
       let v_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame').attr("src","iframe_more_info.php?v_id="+v_id);
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <iframe id="result_modal" frameborder="0" style="height: 500px; width: 100%;" align="top" scrolling="0"></iframe>

    </div>
</div>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 80%; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>