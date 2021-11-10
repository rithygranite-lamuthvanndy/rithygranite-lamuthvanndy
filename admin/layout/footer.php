 </div>
 <!-- END CONTENT BODY -->
 </div>
 <!-- END CONTENT -->
 </div>
 <!-- END CONTAINER -->

 <!-- BEGIN QUICK SIDEBAR -->
 <a href="javascript:;" class="page-quick-sidebar-toggler">
     <!-- <i class="icon-login"></i> -->
     <i class="icon-login"></i>
 </a>
 <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
     <div class="page-quick-sidebar">
         <ul class="nav nav-tabs">
             <li class="active">
                 <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                     <!-- <span class="badge badge-danger">2</span> -->
                 </a>
             </li>
         </ul>
         <div class="tab-content">
             <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                 <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">

                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- END QUICK SIDEBAR -->
 <!-- BEGIN FOOTER -->
 <footer class="page-footer">
    <strong>Copyright &copy; 2017 - <?= date("Y") ?> &copy; Developing By
         <a target="_blank" href="http://rithygranitecambodia.com">Rithy Granite (Cambodia)</a></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.4
    </div>
 </footer>
   <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
 <div class="scroll-to-top">
     <i class="icon-arrow-up"></i>
 </div>
 <!-- END FOOTER -->

 <!-- BEGIN CORE PLUGINS -->
 <script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
 <!-- END CORE PLUGINS -->

 <!-- BEGIN PAGE LEVEL PLUGINS -->
 <script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/bootstrap-select-1.12.4/js/bootstrap-select.min.js" type="text/javascript"></script>
 <!-- <script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script> -->
 <script src="../../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
 <script src="../../assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>

 <!-- END PAGE LEVEL PLUGINS -->

 <!-- BEGIN THEME GLOBAL SCRIPTS -->
 <script src="../../assets/global/scripts/app.min.js" type="text/javascript"></script>
 <script type="text/javascript" src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
 <script type="text/javascript" src="../../assets/pages/scripts/components-bootstrap-switch.min.js"></script>
 <script src="../../assets/pages/scripts/form-wizard.min.js" type="text/javascript"></script>
 <!-- END THEME GLOBAL SCRIPTS -->

 <!-- BEGIN PAGE LEVEL SCRIPTS -->
 <!-- <script src="../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script> -->
 <script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
 <!-- END PAGE LEVEL SCRIPTS -->
 <!-- BEGIN PAGE LEVEL SCRIPTS -->
 <script src="../../assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
 <script src="../../assets/pages/scripts/form-dropzone.min.js" type="text/javascript"></script>
 <!-- END PAGE LEVEL SCRIPTS -->


 <!-- BEGIN THEME LAYOUT SCRIPTS -->
 <script src="../../assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
 <script src="../../assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
 <script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
 <script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
 <!-- END THEME LAYOUT SCRIPTS -->
 <!-- bootstrap select -->
 <script src="../../assets/global/plugins/bootstrap-select-1.12.4/js/bootstrap-select.min.js" type="text/javascript"></script>
 <script type="text/javascript">
     $(document).ready(function() {
         $('.myselect2').select2({
             width: 'auto'
         });
         // $('.myselect2').css('width','100%');
         $('.date').datepicker({
             orientation: 'bottom'
         });
         $('.monthpicker').datepicker({
             orientation: 'bottom',
             format: "yyyy-mm",
             viewMode: "months",
             minViewMode: "months",
             autoclose: true
         });
         // Clear State Datatable
         // $('table[id^=sample]').state.clear();

         // Left Menu Active
         // var url = window.location; 
         // var url_flag=null;
         // var element = $('ul.page-sidebar-menu >li.nav-item >a').filter(function() {
         //                         return this.href == url || url.href.indexOf(this.href) == 0;
         //                     }).parent().addClass('active');
         //                         // url_flag=$(this).href;
         // if (element.is('li')) { 
         //   element.addClass('active').parent().parent('.sub-menu li').addClass('active');
         // }

         //Right Menu
         $('.quick-sidebar-toggler').click(function(event) {
             $.ajax({
                 url: '../../ajax_user_online.php?action=fetch_data',
                 type: "GET",
                 success: function(data) {
                     $('.page-quick-sidebar-chat-users').html(data);
                 }
             });
         });
         $.ajax({
             url: '../../ajax_user_online.php?action=update_user',
             type: "GET",
             success: function(data) {

                 // alert('ffff');
             }
         });
         // setInterval(function(){
         // }, 60000);//1 Minute
     });
     // });
 </script>
 <!-- end bootstrap select -->
 <!-- BEGIN THEME GLOBAL SCRIPTS -->
 <!-- <script src="../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script> -->
 <!-- END THEME GLOBAL SCRIPTS -->

 <!-- <script src="../../plugin/select2/select2.full.min.js"></script> -->
 <!-- Boot Box JS -->
 <script type="text/javascript" src="../../plugin/bootbox/bootbox.min.js"></script>
 <script type="text/javascript" src="../../plugin/boostrap-notify/JS/bootstrap-notify.min.js"></script>
 <!-- Numeral JS -->
 <script type="text/javascript" src="../../plugin/numeral/numeral.min.js"></script>
 <!-- Sweet Alert -->
 <script type="text/javascript" src="../../plugin/SweetAlert/sweetalert.min.js"></script>
 <!-- boostrap Notify -->
 <!-- <script type="text/javascript" src="../../plugin/boostrap-notify/JS/highlight.min.js"></script> -->
 <!-- <script type="text/javascript" src="../../plugin/boostrap-notify/JS/jquery.sharrre.js"></script> -->
 <!-- my Opeation -->
 <!-- <script type="text/javascript" src="../../plugin/My_Operation/operation.js"></script> -->
 </body>

 </html>
 <?php //mysqli_close($connect); 
    ?>
 <?php //exit(); 
    ?>