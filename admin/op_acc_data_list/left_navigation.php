<div class="page-sidebar-wrapper">
   <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
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
                    AND lm_index_order>=200
                    GROUP BY B.lm_id
                    ORDER BY lm_index_order ASC");    

                while ($row_menu = mysqli_fetch_object($v_get_menu)) {
                    if($row_menu->lm_status == 2)
                        echo '<li class="heading"><h3 class="uppercase">'.$row_menu->lm_name.'</li></h3></li>';
                    else{
                        echo '<li class="nav-item"><a href="../'.$row_menu->lm_directory.'" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title">'.$row_menu->lm_name.'</span></a></li>';
                    }
                }
            ?>
            <!-- <li class="heading">
                <h3 class="uppercase">Data List Setting</h3>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_voucher_type_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Voucher Type List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_transection_type_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Transaction Type List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_encoded_name_list/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Encoded Name List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_position/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Position List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_prepare_name_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Prepare Name List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_check_name_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Check Name List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_purchase_name_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Purchase Name List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_unit_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Unit List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_approved_name_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Approved Name List</span>
                </a>
            </li>
             <li class="nav-item start ">
                <a href="../op_acc_requst_name_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Request Name List</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../op_acc_department_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Department List</span>
                </a>
            </li>
             <li class="nav-item start ">
                <a href="../op_acc_type_request_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Type Request List</span>
                </a>
            </li>
             <li class="nav-item start ">
                <a href="../op_acc_location_buy_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Location Buy List</span>
                </a>
            </li>
             <li class="nav-item start ">
                <a href="../op_acc_response_purchase_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Response Purchase List</span>
                </a>
            </li> -->

            <li class="nav-item start ">
                <a href="../op_acc_request_expense/" class="nav-link nav-toggle">
                    <i class="fa fa-undo"></i>
                    <span class="title"> Back</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>