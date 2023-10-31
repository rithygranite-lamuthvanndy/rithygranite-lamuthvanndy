<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Employee Salary Up</h2>
        </div>
    </div>
    <br>
    <div class="">
            <label class="col-md-2">នៅផ្នែក * : </label>
            
            <div class="col-md-3">
            
            <select name="txt_postition" form="form_search" class="btn red" onchange="this.form.submit()">
                <option value="">==all position==</option>
                <?php 
                    $get_position = $connect->query("SELECT * FROM tbl_hr_department_sub WHERE dep_id Not IN (65, 66, 67, 68, 69, 70, 71)  ORDER BY dep_id");
                    while ($row_position = mysqli_fetch_object($get_position)) {
                        if($row_position->dep_id == @$_GET['txt_postition']){
                            echo '<option SELECTED value="'.$row_position->dep_id.'">'.$row_position->dep_id.' || '.$row_position->dep_name.'</option>';
                            
                        }else{
                            echo '<option value="'.$row_position->dep_id.'">'.$row_position->dep_id.' || '.$row_position->dep_name.'</option>';

                        }
                    }
                ?>
            </select>                
            <form action="" id="form_search" method="get"> </form>
            </div>
            <div class="tools"> </div>
            <div class="col-md-2">

            </div>
    </div>
    <br>
            <div class="portlet-body">
                <div id="sample_1_wrapper" class="dataTables_wrapper">
                    <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
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
                                if(@$_GET['txt_postition'] != ""){
                                $i = 0;
                                    $v_cat_name_tmp = [];
                                    $v_dep_id = @$_GET['txt_postition'];
                                    $get_data2 = $connect->query("SELECT 
                                        A.*,right(empl_card_id,4) as num_bang,B.po_name,B.po_note,C.dep_name,C.dep_id,D.sex_name,E.national_name,F.*
                                        FROM tbl_hr_employee_list1 AS A 
                                        LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                                        LEFT JOIN tbl_hr_department_sub AS C ON A.empl_department=C.dep_id
                                        left join tbl_hr_sex_list as D on A.empl_sex=D.sex_id
                                        left join tbl_hr_national_list as E on A.empl_national=E.national_id
                                        left join tbl_empl_benefits as F on A.empl_card_id=F.eb_emp_id
                                        WHERE po_name = 'បុគ្គលិក ជៀរជ័រកៅស៊ូ' and
                                        C.dep_id ='$v_dep_id'
                                        ORDER BY empl_card_id ASC");
                                }else{
                                    $i = 0;
                                        $v_cat_name_tmp = [];
                                        $get_data2 = $connect->query("SELECT 
                                            A.*,right(empl_card_id,4) as num_bang,B.po_name,B.po_note,C.dep_name,D.sex_name,E.national_name,F.*
                                            FROM tbl_hr_employee_list1 AS A 
                                            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                                            LEFT JOIN tbl_hr_department_sub AS C ON A.empl_department=C.dep_id
                                            left join tbl_hr_sex_list as D on A.empl_sex=D.sex_id
                                            left join tbl_hr_national_list as E on A.empl_national=E.national_id
                                            left join tbl_empl_benefits as F on A.empl_card_id=F.eb_emp_id
                                            WHERE po_name = 'បុគ្គលិក ជៀរជ័រកៅស៊ូ'
                                            ORDER BY empl_card_id ASC");
                                }                              
                                while ($row = mysqli_fetch_object($get_data2)) {

                                    echo '<tr>';
                                        echo '<td>'.(++$i).'</td>';
                                        echo '<td><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->empl_id.'" data_status="'.$row->empl_id.'" role="button" data-toggle="modal">'.$row->empl_card_id.'</a></td>';                                
                                        
                                        echo '<td>'.$row->dep_name.' || '.$row->num_bang.'<br>អង្ករ '.$row->eb_rich_kg.'kg || គូប៉ុង '.$row->eb_koubung.' || ធូបមុស '.$row->eb_mosquito.'</td>';
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






<?php include_once '../layout/footer.php' ?>
