<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title = "តារាងបៀវត្សរ៍ប្រចាំខែ";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family:'Khmer OS Muol';"><i class="fa fa-fw fa-map-marker"></i> តារាងឈ្មោះបុគ្គលិកការិយាល័យ (ការដ្ឋាន ឫទ្ធីកៅស៊ូ)</h2>
        </div>
    </div>
    <br>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#activity" data-toggle="tab">តារាងឈ្មោះបុគ្គលិក និងកម្មករ</a>
        </li>
        <li role="presentation">
            <a href="#timeline" data-toggle="tab">តារាងព័ត៌មានបុគ្គលិក និងកម្មករ</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="active tab-pane" id="activity">
            <div class="">
                <div class="caption font-dark">
                    <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <br>
            <div class="portlet-body">
                <div id="sample_1_wrapper" class="dataTables_wrapper">
                    <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_2" role="grid" aria-describedby="sample_1_info">
                        <thead>
                            <tr role="row">
                                <th class="text-center">ល.រ</th>
                                <th class="text-center">លេខកាតបុគ្គលិក</th>
                                <th class="text-center">រូបភាព</th>
                                <th class="text-center">ឈ្មោះអង់គ្លេស</th>
                                <th class="text-center">ឈ្មោះខ្មែរ</th>
                                <th class="text-center">ភេទ</th>
                                <th class="select-filter text-center">សញ្ជាតិ</th>
                                <th class="select-filter text-center">មុខងារ</th>
                                <th class="text-center">សកម្មភាព</th>
                                <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 0;
                                $v_cat_name_tmp = [];
                                $get_data = $connect->query("SELECT 
                                    A.*,B.po_name,B.po_note,C.dep_name,D.sex_name,E.national_name,F.*
                                    FROM tbl_hr_employee_list AS A 
                                    LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                                    LEFT JOIN tbl_hr_department_sub AS C ON A.empl_department=C.dep_id
                                    left join tbl_hr_sex_list as D on A.empl_sex=D.sex_id
                                    left join tbl_hr_national_list as E on A.empl_national=E.national_id
                                     left join tbl_hr_approved_name_list as F on A.empl_act=F.anl_id
                                     WHERE A.empl_position <> 142
                                    ORDER BY empl_card_id ASC");
                                while ($row = mysqli_fetch_object($get_data)) {
                                    if (!in_array($row->dep_name, $v_cat_name_tmp)) {
                                        array_push($v_cat_name_tmp, $row->dep_name);
                                    echo '<tr class="bg-blue">';
                                        echo '<td colspan="10">'.$row->dep_name.'</td>';
                                    echo '</tr>';
                                }

                                    echo '<tr>';
                                        echo '<td>'.(++$i).'</td>';
                                        echo '<td><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe1(this)" data_id="'.$row->empl_id.'" data_status="'.$row->empl_id.'" role="button" data-toggle="modal">'.$row->empl_card_id.'</a></td>';                                
                                        echo '<td>';
                                            if($row->empl_pic == null){
                                                echo '<img width="150px" src="../../img/img_empl/blank.jpg">';
                                            }else{
                                                echo '<img width="150px;" src="../../img/img_empl/'.$row->empl_pic.'" alt="Blank">';
                                                
                                            }
                                            echo '&nbsp;&nbsp;';
                                            echo '<a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal" onclick="view_iframe_upload_image('.$row->empl_id.')"><i class="fa fa-upload"></i></a>';
                                        echo '</td>';
                                        echo '<td>'.$row->empl_emloyee_en.'</td>';
                                        echo '<td>'.$row->empl_emloyee_kh.'</td>';
                                        echo '<td>'.$row->sex_name.'</td>';
                                        echo '<td>'.$row->national_name.'<br>លេខអត្ថសញ្ញាណប័ត្រ: '.$row->empl_id_card.'</td>';
                                        echo '<td>'.$row->po_name.' || '.$row->po_note.'<br><p class="btn btn-info btn-xs btn-warning">'.$row->anl_name.'</p><br><p>បញ្ជាក់៖ '.$row->empl_note.'</p></td>';
                                        echo '<td class="text-center">'.number_format($row->empl_salary,0).' ៛</td>';
                                        echo '<td class="text-center">';
                                            echo '<a href="edit.php?edit_id='.$row->empl_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                           //echo '<a onclick="deleteRecord('.$row->empl_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                            echo '<br><br><a href="#more_info1" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->empl_id.'" data_status="'.$row->empl_id.'" role="button" data-toggle="modal">បច្ចុប្បន្នភាព</a>';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                 
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="timeline">
            <br><br><br>
            <div class="portlet-body">
                <div id="sample_1_wrapper" class="dataTables_wrapper">
                    <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                        <thead>
                            <tr role="row">
                                <th class="text-center">ល.រ</th>
                                <th class="text-center">លេខកាតបុគ្គលិក</th>
                                <th class="text-center">ផ្នែក</th>
                                <th class="text-center">ឈ្មោះអង់គ្លេស</th>
                                <th class="text-center">ឈ្មោះខ្មែរ</th>
                                <th class="text-center">ភេទ</th>
                                <th class="select-filter text-center">លេខអត្តសញ្ញាណប័ណ្ណ</th>
                                <th class="select-filter text-center">អាសយដ្ឋានបច្ចុប្បន្ន</th>
                                <th class="select-filter text-center">មុខងារ</th>
                                <th class="text-center">សកម្មភាព</th>
                                <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 0;
                                $v_cat_name_tmp = [];
                                $get_data = $connect->query("SELECT 
                                    A.*,B.po_name,B.po_note,C.dep_name,D.sex_name,E.national_name
                                    FROM tbl_hr_employee_list AS A 
                                    LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                                    LEFT JOIN tbl_hr_department_sub AS C ON A.empl_department=C.dep_id
                                    left join tbl_hr_sex_list as D on A.empl_sex=D.sex_id
                                    left join tbl_hr_national_list as E on A.empl_national=E.national_id
                                     WHERE A.empl_position <> 142
                                    ORDER BY empl_card_id ASC");
                                while ($row = mysqli_fetch_object($get_data)) {

                                    echo '<tr>';
                                        echo '<td>'.(++$i).'</td>';
                                        echo '<td><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->empl_id.'" data_status="'.$row->empl_id.'" role="button" data-toggle="modal">'.$row->empl_card_id.'</a></td>';                                
                                        
                                        echo '<td>'.$row->dep_name.'</td>';
                                        echo '<td>'.$row->empl_emloyee_en.'</td>';
                                        echo '<td>'.$row->empl_emloyee_kh.'</td>';
                                        echo '<td>'.$row->sex_name.'<br>'.$row->national_name.'</td>';
                                        echo '<td>'.$row->empl_id_card.'</td>';
                                        echo '<td>'.$row->empl_email.'</td>';
                                        echo '<td>'.$row->po_name.' || '.$row->po_note.'</td>';
                                        echo '<td class="text-center">';
                                                    $get_data1 = $connect->query("SELECT 
                                                    *
                                                    FROM tbl_hr_employee_note 
                                                    WHERE emn_empl_id = $row->empl_id
                                                    ORDER BY emn_date ASC
                                                    ");
                                                while ($row1 = mysqli_fetch_object($get_data1)) {
                                                        echo $row1->emn_date.' || '.$row1->emn_description.'<br>' ;
                                                       }
                                                        echo '</td>';
                                        echo '<td class="text-center">';
                                            echo '<a href="edit.php?edit_id='.$row->empl_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                           echo '<a onclick="deleteRecord('.$row->empl_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
        include_once '../layout/footer.php'
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
    function load_iframe1(obj){
       let v_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame').attr("src","iframe_more_info.php?v_id="+v_id);
    }
    function load_iframe(obj){
       let v2_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame1').attr("src","iframe_action.php?v2_id="+v2_id);
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <iframe id="result_modal" frameborder="0" style="height: 500px; width: 100%;" align="top" scrolling="0"></iframe>

    </div>
</div>
<div class="modal fade" id="more_action">
    <div class="modal-dialog">
        <iframe id="modal_action" frameborder="0" style="height: 500px; width: 100%;" align="top" scrolling="0"></iframe>

    </div>
</div>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 80%; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 800px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>

<div class="modal fade" id="more_info1">
    <div class="modal-dialog modal-lg" style="width: 50%; border: 1px solid darkred;">
        <iframe id="my_frame1" frameborder="0" style="height: 500px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>