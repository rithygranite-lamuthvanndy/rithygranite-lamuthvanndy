<?php 
    $menu_active =2;
    $layout_title = "Welcome to News Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-cubes fa-fw"></i> News Administrator</h2>
        </div>
    </div>
    <br>
    <br>
    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Title</th>
                        <th class="text-center">Image</th>
                        <th>Description</th>
                        <th>Posted By</th>
                        <th>Created At</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>                                 
                    <?php 
                        $i = 0;
                        $get_data = $connect->query("SELECT * FROM tbl_news AS N LEFT JOIN tbl_user AS U ON U.user_id=N.news_posted_by ORDER BY news_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->news_title_en.'</td>';
                                echo '<td class="text-center"><img class="img-thumbnail" style="height: 40px;" src="../../img/img_news/'.$row->news_image.'"/></td>';
                                echo '<td>'.$row->news_description_en.'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->news_created_at.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->news_id.'&edit_img='.$row->news_image.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a href="delete.php?del_id='.$row->news_id.'&del_img='.$row->news_image.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                    echo '<a href="../../news_detail.php?news_id='.$row->news_id.'" target="_blank" class="btn btn-xs btn-info" title="copy"><i class="fa fa-info-circle fa-fw"></i></a> ';
                                    
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
