<?php
$layout_title = "Welcome Account";
$menu_active = 20;
$left_active=76;
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="text-center">Welcome: Account</h2>
            <!-- <button type="button" class="btn btn-info" name="btn_testing">Testing</button> -->
            <hr>
        </div>
    </div>
    <div style="border: 2px dashed black;">
        <img src="../../img/img_system/flow_account_page_1.png" alt="" class="img-responsive" width="100%">
        <img src="../../img/img_system/flow_account_page_2.png" alt="" class="img-responsive" width="100%">
    </div>
</div>
<script type="text/javascript">
    $('button[name=btn_testing]').click(function() {
        let myArr = new Array("Thyda", "Vanda", "Mesa");
        alert(myArr);
        $.ajax({
            url: 'ajax_testing.php',
            type: 'POST',
            data: 'data=' + myArr,
            success: function(result) {
                alert(result);
            },
            error: function() {
                alert("Error");
            }
        });
    });
</script>
<?php include_once '../layout/footer.php' ?>