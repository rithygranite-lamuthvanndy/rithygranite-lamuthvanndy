<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title = "ស្រងអវត្តមានបុគ្គលិក និងកម្មករ";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Attendance Record: <?= date('d-m-Y') ?></h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br> <?php $d =cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    echo 'ចំនួនថ្ងៃស្នើ '.$d;
    ?>    
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr role="row" class="text-center">
                        <th style="text-align: center;" rowspan="2">ល.រ</th>
                        <th style="text-align: center;" rowspan="2">លេខកាត</th>
                        <th style="text-align: center;" rowspan="2">ឈ្មោះ</th>
                        <th style="text-align: center;min-width: 80px;" colspan="31">ថ្ងៃធ្វើការ</th>
                        <th style="text-align: center;" rowspan="2">សរុបម៉ោង</th>
                        <th style="text-align: center;" colspan="1">តម្លៃម៉ោង</th>
                        <th style="text-align: center;" rowspan="2">សរុបទឹកប្រាក់</th>
                        <th rowspan="2" style="min-width: 50px; text-align: center;">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                    <tr>
                        <?php
                        $x =1;
                        $d =cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                        while($x <= $d){
                            echo "<th> $x </th>";
                            $x+=1;
                        }
                        ?>
                        <th>RISH/H</th>
                        <th>USA/H</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $dn=date('m');
                        $get_data = $connect->query("SELECT 
                               A.*, MA.*
                            FROM   tbl_hr_emp_working AS A  
                            LEFT JOIN tbl_hr_employee_list AS MA ON A.empw_id_emp=MA.empl_id
                            
                            ORDER BY empl_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->empl_id_card.'</td>';
                                echo '<td>'.$row->empl_emloyee_kh.'</td>';
                                $s=1;
                                $m=1;
                                $d =cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                                $ed= date("d",strtotime($row->empw_date));
                                $em= date("m",strtotime($row->empw_date));
                                while($m<=$d){
                                    while($s<=$d){
                                        if($s == $ed){
                                        echo '<td>'.$row->empw_depat.'h</td>';
                                        }else if($s == $ed){
                                            echo '<td>'.$row->empw_depat.'h</td>';
                                        }else{
                                            echo '<td>'.'</td>';
                                        }
                                        $s+=1;
                                    }
                                    
                                    
                                    $m+=1;
                                    
                                }
                                
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->empw_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->accta_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                                    
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





<script>
function myFunction() {
  var d = new Date();
  var weekday = new Array(7);
  weekday[0] = "អាទិយត្យ";
  weekday[1] = "ច័ន្ទ";
  weekday[2] = "អង្គារ៍";
  weekday[3] = "ពុធ";
  weekday[4] = "ព្រហស្បត៍";
  weekday[5] = "សុក្រ";
  weekday[6] = "សៅរ៍";

  var n = weekday[d.getDay()];
  document.getElementById("demo").innerHTML = n;
}
</script>
<?php include_once '../layout/footer.php' ?>
