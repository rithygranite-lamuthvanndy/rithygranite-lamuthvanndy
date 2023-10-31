<?php 
    $layout_title = "Welcome";
    $menu_active =33;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS Muol';">ផ្នែក ធនធានមនុស្ស និងរដ្ឋបាល</h2>
			<hr>
        </div>

        
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation">
                <a href="index.php">សកម្មភាពបុគ្គលិក</a>
            </li>
            <li role="presentation" class="active">
                <a href="index_sw.php">ចរនា បុគ្គលិក និង កម្មករ ចេញចូល</a>
            </li>
        </ul>

            <div class="col-lg-12">
              <div class="portlet-body col-lg-4">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title" style="font-family: 'Khmer OS';">សំណើរផ្សេងៗ ពីបុគ្គលិក <?= date('M-Y') ?></h3>
                      </div>
                      <div class="panel-body">
                          <h1 style="font-family: 'Times New Roman';"><b> $ 0</b></h1>
                          <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>NET INCONE FOR <?= date('M') ?></b></h4>
                          <br><br>

                          <h4 style="font-family: 'Times New Roman';"><b> $ 0</b></h4>
                          <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>INCONE</b></h4>

                          <h4 style="font-family: 'Times New Roman';"><b> $ 0</b></h4>
                          <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>EXPENSES</b></h4>
                      </div>
                  </div>
              </div>
              <div class="portlet-body col-lg-4">
                      <div class="panel panel-primary">
                          <div class="panel-heading">
                              <h3 class="panel-title" style="font-family: 'Khmer OS';">បុគ្គលិកថ្មី, ឈប់,បែកបាំង</h3>
                          </div>
                          <div class="panel-body">
                              <table width="100%">
                                <tr>
                                  <th></th>
                                  <th></th>
                                </tr>
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
                                        WHERE anl_name is not null
                                        ORDER BY empl_card_id ASC");
                                    while ($row = mysqli_fetch_object($get_data)) {
                                            if (!in_array($row->dep_name, $v_cat_name_tmp)) {
                                            array_push($v_cat_name_tmp, $row->dep_name);
                                            echo '<tr class="bg-blue" style="color: #00B050; font-size: 20px;">';
                                                echo '<td colspan="2">&nbsp;'.$row->dep_name.'</td>';
                                            echo '</tr>';
                                            }
                                        
                                            echo '<td style="border-bottom: 1px solid #ddd;">'.$row->empl_card_id.' = '.$row->empl_emloyee_kh.'<br>'.$row->po_name.'</td>';
                                            echo '<td style="color: #00B050; font-size: 20px;" class="text-right">'.$row->anl_name.'</td>';
                                        echo '</tr>';
                                    }
                                ?>
                              </table>
                          </div>
                           
                      </div>
                  </div> 
            </div>
    </div>
    <!--<img src="../../img/img_system/HiRes-47.jpg" alt="" width="100%" class="img-responsive img-thumbnail"> -->
</div>






<?php include_once '../layout/footer.php' ?>
