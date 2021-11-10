<?php
  if(isset($_SESSION["status"])) {
    $action_menu=$_SESSION["status"];
  }
  else {
    $action_menu="";
  }

  if(isset($_GET['status'])){
        $v_status=$_GET['status'];
        $_SESSION['status']=$v_status;
        $stock_pro=$_SESSION['status'];

   }
  else {
    if(isset($_SESSION["status"])) {
        $stock_pro=$_SESSION['status'];
    }
    else {
        $stock_pro="";
    }
    
  }
?>

<style type="text/css">
    .my_sub {
        padding-left: 10% !important;
    }

    .my_sub a i.fa-spin {
        color: red !important;
    }
</style>
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

            <li class="nav-item">
                <a href="../st_stock_menu/index.php?status=0&action=0" class="nav-link nav-toggle ">
                <i class="fa fa-archive"></i>
                <span class="title">Home Stock</span>
                </a>
            </li>
            <hr>
            <li class="nav-item" 
            <?php
              if($menu_active==140 && $stock_pro==1) {
            ?>
            style="background:#9cd192;"
        <?php } ?>
            >
                <a href="../st_1_1_mine_factory_usually/index.php?status=1&action=1" class="nav-link nav-toggle ">
                    <i>I. </i>
                    <span class="title">Product Mine Stock</span>
                    <!-- <span class="arrow"></span> -->
                </a>
               <!--  <ul class="sub-menu">
                    <li class="nav-item start ">
                    <li class="nav-item start ">
                        <a href="../st_1_1_mine_factory_usually/?status=1" class="nav-link nav-toggle">
                            <span class="title">1. សំភារប្រើប្រាស់ប្រចាំថ្ងៃ</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="#" class="nav-link nav-toggle">
                            <span class="title">2. សំភារប្រើប្រាស់ម្ដងម្កាល</span>
                        </a>
                    </li>
                </ul> -->
            </li>
            <li class="nav-item"  <?php
                      if($menu_active==140 && $stock_pro==2) {
                    ?>
                    style="background:#9cd192;"
                <?php } ?> 
        >
                <a href="../st_1_1_mine_factory_usually/index.php?status=2&action=1" class="nav-link nav-toggle">
                    <i>II. </i>
                    <span class="title">Product Factory Stock</span>
                    <!-- <span class="arrow"></span> -->
                </a>
                <!-- <ul class="sub-menu">
                    <li class="nav-item start ">
                    <li class="nav-item start ">
                        <a href="../st_1_1_mine_factory_usually/?status=2" class="nav-link nav-toggle">
                            <span class="title">1. សំភារប្រើប្រាស់ប្រចាំថ្ងៃ</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="#" class="nav-link nav-toggle">
                            <span class="title">2. សំភារប្រើប្រាស់ម្ដងម្កាល</span>
                        </a>
                    </li>
                </ul> -->
            </li>
           
               
                    
                    <li class="nav-item" <?php
              if( $menu_active==140 && $stock_pro==3) {
            ?>
            style="background:#9cd192;"
        <?php } ?> >
                        <a href="../st_2_spare_part/index.php?status=3&action=1" class="nav-link nav-toggle">
                            <i>III. </i>
                            <span class="title">Manufacturing Supplies</span>
                        </a>
                    </li>
                    <li class="nav-item" <?php
              if( $menu_active==140 && $stock_pro==5) {
            ?>
            style="background:#9cd192;"
        <?php } ?> >
                        <a href="../st_2_spare_part_2/index.php?status=5&action=1" class="nav-link nav-toggle">
                            <i>IV. </i>
                            <span class="title">Non Routine Manufacturing </span>
                        </a>
                    </li>
               
            <li class="nav-item"
             <?php
             if($menu_active==140 && $stock_pro==4) {
            ?>
            style="background:#9cd192;"
        <?php } ?>

            >
                <a href="../st_3_feul/index.php?status=4&action=1" class="nav-link nav-toggle">
                    <i>V. </i>
                    <span class="title">Fuel Stock</span>
                </a>
            </li>
            <li class="nav-item"
             <?php
             if($menu_active==140 && $stock_pro==6) {
            ?>
            style="background:#9cd192;"
        <?php } ?>
            >
                <a href="" class="nav-link nav-toggle">
                    <i style="color: red;">VI. </i>
                     <span class="title" style="color: red;">Non Fixed Asset</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" 
                <?php
                if($menu_active==140 &&
                    ($stock_pro==10 || $stock_pro==11 || $stock_pro==12 || $stock_pro==13
                     || $stock_pro==14 || $stock_pro==15 || $stock_pro==16 || $stock_pro==17
                     || $stock_pro==18  ) 
                  ) 
                {
                ?>
                style="display: block;"
                <?php
                  }
                ?>
                >
                    <li class="nav-item" 
                     <?php
                     
                     if($menu_active==140 && $stock_pro==10) {
            ?>
            style="background:#9cd192;"
        <?php } ?>
                    >
                        <a href="../st_nfa_Non_Fixed_Asset/index.php?status=6&action=1" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">Non Fixed Asset</span>
                        </a>
                    </li>
                    <li class="nav-item" id="ass">
                        <a href="../st_none_fix_asset/add_in.php?f=2" class="nav-link nav-toggle">
                            <span class="title" style="color: red;">Assigning</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../st_none_fix_asset/add_in.php?f=3" class="nav-link nav-toggle">
                            <span class="title" style="color: red;">Written of Asset</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../st_none_fix_asset/add_in_des.php" class="nav-link nav-toggle">
                            <span class="title" style="color: red;">Disposal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../st_category_list/nfa_cat.php" class="nav-link nav-toggle">
                            <span class="title" style="color: red;">Non FA Category</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item 
            <?php
                if($menu_active==140 &&
                    ($stock_pro==10 || $stock_pro==11 || $stock_pro==12 || $stock_pro==13
                     || $stock_pro==14 || $stock_pro==15 || $stock_pro==16 || $stock_pro==17
                     || $stock_pro==18  ) 
                  ) 
                {
                    echo 'open';

                }
                ?>
                
                

            ">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-sliders"></i>
                     <span class="title" style="color: red;">Stock Data List</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" 
                <?php
                if($menu_active==140 &&
                    ($stock_pro==10 || $stock_pro==11 || $stock_pro==12 || $stock_pro==13
                     || $stock_pro==14 || $stock_pro==15 || $stock_pro==16 || $stock_pro==17
                     || $stock_pro==18  ) 
                  ) 
                {
                ?>
                style="display: block;"
                <?php
                  }
                ?>
                >
                    <li class="nav-item" 
                     <?php
                     
                     if($menu_active==140 && $stock_pro==10) {
            ?>
            style="background:#9cd192;"
        <?php } ?>
                    >
                        <a href="../st_product_name/index.php?status=10" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">1.Product Name</span>
                        </a>
                    </li>
                    <li class="nav-item"
                    <?php
                     if($menu_active==140 && $stock_pro==11) {
            ?>
            style="background:#9cd192;"
        <?php } ?>

                    >
                        <a href="../st_track_machince_list/?status=11" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">2.Machines and machinery​ List</span>
                        </a>
                    </li>
                    <li class="nav-item"
                    <?php
                    if($menu_active==140 && $stock_pro==12) {
            ?>
            style="background:#9cd192;"
        <?php } ?>


                    >
                        <!-- <a href="../st_product_set_stock/index.php?status=12" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">Product Set Stock</span>
                        </a> -->
                    </li>
                    <li class="nav-item"
                     <?php
                    if($menu_active==140 && $stock_pro==13) {
            ?>
            style="background:#9cd192;"
        <?php } ?>

                    >
                        <a href="../st_branch_list/index.php?status=13" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">3.Branch Receive List</span>
                        </a>
                    </li>
                    <li class="nav-item"
                    <?php
                    if($menu_active==140 && $stock_pro==14) {
            ?>
            style="background:#9cd192;"
        <?php } ?>

                    >
                        <a href="../st_manager_list/index.php?status=14" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">4.Manager List</span>
                        </a>
                    </li>
                    <li class="nav-item"
                     <?php
                    if($menu_active==140 && $stock_pro==15) {
            ?>
            style="background:#9cd192;"
        <?php } ?>

                    >
                        <a href="../st_unit_list/index.php?status=15" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">5.Unit List</span>
                        </a>
                    </li>
                    <li class="nav-item"
                    <?php
                    if($menu_active==140 && $stock_pro==16) {
            ?>
            style="background:#9cd192;"
        <?php } ?>

                    >
                        <a href="../st_material_type_list/index.php?status=16" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">6.Material Type List</span>
                        </a>
                    </li>
                    <li class="nav-item"
                    <?php
                   if($menu_active==140 && $stock_pro==17) {
            ?>
            style="background:#9cd192;"
        <?php } ?>
                    >
                        <a href="../st_category_list/index.php?status=17" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">7.Category List</span>
                        </a>
                    </li>
                    <li class="nav-item"
                    <?php
                     if($menu_active==140 && $stock_pro==18) {
            ?>
            style="background:#9cd192;"
        <?php } ?>>
                        <a href="../st_product_type_list/index.php?status=18" class="nav-link nav-toggle">
                            
                            <span class="title" style="color: red;">8.Production Type List</span>
                        </a>
                    </li>
                </ul>
            </li>

            <hr>

            <li class="heading">
                <h3 class="uppercase">Report</h3>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-file"></i>
                    <span class="title">I. របាយការណ៍ប្រើប្រាស់សម្ភារៈផលិត</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start ">
                        <a href="../st_rep_mine/" class="nav-link nav-toggle">
                            <span class="title">a-នៅរណ្តៅ</span>
                        </a>
                    </li>
                     <li class="nav-item start ">
                        <a href="../st_rep_factory/" class="nav-link nav-toggle">
                            <span class="title">b-នៅរោងចក្រ</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-file"></i>
                    <span class="title">II. របាយការណ៍ជួសជុល</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start ">
                        <a href="../st_re_truck_check/" class="nav-link nav-toggle">
                            <span class="title">a-ប្រវត្តិគ្រឿងចក្រនីមួយៗ</span>
                        </a>
                    </li>
                     <li class="nav-item start ">
                        <a href="../st_rep_truck_expens/" class="nav-link nav-toggle">
                            <span class="title">b-ប្រវត្តិគ្រឿងចក្រសរុបប្រចាំឆ្នាំ</span>
                        </a>
                    </li>

                    <li class="nav-item start ">
                        <a href="../st_rep_truck_expens_years/" class="nav-link nav-toggle">
                            <span class="title">c-ប្រវត្តិគ្រឿងចក្រសរុបប្រចាំឆ្នាំទាំងអស់</span>
                        </a>
                    </li>

                    <li class="nav-item start ">
                        <a href="../st_re_truck_repare/" class="nav-link nav-toggle">
                            <span class="title">d-សម្ភារៈជួសជុល(រណ្តៅ, រោងចក្រ)</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-file"></i>
                    <span class="title">III. Non Fixed Asset</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start ">
                        <a href="../st_rep_none_fix_asset/" class="nav-link nav-toggle">
                            <span class="title">Non Fixed Asset</span>
                        </a>
                    </li>
                     
                    
                </ul>
            </li>
              
               

            <!-- <li class="nav-item">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-file"></i>
                    <span class="title">I. របាយការណ៍ជួសជុល</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start ">
                        <a href="../st_rep_his_truck/" class="nav-link nav-toggle">
                            <span class="title">1. ប្រវត្តិគ្រឿងចក្រ</span>
                        </a>
                    </li>
                </ul>
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-file"></i>
                    <span class="title">II. របាយការណ៍ប្រេង</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start ">
                        <a href="../st_rep_his_fuel/" class="nav-link nav-toggle">
                            <span class="title">1. ប្រវត្តិប្រេង</span>
                        </a>
                    </li> 
                </li>  -->

            </ul> 

                    <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>

<style type="text/css">
     .table th {
        
            background: #DDEBF7 !important;
            font-weight: bold !important;
            border: 1px solid white !important;
    }
</style>