<?php
$layout_title = "Welcome Dashboard";
$menu_active = 55;
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>
<link rel="stylesheet" href="dist/css/contextMenu.min.css">
<style>
    .mybox,
    .mybox:hover {
        border: 1px solid black;
        text-decoration: none;
        color: black;
        font-weight: bold;
        font-size: 15px;
        background-repeat: no-repeat;
        background-size: cover !important;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-top: 10px;
        height: 100px;
        margin: 5px;
    }

    .mybox:hover {
        color: blue;
        font-size: 20px;
    }

    .myContainer {
        min-height: 200px;
        background-color: #fcf3fe;
    }
</style>
<?php
$v_action = @$_GET['action'] ? $_GET['action'] : 1;
$v_child_id = @$_GET['child_id'] ? $_GET['child_id'] : 1;
$v_user_id = @$_SESSION['user']->user_id;
?>
<div class="portlet light bordered" style="width:99%!important; position: absolute; left: 2%;">
    <input name="txt_child_id" type="hidden" value="<?= $v_child_id ?>" />
    <input name="txt_dep" type="hidden" value="<?= $v_action ?>" />
    <div class=" row">
        <div class="col-xs-12">
            <marquee behavior="alternate">
                <h3 style="font-family: 'Times New Roman'; font-weight: bold;">Welcome: Document Management</h3>
            </marquee>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <?php
            $v_sql = "SELECT * FROM tbl_doc_department ORDER BY docdep_id";
            $v_result_tab = $connect->query($v_sql);
            while ($row_tab = mysqli_fetch_object($v_result_tab)) {
                echo '<li role="presentation" class="' . ($v_action == $row_tab->docdep_id ? 'active' : '') . '">
                            <a href="index.php?action=' . $row_tab->docdep_id . '">
                                <i class="fa fa-book"></i>' . $row_tab->docdep_name . '
                            </a>
                        </li>';
            }
            ?>
        </ul>
    </div>
    <div class="clearfix"></div>
    <center>
        <div class="row myContainer">
            <?php
            $v_dep_id = $v_action;
            if (isset($_GET['child_id']) && @$_GET['child_id'] != 1) {
                $v_child_id = $_GET['child_id'];
                $condition = "AND docdoc_child_id='$v_child_id'";
            } else {
                $condition = "AND docdoc_child_id=1";
            }
            $v_sql = "SELECT * 
                        FROM tbl_doc_document AS A
                        WHERE docdoc_department='$v_dep_id' and
                        user_id='$v_user_id'
                        {$condition}
                        ";
            // echo $v_sql;
            $result = $connect->query($v_sql);
            while ($row = mysqli_fetch_object($result)) {
                $v_background = "url('img/" . ($row->docdoc_type == 1 ? 'folder.jpg' : 'file.png') . "')";
                echo '<a data_child="' . $row->docdoc_id . '" file_name="' . $row->docdoc_old_file_name . '" href="index.php?action=' . $row->docdoc_department . '&child_id=' . $row->docdoc_id . '" 
                class="col-xs-1 col-sm-1 col-md-1 col-lg-1 mybox" style="background: ' . $v_background . '">';
                echo $row->docdoc_title;
                echo '</a>';
            }
            ?>
        </div>
    </center>
</div>
<a id="my_iframe" style="display:none;"></a>
<?php include_once '../layout/footer.php' ?>
<script src="dist/js/contextMenu.min.js"></script>
<script src="download2.js"></script>
<script>
    var child_id_clicked = 0;
    var file_name = null;
    $('a').mousedown(function(e) {
        if (e.which == 3) {
            child_id_clicked = $(this).attr('data_child');
            file_name = $(this).attr('file_name');
        }
    });

    var v_parent_path = `${$('input[name=txt_path]').val()}`;
    var v_child_id = $('input[name=txt_child_id]').val();
    var v_department = $('input[name=txt_dep]').val();
    var data = [
        [{
                text: "<i class='fa fa-folder site-cm-icon'></i> New Folder",
                action: function() {
                    v_folder_name = prompt("Enter New Folder Name:", "New Folder");
                    datatmp = {
                        v_department,
                        v_child_id,
                        v_parent_path,
                        v_folder_name
                    }
                    $.post("ajx_operation.php", {
                            createFolder: datatmp
                        },
                        function(data) {
                            myAlertInfo(data);
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    );
                }
            },
            {
                text: "<i class='fa fa-copy site-cm-icon'></i> Copy Folder"
            },
            {
                text: "<i class='fa fa-trash site-cm-icon'></i> Delete Folder/File",
                action: function() {
                    v_cfm = confirm("Are you sure to delete this ?");
                    if (v_cfm) {
                        datatmp = {
                            child_id_clicked
                        }
                        $.post("ajx_operation.php", {
                                deleteFolder: datatmp
                            },
                            function(data) {
                                myAlertInfo(data);
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }
                        );
                    }
                    // v_folder_name = prompt("Enter New Folder Name:", "New Folder");
                }
            },
            {
                text: "<i class='fa fa-undo site-cm-icon'></i> Move Folder"
            },
            {
                text: "<i class='fa fa-share-alt site-cm-icon'></i> Share Folder"
            },
            {
                text: "<hr>"
            },
            {
                text: "<i class='fa fa-upload site-cm-icon'></i> Upload File",
                action: function() {
                    view_iframe_upload_image(v_child_id, v_department);
                }
            },
            {
                text: "<i class='fa fa-download site-cm-icon'></i> View/Download File",
                action: function() {
                    if (file_name) {
                        url = "../../file/file_attatch_document/" + file_name;
                        window.open(url);
                    }
                }
            },
        ]
    ];
    $(document).ready(function() {
        $('.myContainer').contextMenu(data);

        $('#modal').on('hidden.bs.modal', function() {
            location.reload();
        });
    });

    function view_iframe_upload_image(e, dep_id) {
        $('#modal').modal('show');
        document.getElementById('result_modal').src = 'upload.php?child_id=' + e + '&dep=' + dep_id;
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" style="margin-left: 17%;">
        <iframe id="result_modal" frameborder="0" style="height: 500px; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>

<script type="text/javascript">
    // var _gaq = _gaq || [];
    // _gaq.push(['_setAccount', 'UA-36251023-1']);
    // _gaq.push(['_setDomainName', 'jqueryscript.net']);
    // _gaq.push(['_trackPageview']);

    // (function() {
    //     var ga = document.createElement('script');
    //     ga.type = 'text/javascript';
    //     ga.async = true;
    //     ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    //     var s = document.getElementsByTagName('script')[0];
    //     s.parentNode.insertBefore(ga, s);
    // })();
</script>