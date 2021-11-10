<div class="page-sidebar-wrapper">
   <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="heading">
                <h3 class="uppercase">Features</h3>
            </li>
            <!-- <?php 
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
                    if($row_menu->lm_id==1){
                        $str="SELECT date_audit 
                            FROM tbl_com_company_info WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                        $sql=$connect->query($str);
                        $count=mysqli_num_rows($sql);
                    }
                    else if($row_menu->lm_id==2){
                        $str="SELECT comnd_date_record 
                            FROM tbl_com_notification_daily WHERE  DATE_FORMAT(comnd_date_record,'%Y-%m-%d') ='$current_date'";
                        $sql=$connect->query($str);
                        $count=mysqli_num_rows($sql);
                    }
                    else if($row_menu->lm_id=='3'){
                        $str="SELECT date_audit 
                            FROM tbl_com_depatment WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                        $sql=$connect->query($str);
                        $count=mysqli_num_rows($sql);
                    }
                    else if($row_menu->lm_id=='4'){
                        $str="SELECT date_audit 
                            FROM tbl_com_employee WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                        $sql=$connect->query($str);
                        $count=mysqli_num_rows($sql);
                    }
                    else if($row_menu->lm_id=='5'){
                        $str="SELECT date_audit 
                            FROM tbl_com_manager_name WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$current_date'";
                        $sql=$connect->query($str);
                        $count=mysqli_num_rows($sql);
                    }


                    if($row_menu->lm_status == 2)
                        echo '<li class="heading"><h3 class="uppercase">'.$row_menu->lm_name.'</li></h3></li>';
                    else if($row_menu->lm_status==1){
                        echo '<li class="nav-item"><a href="../'.$row_menu->lm_directory.'" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title">'.$row_menu->lm_name.' ('.$count.')</span></a></li>';
                    }
                    else{
                        echo '<li class="nav-item"><a href="../'.$row_menu->lm_directory.'" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title">'.$row_menu->lm_name.'</span></a></li>';
                    }
                }
            ?> -->

            <li class="nav-item start ">
                <a href="../dashboard/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            <li class="heading">
                <h3 class="uppercase">Feature</h3>
            </li>
            <li class="nav-item start ">
                <a href="../com_company_info/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Company Info</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../com_notification_daily/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Notification Daily</span>
                </a>
            </li>
            <hr>

            <li class="nav-item start ">
                <a href="../com_department_list/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Department List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../com_employee_list/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Employee List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../com_manager_list/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Manager List</span>
                </a>
            </li>
            
            <li class="heading">
                <h3 class="uppercase">Report</h3>
            </li>
            <li class="nav-item start ">
                <a href="../com_notification_daily/search_notification.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Search Notification</span>
                </a>
            </li>
            
            
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>