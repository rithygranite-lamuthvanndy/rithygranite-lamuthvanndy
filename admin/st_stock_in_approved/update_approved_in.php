<?php 
    $menu_active =1;
    $layout_title = "Welcome";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header_frame.php'
?>
<?php
    if(@$_GET['parent']){
        $v_id=@$_GET['parent'];
        $sql="SELECT *,(in_price*in_qty) AS amo,B.stpron_code,B.stpron_name_kh,user_name
                                            FROM tbl_st_stock_in_detail AS A 
                                            LEFT JOIN tbl_st_product_name AS B ON A.pro_id=B.stpron_id
                                            LEFT JOIN tbl_user AS C ON A.user_approved=C.user_id
                                            WHERE stsin_id='$v_id'";
        $result_detail=$connect->query($sql);
        
    }
?>
<style type="text/css">
    .switch {
        position: relative;
        display: inline-block;
        width: 90px;
        height:50px;
    }

    .switch input #togBtn {display:none;}

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ca2222;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    #togBtn:checked + .slider { background-color: #2ab934;}

    #togBtn:focus + .slider { box-shadow: 0 0 1px #2196F3;}

    #togBtn:checked + .slider:before {
        -webkit-transform: translateX(55px);
        -ms-transform: translateX(55px);
        transform: translateX(55px);
    }

    /*------ ADDED CSS ---------*/
    .on{display: none;}

    .on, .off
    {
        color: white;
        position: absolute;
        transform: translate(-50%,-50%);
        top: 50%;
        left: 50%;
        font-size: 10px;
        font-family: Verdana, sans-serif;
    }

    #togBtn:checked + .slider .on{display: block;}

    #togBtn:checked + .slider .off{display: none;}

    /*--------- END --------*/

    /* Rounded sliders */
    .slider.round {border-radius: 34px;}

    .slider.round:before {border-radius: 50%;}
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="text-center text-primary">
            <h2 class="bold text-uppercase">Approved Stock In</h2>
        </div>
    </div>
    <hr>
    
    <div>
        <div>Approved All</div> 
        <label class="switch">
            <input type="checkbox" style="display: none;" id="togBtn" name="check_all_view" onchange="change_views(this);">
                <div class="slider round">
                    <span class="on">YES</span>
                    <span class="off">NO</span>
                </div>
        </label>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_3" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <th class="text-center">N&deg;</th>
                    <th class="text-center">Product Code</th>
                    <th class="text-center">Product Name</th>
                    <th class="text-center">QUANTITY</th>
                    <th class="text-center">PRICE</th>
                    <th class="text-center">AMOUNT</th>
                    <th class="text-center">User Approved</th>
                    <th class="text-center">Approved</th>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($result_detail)) {      
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-left">'.$row->stpron_code.'</td>';
                                echo '<td class="text-left">'.$row->stpron_name_kh.'</td>';
                                echo '<td class="text-left">'.$row->in_qty.'</td>';
                                echo '<td class="text-left">'.number_format($row->in_price,2).'</td>';
                                echo '<td class="text-left">'.number_format($row->amo,2).'</td>';
                                echo '<td class="text-left">'.$row->user_name.'</td>';
                                echo '<td class="text-left">';
                                        echo '<label class="switch">';
                                                echo '<input style="display: none;" type="checkbox" id="togBtn" data-parent-id='.$row->std_id.' name="rdoAppr" onchange="change_view(this);" '.(($row->in_approved)?('checked'):('')).'>
                                                        <div class="slider round">
                                                            <span class="on">YES</span>
                                                            <span class="off">NO</span>
                                                        </div>';
                                        echo '</label>';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
    include_once '../layout/footer_frame.php'
 ?>
<script type="text/javascript">
    function change_view (args) {
        let v_view=$(args).prop('checked');
        let v_man_id=$(args).parents('tr').find('td:last-child').find('input').attr('data-parent-id');
        let arr=[{v_view,v_man_id}];
        $.ajax({url: "ajax_update_appro.php",
            type: "POST",
            data: "myData="+JSON.stringify(arr),
            async: false,
            success: function(data,status){ 
        }});
    }
    function change_views (args) {
        var check=$(args).prop('checked');
        let v_arrs=[];
        if(check){
            $('td:last-child').find('label>input').prop("checked", !$(this).prop("checked"));
            $('td:last-child').find('label>input').each(function () {
                var v_view=$(this).prop('checked');
                var v_man_id = $(this).parents('tr').find('td:last-child').find('input').attr('data-parent-id');
                let arr={v_view,v_man_id};
                v_arrs.push(arr);
            });
            $.ajax({url: "ajax_update_appro.php",
                type: "POST",
                data: "myData="+JSON.stringify(v_arrs),
                async: false,
                success: function(data,status){ 
                    myAlertInfo("Approved !");
            }});
        }
        else{
            $('td:last-child').find('label>input').removeAttr('checked');
            $('td:last-child').find('label>input').each(function () {
                var v_view=$(this).prop('checked');
                var v_man_id = $(this).parents('tr').find('td:last-child').find('input').attr('data-parent-id');
                let arr={v_view,v_man_id};
                v_arrs.push(arr);
            });
            $.ajax({url: "ajax_update_appro.php",
                type: "POST",
                data: "myData="+JSON.stringify(v_arrs),
                async: false,
                success: function(data,status){ 
                    myAlertInfo("Disable !");
            }});
        }
    }
</script>