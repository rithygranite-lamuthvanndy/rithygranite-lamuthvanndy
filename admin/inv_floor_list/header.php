
<!DOCTYPE html>
<!--
    
    COPY RIGHT @ 2018 BY NEW DAY TECHNOLOGY

-->
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?= @$layout_title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #4 for blank page layout" name="description" />
        <meta content="" name="author" />
        
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" /> -->
        <link href="https://fonts.googleapis.com/css?family=Khmer&family=Time New Roman" rel="stylesheet">
        <style>
            *{
                font-family: 'Khmer', 'Time New Roman';
            }
        </style>
        <link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"/>
        <link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
                
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../../assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <!-- <link href="../../assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" /> -->
        <link href="../../assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <!-- <link href="../../assets/global/css/components-rounded.css" rel="stylesheet" id="style_components" type="text/css" /> -->
        <link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../../assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../../assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        



        <!-- bootstrap select -->
        <link rel="stylesheet" href="../../assets/global/plugins/bootstrap-select-1.12.4/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css">
        <!-- end bootstrap select -->
        <!-- Switch Button -->
        <link rel="stylesheet" href="../../assets/global/css/switch_button.css">
        <!-- end Switch Button -->

        

        <script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
        
        <!-- Boostrap Notify -->
        <link rel="stylesheet" type="text/css" href="../../plugin/boostrap-notify/CSS/animate.min.css">
        <script type="text/javascript" src="../../plugin/boostrap-notify/JS/bootstrap-notify.min.js"></script>
        <!-- Sweet Alert -->
        <script type="text/javascript" src="../../plugin/SweetAlert/sweetalert.min.js"></script>
        
        <!-- Operation -->
        <script type="text/javascript" src="../../plugin/My_Operation/operation.js"></script>
        <link rel="shortcut icon" href="favicon.ico" /> 
    </head>
    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
        <?php 

            if(isset($_GET['status'])){
                if(($_GET['status'])=="success1"){
                  if(@unserialize($_COOKIE['pass'])=="")
                    header('location: ../dashboard/');
                  else{
                    $v_user_id=@unserialize($_COOKIE['pass']);
                    $sql=$connect->query("SELECT * FROM tbl_user WHERE user_id='$v_user_id'");
                    $user_data=mysqli_fetch_object($sql);
                    $_SESSION['user']=$user_data;
                  }
                }
                else if(($_GET['status'])=="success2"){
                  if(@$_SESSION['user']==""){
                    header('location: ../dashboard/');
                  }
                }
                echo '<script>myLogInSuccess("Please Enjoy with your account ");</script>';
            }
            // if(!@$_SESSION['user'])
            //     header('location: ../../');
         ?>
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="../../index.php">
                        <img src="../../img/img_logo/logo.png" width="100px" alt="logo" class="logo-default" /> 
                    </a>

                    <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                
                <!-- BEGIN PAGE ACTIONS -->
                <!-- DOC: Remove "hide" class to enable the page header actions -->

                <?php
                
                    // Declear Global Config
                    include '../../plugin/My_Operation/my_operation.php';
                    // die($_SESSION['user']->user_position);
                
                    //Global variable 
                    $now=date('Y-m-d');
                    $user_id=@$_SESSION['user']->user_id;
                    $v_user_position=@$_SESSION['user']->user_position;
                    $date_time=date('Y-m-d H:i s');

                    if($v_user_position== 1){
                        include_once('top_navigation.php'); 
                    }else if($v_user_position == 2){
                        include_once('top_navigation_user.php'); 
                    }
                    else if($v_user_position == 12||$v_user_position==13)
                        include_once('top_navigation_sale.php');
                    else
                        include_once('top_navigation.php');
                ?>
                <!-- END PAGE ACTIONS -->
                
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                           
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <small><i class="fa fa-circle" style="color: lightgreen;"></i></small>
                                    <span class="username username-hide-on-mobile"> <?= @$_SESSION['user']->user_name ?> </span>

                                    <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                    <img alt="" class="img-circle" src="../../img/img_user/<?= @$_SESSION['user']->user_photo ?>" /> </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    
                                    <?php
                                        if((@$_SESSION['user']->user_position == 15)||(@$_SESSION['user']->user_position == 10)){
                                            echo '<li>
                                                <a href="../user/">
                                                    <i class="icon-user"></i> User Managment</a>
                                            </li>
                                            <li class="divider"> </li>';
                                        }
                                    ?>
                                    <li>
                                        <a href="#" name="back_up">
                                            <i class="fa fa-cloud-upload"></i>Back Up 
                                        </a>
                                        <script>
                                            $('a[name=back_up]').click(function () {
                                                $.ajax({url: '../../back_up/class_library/ajax_back_up.php',success:function (result) {
                                                    myAlertInfo(result);
                                                }});
                                            });

                                            //Global Javascript plug in
                                            function roundUp(num, precision) {
                                              precision = Math.pow(10, precision)
                                              return Math.ceil(num * precision) / precision
                                            }
                                        </script>
                                    </li>
                                       <!-- <?= '<script>myAlertSuccess("ffff")</script>' ?> -->
                                    <li>
                                        <a href="../../login.php?action=logout">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <li class="dropdown dropdown-extended quick-sidebar-toggler">
                                <span class="sr-only">Toggle Quick Sidebar</span>
                                <i class="icon-logout"></i>
                            </li>
                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            
            <!-- BEGIN SIDEBAR -->

            <?php 
                $sql=$connect->query("SELECT * FROM tbl_main_menu WHERE mm_index_order='$menu_active'");
                while ($row_left=mysqli_fetch_object($sql)) {
                    include_once '../'.$row_left->mm_directory.'/left_navigation.php'; 
                }
                    // include_once getcwd().'/left_navigation.php'; 
            ?>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content" style="transform: translate(0px,-10px);">