<style type="text/css">
    .page-actions{
        /*border: 1px solid yellow;*/
        max-width: 40%;
        overflow: auto;
        white-space: nowrap;
        padding: 10px;
    }
   /* width */
    .page-actions::-webkit-scrollbar {
      /*width: 20px;*/
      height: 5px;
    }

    /* Track */
    .page-actions::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey; 
      border-radius: 10px;
    }
     
    /* Handle */
    .page-actions::-webkit-scrollbar-thumb {
      background: #ccc; 
      border-radius: 10px;
    }

    /* Handle on hover */
    .page-actions:hover::-webkit-scrollbar-thumb{
        min-height: 10px!important;
        background: #CF8AFF; 
    }
    .page-actions:hover::-webkit-scrollbar{
        min-height: 10px!important;
    }
</style>
<div class="page-actions">
    <li class="btn-group">
        <a href="../dashboard/" class="btn red-haze btn-sm <?= (@$menu_active==0)?("active"):("") ?>">Dashboard</a>
    </li>
    <li class="btn-group">
        <a href="../pro_user/" class="btn red-haze btn-sm <?= (@$menu_active==168)?("active"):("") ?>">Profile User</a>
    </li>
    <li class="btn-group">
        <a href="../prod_menu/" class="btn red-haze btn-sm <?= (@$menu_active==11)?("active"):("") ?>">Production</a>
    </li>
    <li class="btn-group">
        <a href="../op_operation/index.php" class="btn red-haze btn-sm <?= (@$menu_active==13)?("active"):("") ?>">Operation</a>
    </li>
    <li class="btn-group">
        <a href="../acc_account/index.php" class="btn red-haze btn-sm <?= (@$menu_active==20)?("active"):("") ?>">Account</a>
    </li>
    <li class="btn-group">
        <a href="../hr_menu/index.php" class="btn red-haze btn-sm <?= (@$menu_active==33)?("active"):("") ?>">HR</a>
    </li>
    <li class="btn-group">
        <a href="../admin_menu/index.php" class="btn red-haze btn-sm <?= (@$menu_active==44)?("active"):("") ?>">Admin</a>
    </li>
    <li class="btn-group">
        <a href="../document/index.php" class="btn red-haze btn-sm <?= (@$menu_active==55)?("active"):("") ?>">Document</a>
    </li>
    <li class="btn-group">
        <a href="../cus_customer/index.php" class="btn red-haze btn-sm <?= (@$menu_active==120)?("active"):("") ?>">Customer</a>
    </li>
    <li class="btn-group">
        <a href="../sup_supplier/index.php" class="btn red-haze btn-sm <?= (@$menu_active==130)?("active"):("") ?>">Supplier</a>
    </li>
    <li class="btn-group">
        <a href="../st_stock_menu/" class="btn red-haze btn-sm <?= (@$menu_active==140)?("active"):("") ?>">Stock</a>
    </li>

     <li class="btn-group">
        <a href="../fix_asset_management/" class="btn red-haze btn-sm <?= (@$menu_active==141)?("active"):("") ?>">Fixed Asset Management</a>
    </li>
    
    <li class="btn-group">
        <a href="../inv_menu/" class="btn red-haze btn-sm <?= (@$menu_active==145)?("active"):("") ?>">Granite Inventory</a>
    </li>
    <li class="btn-group">
        <a href="../qc_menu/" class="btn red-haze btn-sm <?= (@$menu_active==146)?("active"):("") ?>">QC</a>
    </li>
    <li class="btn-group">
        <a href="../pro_project_menu/index.php" class="btn red-haze btn-sm <?= (@$menu_active==150)?("active"):("") ?>">Project</a>
    </li>
    <li class="btn-group">
        <a href="../contact/index.php" class="btn red-haze btn-sm <?= (@$menu_active==111)?("active"):("") ?>">Contact</a>
    </li>
    <li class="btn-group">
        <a href="../meeting_menu/index.php" class="btn red-haze btn-sm <?= (@$menu_active==101)?("active"):("") ?>">Meeting</a>
    </li>
    <li class="btn-group">
        <a href="../cash_flow/index.php" class="btn red-haze btn-sm <?= (@$menu_active==115)?("active"):("") ?>">Cash Flow</a>
    </li>
    <li class="btn-group">
        <a href="../working_flow/" class="btn red-haze btn-sm <?= (@$menu_active==122)?("active"):("") ?>">Working Flow</a>
    </li>
    <div class="btn-group">
        <button type="button" class="btn red-haze btn-sm dropdown-toggle <?= (@$menu_active==2)?("active"):("") ?>" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <span class="hidden-sm hidden-xs">Website&nbsp;</span>
            <i class="fa fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="../news/">Post News</a></li>
        </ul>
    </div>
        <!-- Menu For Developer -->
        <?php if($_SESSION['user']->user_position==15|| $v_user_position == 1){?>
            <li class="btn-group">
                <a href="../developer_menu/" class="btn red-haze btn-sm <?= (@$menu_active==12)?("active"):("") ?>">Developer</a>
            </li>
        <?php } ?>
    <li class="btn-group">
        <a href="../user/" class="btn red-haze btn-sm <?= (@$menu_active==10)?("active"):("") ?>">User</a>
    </li>
    <li class="btn-group">
        <a href="../system/" class="btn red-haze btn-sm <?= (@$menu_active==6)?("active"):("") ?>">Help</a>
    </li>
    <?php 
        // $v_get_menu = $connect->query("SELECT A.* FROM tbl_main_menu AS A 
        //     INNER JOIN tbl_left_menu AS B ON B.lm_main_menu=A.mm_id 
        //     INNER JOIN tbl_permission AS C ON C.p_module=B.lm_id
        //     INNER JOIN tbl_user AS E ON E.user_position=C.p_position
        //     WHERE E.user_id=".$_SESSION['user']->user_id."
        //     AND C.p_view='1'
        //     GROUP BY A.mm_id
        //     ORDER BY mm_index_order ASC");
        // while ($row_menu = mysqli_fetch_object($v_get_menu)) {
        //     echo '<li class="btn-group"><a href="../'.$row_menu->mm_directory.'/" class="btn '.((@$menu_active == $row_menu->mm_index_order)?("active"):("")).' red-haze btn-sm">'.$row_menu->mm_name.'</a></li> ';
        // }
    ?> 
</div>