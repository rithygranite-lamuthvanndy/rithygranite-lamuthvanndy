<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start ">
                <a href="../dashboard/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">Features</h3>
            </li>
            <li class="nav-item start ">
                <a href="../ct_contact_list_alert/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-bell"></i>
                    <?php
                    $v_current_date = date('Y-m-d');
                    $get_data = $connect->query("SELECT 
                               count(*)
                            FROM tbl_ct_contact_alert 
                            WHERE ctca_date_alert = '$v_current_date'
                            GROUP BY ctca_id");
                    ?>
                    <span class="title"> Accounting Depament <span class="text-danger">[ <?= mysqli_num_rows($get_data) ?> ]</span></span>
                    <?php
                    unset($v_current_date);
                    unset($get_data)
                    ?>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../cf_cash_flow_list_alert/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-bell"></i>

                    <?php
                    $v_current_date_cash = date('Y-m-d');
                    $get_data_cash = $connect->query("SELECT 
                               count(*)
                            FROM tbl_cf_cash_flow_alert
                            WHERE cfcfa_date_alert = '$v_current_date_cash'
                            GROUP BY cfcfa_id
                            ");
                    ?>

                    <span class="title"> Sale Depament <span class="text-danger">[ <?= mysqli_num_rows($get_data_cash) ?> ]</span></span>
                    <?php
                    unset($v_current_date_cash);
                    unset($get_data_cash)
                    ?>

                </a>
            </li>
            <li class="nav-item start ">
                <a href="../working_flow_list_alert/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-bell"></i>

                    <?php
                    $v_current_date_work = date('Y-m-d');
                    $get_data_work = $connect->query("SELECT 
                               count(*)
                            FROM tbl_working_flow_alert
                            WHERE wfa_date_alert = '$v_current_date_work'
                            GROUP BY wfa_id
                            ");
                    ?>

                    <span class="title"> Operation Depament <span class="text-danger">[ <?= mysqli_num_rows($get_data_work) ?> ]</span></span>
                    <?php
                    unset($v_current_date_work);
                    unset($get_data_work)
                    ?>


                </a>
            </li>
            <li class="nav-item start ">
                <a href="../acc_add_cash_record/" class="nav-link nav-toggle">
                    <i class="fa fa-bell"></i>

                    <?php
                    $v_current_date = date('Y-m');
                    $get_data_work = $connect->query("SELECT accdr_date 
                        FROM  tbl_acc_cash_record 
                        WHERE DATE_FORMAT(accdr_date,'%Y-%m')='$v_current_date' AND status=1
                            ");
                    ?>

                    <span class="title"> Alert Cash Record <span class="text-danger">[ <?= mysqli_num_rows($get_data_work) ?> ]</span></span>
                    <!-- <?php
                            unset($v_current_date_work);
                            unset($get_data_work)
                            ?> -->


                </a>
            </li>
            <li class="nav-item start ">
                <a href="../acc_add_none_case_record/" class="nav-link nav-toggle">
                    <i class="fa fa-bell"></i>

                    <?php
                    $v_current_date = date('Y-m');
                    $get_data = $connect->query("SELECT accdr_date 
                        FROM  tbl_acc_cash_record 
                        WHERE DATE_FORMAT(accdr_date,'%Y-%m')='$v_current_date' AND status=2
                            ");
                    ?>

                    <span class="title"> Alert None-Cash Record <span class="text-danger">[ <?= mysqli_num_rows($get_data) ?> ]</span></span>
                    <!-- <?php
                            unset($v_current_date_work);
                            unset($get_data_work)
                            ?> -->


                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>