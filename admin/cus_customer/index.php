<?php 
    $layout_title = "Welcome Dashboard";
    $menu_active =120;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    require_once('../../plugin/PHPExcel/Classes/PHPExcel.php');

    class Excel extends PHPExcel
    {
     public function __construct()
     {
      parent::__construct();
     }
}
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2>Welcome: Customer Management</h2>
			<hr>
        </div>
    </div>
 <div class="container">
  <br />
  <h3 align="center">How to Import Excel Data into Mysql in Codeigniter</h3>
  <form method="post" id="import_form" enctype="multipart/form-data">
   <p><label>Select Excel File</label>
   <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
   <br />
   <input type="submit" name="import" value="Import" class="btn btn-info" />
  </form>
  <br />
  <div class="table-responsive" id="customer_data">

  </div>
 </div>
    <br>
    <br>
	<br>
    <br>
    <br>
	<br>
    <br>
    <br>
	<br>
    <br>
    <br>
	<br>
    <br>
    <br>
	<br>
    <br>
    <br>
	<br>
    <br>
    <br>
	<br>
    <br>
    <br>
	<br>
    <br>
    <br>
	<br>
    <br>
    
    
    
</div>






<?php include_once '../layout/footer.php' ?>
<script>
$(document).ready(function(){

 load_data();

 function load_data()
 {
  $.ajax({
   url:"<?php echo base_url(); ?>excel_import/fetch",
   method:"POST",
   success:function(data){
    $('#customer_data').html(data);
   }
  })
 }

 $('#import_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>excel_import/import",
   method:"POST",
   data:new FormData(this),
   contentType:false,
   cache:false,
   processData:false,
   success:function(data){
    $('#file').val('');
    load_data();
    alert(data);
   }
  })
 });

});
</script>