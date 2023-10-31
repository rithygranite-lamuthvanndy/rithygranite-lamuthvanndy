<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <?php
            // echo $menu_active; 
            // $v_sql_get_menu = "SELECT B.* FROM tbl_main_menu AS A 
            //             INNER JOIN tbl_left_menu AS B ON B.lm_main_menu=A.mm_id 
            //             INNER JOIN tbl_permission AS C ON C.p_module=B.lm_id
            //             INNER JOIN tbl_user AS E ON E.user_position=C.p_position
            //             WHERE E.user_id=" . $_SESSION['user']->user_id . "
            //             AND mm_index_order='$menu_active'
            //             AND C.p_view='1'
            //             GROUP BY B.lm_id
            //             ORDER BY lm_index_order ASC";
            // // AND lm_index_order<=130
            // $v_get_menu = $connect->query($v_sql_get_menu);
            // while ($row_menu = mysqli_fetch_object($v_get_menu)) {
            //     if ($row_menu->lm_status == 2)
            //         echo '<li class="heading"><h3 class="uppercase">' . $row_menu->lm_name . '</li></h3></li>';
            //     else{
            //         echo '<li class="nav-item ' . (($left_active == $row_menu->lm_id) ? 'active' : '') . '"><a href="../' . $row_menu->lm_directory . '" class="nav-link nav-toggle"><i class="icon-diamond"></i><span class="title">' . $row_menu->lm_name . '</span></a></li>';
            //     }
            // }
            ?>

            <?php
            $current_date = date('Y-m-d');
            ?>

            <li class="heading">
                <h3 class="uppercase">Feature</h3>
            </li>
            <li class="nav-item" style="font-family: 'Khmer OS';">
                <a href="../acc_add_cash_record/index.php" class="nav-link">
                    <i class="fa fa-list"></i>
                    <?php
                    $sql = $connect->query("SELECT accdr_date FROM tbl_acc_cash_record WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')='$current_date' AND status=1");
                    $count_cash_record = mysqli_num_rows($sql);
                    ?>
                    <span class="title">Add Cash Record / បន្ថែមការកត់ត្រាសាច់ប្រាក់ </span>
                    <span class="badge badge-info"><?= $count_cash_record ?></span>
                </a>
            </li>
            <li class="nav-item" style="font-family: 'Khmer OS';">
                <a href="../acc_add_expenses/index.php" class="nav-link">
                    <i class="fa fa-list"></i>
                    <?php
                    $sql = $connect->query("SELECT accdr_date FROM tbl_acc_cash_record WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')='$current_date' AND status=1");
                    $count_cash_record = mysqli_num_rows($sql);
                    ?>
                    <span class="title">Expenses ចំណាយ </span>
                    <span class="badge badge-info"><?= $count_cash_record ?></span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_none_sale_revenue/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <?php
                    $sql = $connect->query("SELECT accdr_date FROM tbl_acc_cash_record WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')='$current_date' AND status=2");
                    $count_none_cash_record = mysqli_num_rows($sql);
                    ?>
                    <span class="title">Add None-Cash Record / បន្ថែមប្រតិបត្តិការណ៍មិនមែនសាច់ប្រាក់</span>
                    <span class="badge badge-info"><?= $count_none_cash_record ?></span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_add_account_adjustment/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Add Account Record</span>
                </a>
            </li>
            <!--<li class="nav-item start " style="font-family: 'khmer os';">-->
            <!--    <a href="../acc_add_personal_transation/" class="nav-link nav-toggle">-->
            <!--        <i class="fa fa-list"></i>-->
            <!--        <span class="title">Personal Transaction </span>-->
            <!--    </a>-->
            <!--</li>-->
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_add_tra_amount/" class="nav-link nav-toggle">
                    <!-- <a href="../acc_add_transaction/" class="nav-link nav-toggle"> -->
                    <i class="fa fa-list"></i>
                    <span class="title">Add Transaction</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_opening_bal/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Openning Balance </span>
                    <?php
                    $sql = $connect->query("SELECT date_audit FROM tbl_acc_open_bal WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$now'");
                    ?>
                    <span class="badge badge-danger"><?= mysqli_num_rows($sql) ?></span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_add_banking/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Banking </span>
                    <?php
                    $sql = $connect->query("SELECT date_audit FROM tbl_acc_open_bal WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$now'");
                    ?>
                    <span class="badge badge-danger"><?= mysqli_num_rows($sql) ?></span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i> <span class="title">Account</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_chart_account/index.php" class="nav-link nav-toggle">
                            <i class="fa fa-minus"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_chart_account WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Chart Account (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="../acc_account_type/index.php" class="nav-link nav-toggle">
                            <i class="fa fa-minus"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_type_account WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Account Type / ប្រភេទគណនេយ្យ (<?= $count ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="../acc_chart_main/" class="nav-link nav-toggle">
                            <i class="fa fa-minus"></i>
                            <?php
                            $sql = $connect->query("SELECT * FROM tbl_acc_main_account");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Main Of Account (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../acc_chart_sub/" class="nav-link nav-toggle">
                            <i class="fa fa-minus"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_chart_sub WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Sub Main Of Account (<?= $count ?>)</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <!--  <a href="../acc_account_data_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <?php
                    $sql = $connect->query("SELECT date_audit FROM tbl_acc_type_account WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                    $count = mysqli_num_rows($sql);
                    ?>
                    <span class="title">Data List</span>
                </a> -->
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i> <span class="title">Data List</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                     <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../exchange_rate/index.php" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                           
                            <span class="title">Exchange Rate</span>
                        </a>
                    </li>
                    <?php
                    $current_date = date('Y-m-d');
                    ?>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_month_year/index.php" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_month_year WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Month Year List / បញ្ជីខែ/ឆ្នាំ (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_project/index.php" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_project WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Project List / បញ្ជីផែនការ (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_tax/index.php" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_tax WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Tax List / បញ្ជីពន្ធដារ (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_item/index.php" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_item WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Item List (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_des_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_decription WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Description List​ (<?= $count ?>)</span>
                        </a>
                    </li>

                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_voucher_type/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT count(vot_code) FROM tbl_acc_voucher_type_list");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Voucher Type / ប្រភេទសក្ខីប័ត្រ: (<?= $count ?>)</span>
                        </a>
                    </li>

                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_expenses_type_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_expense_type_list WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Expense Type List (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_dir_tra_type_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_director_tran_type WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Director Transation Type List (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_cash_tran_type_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <?php
                            $sql = $connect->query("SELECT date_audit FROM tbl_acc_transaction_type_list WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                            $count = mysqli_num_rows($sql);
                            ?>
                            <span class="title">Cash Transation Type List (<?= $count ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_type_cash_bank/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <!--  <?php
                                    $sql = $connect->query("SELECT date_audit FROM tbl_acc_transaction_type_list WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                                    $count = mysqli_num_rows($sql);
                                    ?> -->
                            <span class="title">Type Cash /Bank</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="" class="nav-link nav-toggle">
                            <i class="fa fa-money"></i> <span class="title">Other List</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start " style="font-family: 'khmer os';">
                                <a href="../acc_other_rec_form_list/" class="nav-link nav-toggle">
                                    <i class="fa fa-info"></i>
                                    <span class="title">Other Rec From List</span>
                                </a>
                            </li>
                            <li class="nav-item start " style="font-family: 'khmer os';">
                                <a href="../acc_other_pay_to_list/" class="nav-link nav-toggle">
                                    <i class="fa fa-info"></i>
                                    <span class="title">Other Pay To List</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_position_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <!--  <?php
                                    $sql = $connect->query("SELECT date_audit FROM tbl_acc_transaction_type_list WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                                    $count = mysqli_num_rows($sql);
                                    ?> -->
                            <span class="title">Position List</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="heading">
                <h3 class="uppercase">Report</h3>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i> <span class="title">Report Daily List</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_rep_cash_on_hand/" class="nav-link nav-toggle">
                            <i class="fa fa-info"></i>
                            <span class="title">Cash Daily</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_rep_cash_rec_daily/" class="nav-link nav-toggle">
                            <i class="fa fa-info"></i>
                            <span class="title">Cash Daily Summary</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i> <span class="title">Report Cash Bank List</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_rep_bank_daily_summary/" class="nav-link nav-toggle">
                            <i class="fa fa-info"></i>
                            <span class="title">Bank Record Summary</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_rep_bank_daily_detail/index.php?bank_satatus=2" class="nav-link nav-toggle">
                            <i class="fa fa-info"></i>
                            <span class="title">Bank Record Agri</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_rep_bank_daily_detail/index.php?bank_satatus=1" class="nav-link nav-toggle">
                            <i class="fa fa-info"></i>
                            <span class="title">Bank Record Vatanac</span>
                        </a>
                    </li>
                    <li class="nav-item start " style="font-family: 'khmer os';">
                        <a href="../acc_rep_bank_daily_detail/index.php?bank_satatus=6" class="nav-link nav-toggle">
                            <i class="fa fa-info"></i>
                            <span class="title">Bank Record NCB</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_journal/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Journal / ទិនានុប្បវត្តិ</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_ledger/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Ledger / សៀវភៅធំ</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_trial_balance/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Trial Balance / តារាងតុល្យការសាកល្បង</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_income_statment/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Income Statment</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_balance_sheet/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Balance Sheet / តារាងតុល្យការ</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>