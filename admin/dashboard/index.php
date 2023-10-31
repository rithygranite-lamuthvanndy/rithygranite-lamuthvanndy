<?php 
    $layout_title = "Welcome Dashboard";
    $menu_active =0;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<script>
function myFunction() {
  document.getElementById("panel").style.display = "block";
}
</script>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-sm-12">
            
            <div class="col-sm-4 text-center">
              <img src="../../img/img_logo/logo.png" width="330px" alt="logo" class="img-responsive img-responsive img-thumbnail" />
            </div>
            <div class="col-sm-8">
              <h1 style="font-family: 'Times New Roman'; color: blue;"><b> Rithy Granite (Cambodia) Co,.LTD</b></h1>
              <h2><b> ក្រុមហ៊ុន ឫទ្ធី ក្រានីត (ខេមបូឌា) ខូ អិលធីឌី</b></h2>
            </div>

            
        </div>
    </div>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="../dashboard/">Get things done</a>
        </li>
        <li role="presentation">
            <a href="../dashboard-bo/">Business Overview</a>
        </li>
    </ul> 
    
    <div class="col-lg-12">
      <div class="portlet-body col-lg-4">
          <div class="panel panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">Profit and Loss</h3>
              </div>
              <div class="panel-body">
                  <h1 style="font-family: 'Times New Roman';"><b> $ 0</b></h1>
                  <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>NET INCONE FOR <?= date('M') ?></b></h4>
                  <br><br>

                  <h4 style="font-family: 'Times New Roman';"><b> $ 0</b></h4>
                  <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>INCONE</b></h4>

                  <h4 style="font-family: 'Times New Roman';"><b> $ 0</b></h4>
                  <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>EXPENSES</b></h4>
              </div>
          </div>
      </div>
      <div class="portlet-body col-lg-4">
          <div class="panel panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">Expenses</h3>
              </div>
              <div class="panel-body">
                  <h1 style="font-family: 'Times New Roman';"><b> $ 0.00</b></h1>
                  <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>LAST MONTH</b></h4>
                  <br><br>
              </div>
          </div>
      </div>
      <div class="portlet-body col-lg-4">
          <div class="panel panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">Bank Accounts</h3>
              </div>
              <div class="panel-body">
                  <table width="100%">
                    <tr>
                      <th></th>
                      <th></th>
                    </tr>
                    <tr>
                      <td style="font-family: 'Times New Roman'; color: #00B050; font-size: 20px;">Checking - 1234</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #ddd;">In Quickbooks</td>
                      <td style="text-align: right; border-bottom: 1px solid #ddd;">$ 8,100.00</td>
                    </tr>
                    <tr>
                      <td style="font-family: 'Times New Roman'; color: #00B050; font-size: 20px;">Visa - 1234</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #ddd;">In Quickbooks</td>
                      <td style="text-align: right; border-bottom: 1px solid #ddd;">$ 0.00</td>
                    </tr>
                  </table>
              </div>
          </div>
      </div>      
    </div>

    <div class="col-lg-12">
      <div class="portlet-body col-lg-4">
          <div class="panel panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">Invoices</h3>
              </div>
              <div class="panel-body">
                  <h1 style="font-family: 'Times New Roman';"><b> $ 0.00</b></h1>
                  <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>LAST MONTH</b></h4>
                  <br><br>
              </div>
          </div>
      </div>
      <div class="portlet-body col-lg-4">
          <div class="panel panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">Sales</h3>
              </div>
              <div class="panel-body">
                  <h1 style="font-family: 'Times New Roman';"><b> $ 0.00</b></h1>
                  <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>LAST MONTH</b></h4>
                  <br><br>
              </div>
          </div>
      </div>
      <div class="portlet-body col-lg-4">
          <div class="panel panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">Dicover</h3>
              </div>
              <div class="panel-body">
                  <h1 style="font-family: 'Times New Roman';"><b> $ 0.00</b></h1>
                  <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>LAST MONTH</b></h4>
                  <br><br>
              </div>
          </div>
      </div>      
    </div>  

        <div class="col-sm-12">
            <h2 style="font-family: 'Times New Roman';"><i class="fa fa-folder-open"></i><b> Workspace</b></h2>
        </div>

	   <div class="row" id="myDIV">
        <div class="col-sm-12">
            <h2 style="font-family: 'Times New Roman';"><i class="fa fa-folder-open"></i><b> Workspace</b></h2>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>
              <p><b>Profit and Loss</b></p>
            </div>
            <div class="icon">
              <i class="fa fa-play"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>
              <p><b>Expenses</b></p>
            </div>
            <div class="icon">
              <i class="fa fa glyphicon glyphicon-list-alt"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>
              <p><b>Income</b></p>
            </div>
            <div class="icon">
              <i class="fa glyphicon glyphicon-edit"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p><b>Bank accounts</b></p>
            </div>
            <div class="icon">
              <i class="fa glyphicon glyphicon-folder-close"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


    </div>

<p>Click the button to find out if the DIV is hidden. If it is, then display it.</p>

<button onclick="myFunction()">Try it</button>

<div id="myDIV">
This is my DIV element.
</div>

<p>Some text...</p>
  	<?php 
  		if(isset($_GET['status'])){
  			echo '<script>myAlertInfo("'.$_SESSION['user']->user_name.' Please enjoy with your account !");</script>';
          }
  	?>
    </div>
</div>

<!-- ChartJS -->
<script src="../../bower_components/Chart.js/Chart.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->

<?php include_once '../layout/footer.php' ?>

<style>
#myDIV {
  width: 100%;
  padding: 50px 0;
  margin-top: 20px;
  display: none;
}
</style>
<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (window.getComputedStyle(x).display === "none") {
    x.style.display = "block";
  }else{
    x.style.display = "none";
  }
}
</script>