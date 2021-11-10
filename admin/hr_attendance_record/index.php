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
            <h2><i class="fa fa-fw fa-map-marker"></i> Attendance Record</h2>
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
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_2" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th style="text-align: center;" rowspan="2">N&deg;</th>
                        <th style="text-align: center;" rowspan="2">Emp_ID</th>
                        <th style="text-align: center;" rowspan="2">Name KH&EN</th>
                        <th style="text-align: center;" rowspan="2">មុខងារ</th>
                        <th style="text-align: center;" colspan="31">ថ្ងៃធ្វើការ</th>
                        <th style="text-align: center;" rowspan="2">សរុបម៉ោង</th>
                        <th style="text-align: center;" colspan="2">តម្លៃម៉ោង</th>
                        <th style="text-align: center;" rowspan="2">សរុបទឹកប្រាក់</th>
                        <th rowspan="2" style="min-width: 100px; text-align: center;">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>5</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                        <th>13</th>
                        <th>14</th>
                        <th>15</th>
                        <th>16</th>
                        <th>17</th>
                        <th>18</th>
                        <th>19</th>
                        <th>20</th>
                        <th>21</th>
                        <th>22</th>
                        <th>23</th>
                        <th>24</th>
                        <th>25</th>
                        <th>26</th>
                        <th>27</th>
                        <th>28</th>
                        <th>29</th>
                        <th>30</th>
                        <th>31</th>
                        <th>RISH/H</th>
                        <th>USA/H</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;

                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_hr_emp_working AS A  
                            LEFT JOIN tbl_hr_employee_list AS MA ON A.empw_id_emp=MA.empl_id
                            LEFT JOIN tbl_hr_department_sub AS MB ON A.empw_depat=MB.dep_id
                            ORDER BY empl_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->empl_id_card.'</td>';
                                echo '<td>'.$row->empl_emloyee_en.'</td>';
                                echo '<td>'.$row->dep_name.'</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
                                echo '<td>'.'h</td>';
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
