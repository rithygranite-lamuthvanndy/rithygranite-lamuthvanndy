<div class="page-sidebar-wrapper">
   <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start ">
                <a href="../dashboard/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <?php 
                $current_date=date('Y-m-d');
             ?>
        <?php
            // echo $menu_active; 
            $v_get_menu = $connect->query("SELECT B.* FROM tbl_main_menu AS A 
                INNER JOIN tbl_left_menu AS B ON B.lm_main_menu=A.mm_id 
                INNER JOIN tbl_permission AS C ON C.p_module=B.lm_id
                INNER JOIN tbl_user AS E ON E.user_position=C.p_position
                WHERE E.user_id=".$_SESSION['user']->user_id."
                AND mm_index_order='$menu_active'
                AND C.p_view='1'
                AND (B.lm_status=1 OR B.lm_status=2 OR B.lm_status=3)
                GROUP BY B.lm_id
                ORDER BY lm_index_order ASC");    
            //$v_get_menu = $connect->query("SELECT * FROM  tbl_left_menu WHERE lm_main_menu='$menu_active' ORDER BY lm_index_order ASC");

            while ($row_menu = mysqli_fetch_object($v_get_menu)) {
                if($row_menu->lm_id==11){
                    $str="SELECT meetp_date_meeting 
                        FROM tbl_meeting_plan WHERE  DATE_FORMAT(meetp_date_meeting,'%Y-%m-%d') ='$current_date'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==12){
                    $str="SELECT doc_date_record 
                            FROM tbl_meeting_document WHERE  DATE_FORMAT(doc_date_record,'%Y-%m-%d') ='$current_date'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==13){
                    $str="SELECT mr_date_record 
                                FROM tbl_meeting_record WHERE  DATE_FORMAT(mr_date_record,'%Y-%m-%d') ='$current_date'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==14){
                    $str="SELECT date_audit 
                            FROM tbl_meeting_result WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==15){
                    $str="SELECT date_audit
                                FROM tbl_meeting_add_joiner_name
                                WHERE DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==16){
                    $str="SELECT date_audit 
                                FROM tbl_meeting_add_joiner_name WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==17){
                    $str="SELECT date_audit 
                            FROM tbl_meeting_department WHERE DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==18){
                    $str="SELECT date_audit 
                                FROM  tbl_meeting_category WHERE DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                
                if($row_menu->lm_status == 2)
                    echo '<li class="heading"><h3 class="uppercase">'.$row_menu->lm_name.'</li></h3></li>';
                else if($row_menu->lm_status == 3){
                    echo '<li class="nav-item"><a href="../'.$row_menu->lm_directory.'" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title">'.$row_menu->lm_name.'</span></a></li>';
                }
                else{
                    echo '<li class="nav-item"><a href="../'.$row_menu->lm_directory.'" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title">'.$row_menu->lm_name.' ('.$count.')</span></a></li>';
                }
                
            }
        ?>

            
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>