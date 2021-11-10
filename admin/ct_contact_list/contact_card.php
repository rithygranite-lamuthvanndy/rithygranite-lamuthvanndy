<?php 
    $menu_active =111;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<style type="text/css">
    div.contact_card{
        width: 500px; height: 280px;
        margin: 50px auto;
        border: 1px solid #444;
        box-shadow: 0px 0px 5px 2px #666;
        position: relative;
    }
    div.contact_card div.photo{ position: absolute; left: 30px; top: 30px; width: 100px;  }
    div.contact_card div.photo img{ width: 100%; border-radius: 5px; border: 1px solid #ddd; padding: 2px; }
    div.contact_card div.info_right{width: 320px; position: relative; left: 150px; top: 30px; }
    div.contact_card div.info_right p.full_name{
        color: #12668C; font-weight: bolder;
        font-size: 24px; font-family: 'verdana';
        margin: 0px; 
    }
    div.contact_card div.info_right p.position{
        color: #444; font-family: 'verdana';
        font-size: 16px; font-weight: lighter;
    }
    div.contact_card div.info_right p.company{ color: #12668C; font-family: 'verdana'; font-size: 16px; font-weight: lighter; }
    div.contact_card div.detail { width: 440px; position: absolute; top: 150px; left: 30px; }
    div.contact_card div.detail p{ margin: 4px;  }
    div.contact_card div.detail p.email{ color: #12668C; }
</style>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Contact Card</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a onclick="window.close();" id="sample_editable_1_new" class="btn red"> Close
                <i class="fa fa-undo"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <?php 
                $contact_id = @$_GET['ct_id'];
                $get_data = $connect->query("SELECT *,GROUP_CONCAT(ctp_number SEPARATOR ' | ') AS phone_number FROM tbl_ct_contact_list AS A 
                    LEFT JOIN tbl_ct_position AS C ON A.ctco_position=C.ctpo_id
                    LEFT JOIN tbl_ct_company AS B ON A.ctco_company=B.ctcom_id
                    LEFT JOIN tbl_ct_contact_phone AS P ON P.ctp_id=A.ctco_id
                WHERE ctco_id='$contact_id'");
                $row = mysqli_fetch_object($get_data);
            ?>
            <div class="contact_card">
                <div class="photo">
                    <img src="../../img/img_contact_list/<?= $row->ctco_photo ?>" alt="">
                </div>
                <div class="info_right">
                    <p class="full_name"><strong><?= $row->ctco_full_name ?></strong></p>
                    <p class="position"><?= $row->ctpo_name ?></p>
                    <p class="company"><?= $row->ctcom_company_name ?></p>
                </div>
                <div class="detail">
                    <p>
                        <img src="../../img/img_contact_card/phone.png" width="20px"> : <?= $row->phone_number ?>
                    </p>
                    <p class="email">
                        <img src="../../img/img_contact_card/email.png" width="20px"> : <?= $row->ctco_email1 ?> <?php if($row->ctco_email2){ echo " | ".$row->ctco_email2; } ?>
                    </p>
                    <p>
                        <img src="../../img/img_contact_card/address.png" width="20px"> : <?= $row->ctco_address ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>





<?php include_once '../layout/footer.php' ?>
