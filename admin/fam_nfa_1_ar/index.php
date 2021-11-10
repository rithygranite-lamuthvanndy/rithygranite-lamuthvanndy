<?php 
    $menu_active =141;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
?>


<div class="portlet light bordered">
                        <section class="content-header">                       
                            <div class="col-lg-8">
                                <?= @$sms ?>
                                <div class="col-lg-2">
                                    <img src="../../img/img_nfa/nfa.png" alt="" width="100px">
                                </div>
                                <div class="col-lg-8">
                                    <h2><b>Non Fixed Asset</b></h2>
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <a href="add.php?view=<?= @$_GET['view'] ?>" id="sample_editable_1_new" class="btn green"> Add New
                                            <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                
                            </div>

                    </section>
                    <div class="col-lg-12">
                        <hr>
                    </div>

    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th class="all">N&deg;</th>
                        <th class="all">Asset ID*</th>
                        <th class="all">Description*</th>
                        <th class="all">Cost*</th>
                        <th class="all">Unit</th>
                        <th class="all">Model</th>
                        <th class="all">Serial</th>
                        <th class="all">Barcode</th>
                        <th class="all">Condition</th>
                        <th class="all">Note</th>
                        <th class="all">Picture</th>
                        <th class="all">Pic_Description</th>
                        <th class="all">Location*</th>
                        <th class="all">Section*</th>
                        <th class="all">Department</th>
                        <th class="all">Group</th>
                        <th class="all">Acquired*</th>
                        <th class="all">In Service</th>
                        <th class="all">Sold*</th>
                        <th class="all">Date Sold</th>
                        <th style="min-width: 100px;" class="all text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_fam_nfa_1_ar AS A 
                            left join tbl_fix_locat as B on B.locat_id=A.fam_location
                            left join tbl_fix_section as C on C.sect_id=A.fam_section
                            left join tbl_fix_depart as D on D.dep_id=A.fam_depart
                            left join tbl_fix_group as E on E.gr_id=A.fam_group
                            ORDER BY fam_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->fam_id_code.'</td>';
                                echo '<td>'.$row->fam_desc.'</td>';
                                echo '<td>'.$row->fam_cost.'</td>';
                                echo '<td>'.$row->fam_unit.'</td>';
                                echo '<td>'.$row->fam_model.'</td>';
                                echo '<td>'.$row->fam_serial.'</td>';
                                echo '<td>'.$row->fam_barcode.'</td>';
                                echo '<td>'.$row->fam_condition.'</td>';
                                echo '<td>'.$row->fam_note.'</td>';
                                echo '<td>'.$row->fam_photo.'</td>';
                                echo '<td>'.$row->fam_desc_pho.'</td>';
                                echo '<td>'.$row->locat_name.'</td>';
                                echo '<td>'.$row->sect_name.'</td>';
                                echo '<td>'.$row->dep_name.'</td>';
                                echo '<td>'.$row->gr_name.'</td>';
                                echo '<td>'.$row->fam_date_acquired.'</td>';
                                echo '<td>'.$row->fam_date_inservice.'</td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->fam_sold_id.'"></td>';
                                echo '<td>'.$row->fam_date_sold.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->fam_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->fam_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
    if(@$_GET['view']=='iframe')
        include_once '../layout/footer_frame.php';
    else
        include_once '../layout/footer.php';
 ?>
