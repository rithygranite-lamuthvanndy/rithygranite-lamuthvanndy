<?php 
    $menu_active =122;
    $left_active =64;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';

    if(isset($_POST['btn_submit'])){
        $v_title = @$_POST['txt_title'];
        $v_image = @$_FILES['txt_file'];
        $v_doc_id = @$_POST['txt_parent_id'];
        if($v_image["name"] != ""){
            $ext = pathinfo($v_image["name"], PATHINFO_EXTENSION);
            $new_name = date("Ymd")."_".rand(1111,9999).'.'.$ext;
            move_uploaded_file($v_image["tmp_name"], "../../file/file_attatch_document/".$new_name);


            $connect->query("INSERT INTO tbl_doc_attach_file(docatt_title,docatt_attach,docatt_document_id) VALUES('$v_title','$new_name','$v_doc_id')");
            // header('location: list_attach.php');
        }else{
            $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Please Choose Image ...
                </div>';
        }
    }else if(@$_GET['del_id'] != ""){
        $del_id = @$_GET['del_id'];
        $connect->query("DELETE FROM tbl_doc_attach_file WHERE docatt_id='$del_id'");

        $old_file = @$_GET['old_file'];
        if(file_exists('../../file/file_attatch_document/'.$old_file)){
            unlink('../../file/file_attatch_document/'.$old_file);
        }
    }


    // get old data 
    $v_id = @$_GET['sent_id'];
    $old_data = $connect->query("SELECT * FROM tbl_doc_document WHERE docdoc_id='$v_id'");
    $row_old_data = mysqli_fetch_object($old_data);


?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Attach File</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <?= attach_file(); ?>
            <a href="index.php" id="sample_editable_1_new" class="btn red">
                <i class="fa fa-undo"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th class="text-center">N&deg;</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Open File to Edit</th>
                        <th class="text-center">File</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_doc_attach_file AS A 
                            LEFT JOIN  tbl_doc_document AS B ON A.docatt_title=B.docdoc_id
                            WHERE docatt_document_id = '$v_id'
                            ORDER BY docatt_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-center">'.$row->docatt_title.'</td>';
                                echo '<td class="text-center">';
                                    $arr=explode('.', $row->docatt_attach);
                                    $exe=$arr[1];
                                    echo '<div class="btn-group">';
                                        if($exe=='docx'||$exe=='docm'||$exe=='dotx'||$exe=='dotm'||$exe=='docb'||$exe=='pptx'||$exe=='pptm'||$exe=='ppt'||$exe=='xlsx'||$exe=='xlsm'||$exe=='xltx'||$exe=='xltm')
                                            echo '<button title="Open File" type="button" class="btn btn-info btn-xs" file_name='.$row->docatt_attach.'>Open File</button>';
                                        echo '<button title="Save File" type="button" class="btn btn-success btn-xs" style="display: none;">Save File</button>';
                                    echo '</div>';
                                echo '</td>';
                                echo '<td class="text-center"><a href="../../file/file_attatch_document/'.$row->docatt_attach.'">DOWNLOAD <i class="fa fa-download"></i></a></td>';
                                echo '<td class="text-center">';
                                echo button_delete_file($row->docatt_id,$row->docatt_attach,$_GET['sent_id']);
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    //Crear File
    $(document).ready(function() {
        $.ajax({url: 'ajax_clear_file.php',success:function (result) {}});
    });
    $('td:nth-child(3) button:nth-child(2)').click(function () {
        var file_name=$(this).parent('div').find('button:nth-child(1)').attr('file_name');
        $.ajax({url:'ajax_update_file.php?data='+file_name,success:function (result) {
            if(result=='Save Completed'){
                setTimeout(function () {
                    $('td:nth-child(3) button:nth-child(2)').hide();
                },2000);    
            }
            alert(result);
        }});
    });
    $('td:nth-child(3) button:nth-child(1)').click(function () {
        //$('td:nth-child(3) button:nth-child(2)').addClass("btn-lg");
        var file_name=$(this).attr('file_name');
        var this_path=window.location.origin;
        var x=new XMLHttpRequest();
        x.open("GET", this_path+"/rithygranite/file/file_attatch_document/"+file_name, true);
        x.responseType = 'blob';
        x.onload=function(e){download(x.response, file_name, ""); }
        x.send();   

        setInterval(function () {
            $.ajax({url:'ajax_check_file.php?data='+file_name,async:false,success:function (result) {
                if(result=='true'){
                    var exe=file_name.split('.').pop();
                    if(exe=='xlsx'||exe=='xlsm'||exe=='xltx'||exe=='xltm')
                        window.location.href = "ms-excel:ofe|u|D:/File_System/"+file_name;
                    else if(exe=='docx'||exe=='docm'||exe=='dotx'||exe=='dotm'||exe=='docb')
                        window.location.href = "ms-word:ofe|u|D:/File_System/"+file_name;
                    else if(exe=='pptx'||exe=='pptm'||exe=='ppt')
                        window.location.href = "ms-powerpoint:ofe|u|D:/File_System/"+file_name;
                }
            }});

        },1000);
        $(this).parents('td').find('button:nth-child(2)').css('display','block');
  });
</script>
<!-- //Laibrary Download -->
<script>
    (function (root, factory) {
        if (typeof define === 'function' && define.amd) {
            // AMD. Register as an anonymous module.
            define([], factory);
        } else if (typeof exports === 'object') {
            // Node. Does not work with strict CommonJS, but
            // only CommonJS-like environments that support module.exports,
            // like Node.
            module.exports = factory();
        } else {
            // Browser globals (root is window)
            root.download = factory();
        }
        }(this, function () {

    return function download(data, strFileName, strMimeType) {

        var self = window, // this script is only for browsers anyway...
            defaultMime = "application/octet-stream", // this default mime also triggers iframe downloads
            mimeType = strMimeType || defaultMime,
            payload = data,
            url = !strFileName && !strMimeType && payload,
            anchor = document.createElement("a"),
            toString = function(a){return String(a);},
            myBlob = (self.Blob || self.MozBlob || self.WebKitBlob || toString),
            fileName = strFileName || "download",
            blob,
            reader;
            myBlob= myBlob.call ? myBlob.bind(self) : Blob ;
      
        if(String(this)==="true"){ //reverse arguments, allowing download.bind(true, "text/xml", "export.xml") to act as a callback
            payload=[payload, mimeType];
            mimeType=payload[0];
            payload=payload[1];
        }


        if(url && url.length< 2048){ // if no filename and no mime, assume a url was passed as the only argument
            fileName = url.split("/").pop().split("?")[0];
            anchor.href = url; // assign href prop to temp anchor
            if(anchor.href.indexOf(url) !== -1){ // if the browser determines that it's a potentially valid url path:
                var ajax=new XMLHttpRequest();
                ajax.open( "GET", url, true);
                ajax.responseType = 'blob';
                ajax.onload= function(e){ 
                  download(e.target.response, fileName, defaultMime);
                };
                setTimeout(function(){ ajax.send();}, 0); // allows setting custom ajax headers using the return:
                return ajax;
            } // end if valid url?
        } // end if url?


        //go ahead and download dataURLs right away
        if(/^data\:[\w+\-]+\/[\w+\-]+[,;]/.test(payload)){
        
            if(payload.length > (1024*1024*1.999) && myBlob !== toString ){
                payload=dataUrlToBlob(payload);
                mimeType=payload.type || defaultMime;
            }else{          
                return navigator.msSaveBlob ?  // IE10 can't do a[download], only Blobs:
                    navigator.msSaveBlob(dataUrlToBlob(payload), fileName) :
                    saver(payload) ; // everyone else can save dataURLs un-processed
            }
            
        }//end if dataURL passed?

        blob = payload instanceof myBlob ?
            payload :
            new myBlob([payload], {type: mimeType}) ;


        function dataUrlToBlob(strUrl) {
            var parts= strUrl.split(/[:;,]/),
            type= parts[1],
            decoder= parts[2] == "base64" ? atob : decodeURIComponent,
            binData= decoder( parts.pop() ),
            mx= binData.length,
            i= 0,
            uiArr= new Uint8Array(mx);

            for(i;i<mx;++i) uiArr[i]= binData.charCodeAt(i);

            return new myBlob([uiArr], {type: type});
         }

        function saver(url, winMode){

            if ('download' in anchor) { //html5 A[download]
                anchor.href = url;
                anchor.setAttribute("download", fileName);
                anchor.className = "download-js-link";
                anchor.innerHTML = "downloading...";
                anchor.style.display = "none";
                document.body.appendChild(anchor);
                setTimeout(function() {
                    anchor.click();
                    document.body.removeChild(anchor);
                    if(winMode===true){setTimeout(function(){ self.URL.revokeObjectURL(anchor.href);}, 250 );}
                }, 66);
                return true;
            }

            // handle non-a[download] safari as best we can:
            if(/(Version)\/(\d+)\.(\d+)(?:\.(\d+))?.*Safari\//.test(navigator.userAgent)) {
                url=url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
                if(!window.open(url)){ // popup blocked, offer direct download:
                    if(confirm("Displaying New Document\n\nUse Save As... to download, then click back to return to this page.")){ location.href=url; }
                }
                return true;
            }

            //do iframe dataURL download (old ch+FF):
            var f = document.createElement("iframe");
            document.body.appendChild(f);

            if(!winMode){ // force a mime that will download:
                url="data:"+url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
            }
            f.src=url;
            setTimeout(function(){ document.body.removeChild(f); }, 333);

        }//end saver




        if (navigator.msSaveBlob) { // IE10+ : (has Blob, but not a[download] or URL)
            return navigator.msSaveBlob(blob, fileName);
        }

        if(self.URL){ // simple fast and modern way using Blob and URL:
            saver(self.URL.createObjectURL(blob), true);
        }else{
            // handle non-Blob()+non-URL browsers:
            if(typeof blob === "string" || blob.constructor===toString ){
                try{
                    return saver( "data:" +  mimeType   + ";base64,"  +  self.btoa(blob)  );
                }catch(y){
                    return saver( "data:" +  mimeType   + "," + encodeURIComponent(blob)  );
                }
            }

            // Blob but not URL support:
            reader=new FileReader();
            reader.onload=function(e){
                saver(this.result);
            };
            reader.readAsDataURL(blob);
        }
        return true;
    }; /* end download() */
}));
</script>

<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="modal_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close text-danger" data-dismiss="modal" aria-hidden="true">12  &times;</button>
                <h4 class="modal-title">Upload</h4>
            </div>
            <div class="modal-body">
               <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_parent_id" value="<?= $_GET['sent_id'] ?>">
                    <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" name="txt_title" required autocomplete="off">
                        <label>Title :
                            <span class="required" aria-required="true"></span>
                        </label>
                    </div>
                    <div class="form-group form-md-line-input">
                        <input required="" type="file" class="form-control" name="txt_file" placeholder="date record..."  autocomplete="off">
                        <label>Upload File :
                            <span class="required" aria-required="true"></span>
                        </label>

                    </div>
                    <div class="form-group text-center">
                        <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                        <button data-dismiss="modal" class="btn red"><i class="fa fa-undo fa-fw"></i>Close</button>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
