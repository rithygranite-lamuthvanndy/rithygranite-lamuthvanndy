<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start " style="font-family: 'khmer os';">
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
                    WHERE E.user_id=" . $_SESSION['user']->user_id . "
                    AND mm_index_order='$menu_active'
                    AND C.p_view='1'
                    AND (B.lm_status=1 OR B.lm_status=2 OR B.lm_status=3)
                    GROUP BY B.lm_id
                    ORDER BY lm_index_order ASC");
            // AND lm_index_order<=130
            while ($row_menu = mysqli_fetch_object($v_get_menu)) {
                $id=$row_menu->lm_id;
                if ($row_menu->lm_status == 2)
                    echo '<li  class="heading heading'.$id.' "><h3 class="uppercase">' . $row_menu->lm_name . '</li></h3></li>';
                else {
                    //34,36,37,38,39,41,43,44
                     if ($id=="34" || $id=="36" || $id=="37" || $id=="38" 
                       || $id=="39" || $id=="41" || $id=="43" || $id=="44"|| $id=="200") {
                           continue; // ..the search with the next droid
                        }

                    echo '<li class="nav-item ' . (($left_active == $row_menu->lm_id) ? 'active' : '') . '"><a href="../' . $row_menu->lm_directory . '" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title title'.$id.'">' . $row_menu->lm_name . '</span></a></li>';
                }
            }
            ?>
            <li class="nav-item <?php if($left_active=="63") {echo "active";} ?>" ><a href="../op_acc_history_purchase_list" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title title63">Price History List of Purchase</span></a></li>
            <li class="nav-item <?php if($left_active=="216") {echo "active";} ?>" ><a href="../op_acc_location" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title title216">តារាងរាយឈ្មោះអ្នកផ្គត់ផ្គង</span></a></li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<style type="text/css">
    .heading46  h3,.heading48  h3{
      color: red !important;
    }
  .title49,.title50,.title51,.title51,.title53,.title54,.title55,.title56,.title57,
  .title58,.title59,.title60,.title61,.title62,.title52,.title63{
    color: red !important;
  }
  .table th {
        
            background: #DDEBF7 !important;
            font-weight: bold !important;
            border: 1px solid white !important;
    }
</style>



