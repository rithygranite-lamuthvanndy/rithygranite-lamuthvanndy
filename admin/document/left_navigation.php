
<div class="page-sidebar-wrapper" style="display: none;">
   <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start ">
                <a href="../dashboard/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <?php
            // echo $menu_active; 
            $v_get_menu = $connect->query("SELECT B.* FROM tbl_main_menu AS A 
                INNER JOIN tbl_left_menu AS B ON B.lm_main_menu=A.mm_id 
                INNER JOIN tbl_permission AS C ON C.p_module=B.lm_id
                INNER JOIN tbl_user AS E ON E.user_position=C.p_position
                WHERE E.user_id=".$_SESSION['user']->user_id."
                AND mm_index_order='$menu_active'
                AND C.p_view='1'
                AND (B.lm_status=1 OR B.lm_status=2 OR B.lm_status=3 OR B.lm_status=4)
                GROUP BY B.lm_id
                ORDER BY lm_index_order ASC");    
            //$v_get_menu = $connect->query("SELECT * FROM  tbl_left_menu WHERE lm_main_menu='$menu_active' ORDER BY lm_index_order ASC");

            while ($row_menu = mysqli_fetch_object($v_get_menu)) {
                if($row_menu->lm_id==64){
                    $str="SELECT docdoc_date FROM tbl_doc_document WHERE  DATE_FORMAT(docdoc_date,'%Y-%m-%d') ='$now'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==65){
                    $str="SELECT date_audit FROM tbl_doc_category WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$now'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==66){
                    $str="SELECT date_audit FROM tbl_doc_department WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$now'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }
                else if($row_menu->lm_id==67){
                    $str="SELECT date_audit FROM tbl_doc_creator WHERE  DATE_FORMAT(date_audit,'%Y-%m-%d') ='$now'";
                    $sql=$connect->query($str);
                    $count=mysqli_num_rows($sql);
                }

                if($row_menu->lm_status == 2)
                    echo '<li class="heading"><h3 class="uppercase">'.$row_menu->lm_name.'</li></h3></li>';
                else if($row_menu->lm_status == 4){
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