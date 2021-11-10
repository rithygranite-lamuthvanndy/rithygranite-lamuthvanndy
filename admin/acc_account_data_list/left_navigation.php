<div class="page-sidebar-wrapper">
   <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../dashboard/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            

            <?php 
                $current_date=date('Y-m-d');
             ?>

            <li class="heading">
                <h3 class="uppercase">Feature</h3>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_month_year/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_month_year WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                     ?>
                    <span class="title">Month Year List / បញ្ជីខែ/ឆ្នាំ (<?= $count ?>)</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_project/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                     <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_project WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                     ?>
                    <span class="title">Project List / បញ្ជីផែនការ (<?= $count ?>)</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_tax/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_tax WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                    ?>
                    <span class="title">Tax List / បញ្ជីពន្ធដារ (<?= $count ?>)</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_item/index.php" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_item WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                    ?>
                    <span class="title">Item List (<?= $count ?>)</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_des_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                     <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_decription WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                    ?>
                    <span class="title">Description List​ (<?= $count ?>)</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_expenses_type_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                     <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_expense_type_list WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                    ?>
                    <span class="title">Expense Type List (<?= $count ?>)</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_dir_tra_type_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                     <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_director_tran_type WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                    ?>
                    <span class="title">Director Transation Type List (<?= $count ?>)</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_cash_tran_type_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                     <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_transaction_type_list WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                    ?>
                    <span class="title">Cash Transation Type List (<?= $count ?>)</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_type_cash_bank/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <!--  <?php 
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_transaction_type_list WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
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
                        $sql=$connect->query("SELECT date_audit FROM tbl_acc_transaction_type_list WHERE DATE_FORMAT(date_audit,'%Y-%m-%d')='$current_date'");
                        $count=mysqli_num_rows($sql);
                    ?> -->
                    <span class="title">Position List</span>
                </a>
            </li>
            <li class="nav-item start " style="font-family: 'khmer os';">
                <a href="../acc_account/" class="nav-link nav-toggle">
                    <i class="fa fa-undo"></i> Back
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>