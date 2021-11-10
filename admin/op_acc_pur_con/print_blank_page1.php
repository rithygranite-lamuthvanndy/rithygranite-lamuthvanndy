<?php include_once '../../config/database.php';?>
<?php 
    $uncheck='<img src="uncheck.png">';
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body id ="content">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">  
    <style>
        *{ font-family: 'khmer os content'; font-size: 12px; }
        @media print{
            #my_green{
                background-color: #E2EFDA !important;
                -webkit-print-color-adjust: exact; 
            }
            #my_pink{
                background-color: #E7E6E6 !important;
                -webkit-print-color-adjust: exact; 
            }
            #my_blue{
                background-color: #D9E1F2 !important;
                -webkit-print-color-adjust: exact; 
            }
            #table_1 tr >td,#table_1 tr >th{
              border-collapse: collapse;
              border: 1px black solid;
              padding:15px;
            }
            tr:nth-of-type(5) td:nth-of-type(1) {
              visibility: hidden;
            }
            .rotate {
              transform: rotate(-90.0deg);
              white-space: nowrap;
            }
            .par_rotate{
                text-align: center;
                max-width: 30px;
                width: 10px;
            }
            #table_2 tr >td,#table_2 tr >th{
                padding: 10px;
                border-collapse: collapse;
                border: 1px black solid;
            }
        }
    </style>
    <div class="text-center">
        <h2 class="text-uppercase" style="text-decoration: underline; font-family: 'Times New Roman'!important; color: #8B57F5!important;">Purchase Confirmation Form</h2>
    </div>
    <br>
    <table id="table_1" style="width: 100%;">
            <tr id="my_green">
                <th colspan="3">Purchase Request_Information</th>
            </tr>
            <tr id="my_pink">
                <th colspan="3">
                    <div class="pull-right">   
                        Purchaser Responsibility
                    </div>
                </th>
            </tr>
            <tbody>
                <tr>
                    <td>
                        <div class="pull-left">
                            1/Date Request:
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?= $uncheck; ?>
                            </label>
                        </div> 
                    </td>
                    <td rowspan="4" class="par_rotate" id="my_pink">
                        <div class="rotate">Cash Advance Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            1/Date:
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            2/Request No :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php echo $uncheck; ?>
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            2/Amount Received :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>      
                            </label>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="pull-left">
                            3/Department of RGC  : 
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            3/Actual Expense :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            4/Type of Request No: (***) :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            4/Cash Reimbursement :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                </tr>
                <tr></tr>
                <tr>
                    <td>
                        <div class="pull-left">
                            5/Request by :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                    <td rowspan="2" class="par_rotate" id="my_pink">
                        <div class="rotate">Purchase Date</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            5/Date of Purchse :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="pull-left">
                            6/Approve by : 
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            6/Date of Delivery  :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            7/Amount Request :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                    <td rowspan="3" class="par_rotate" id="my_pink">
                        <div class="rotate">Supplier Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            7/Supply Name:
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            8/Location :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>  
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            8/Area Purchase:
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            9/Responsible Purchase :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            9/Phone Number:
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td rowspan="2">
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>Note: </label>
                            </div>
                        </div>
                    </td>
                    <td rowspan="2"class="par_rotate" id="my_pink">
                        <div class="rotate">Site Received Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            10/Date of Purchse :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                            </label>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="pull-left">
                            11/Date of Delivery :
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                            </label>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                                <b>Prepared by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                                <b>Acknowledged by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                                <b>Prepared by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                                <b>Acknowledged by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                    </td>    
                </tr>
            </tbody>
        </table>
    <table id="table_2">
        <tbody>
            <tr>
                <th colspan="4" id="my_green">Purchase Request_Information</th>
            </tr>
            <tr>
                <th colspan="4" id="my_pink">
                    <div class="pull-right">   
                        Accountant or Account Manager Responsibility
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="4">*** Type of Request and Reference Requirement:</th>
            </tr>
            <tr id="my_blue">
                <th class="text-center" rowspan="2">No</th>
                <th class="text-center" rowspan="2">Type of Request</th>
                <th class="text-center" colspan="2">Reference Requirement</th>
            </tr>
            <tr id="my_blue">
                <th class="text-center">Permanent Request</th>
                <th class="text-center">Temporary Request</th>
            </tr>
            <tr>
                <td>1</td>
                <td>From $1 - $200</td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 2/រូបភាព

                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 2/រូបភាព

                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php   
                                    echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)

                            </label>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>from $201 - $300</td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php   
                                    echo $uncheck;
                                 ?>
                                 2/រូបភាព

                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                   echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)

                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ

                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 2/រូបភាព

                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)

                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុល

                            </label>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td rowspan="2">From $301 -$1000</td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 2/រូបភាព

                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)

                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 5/ផែនការប្រើប្រាស់សំភារៈផលិត

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 6/Quotation

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 7/ផ្សេងៗ

                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>

                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)

                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុល

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 5/ផែនការប្រើប្រាស់សំភារៈផលិត

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 6/Quotation

                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    echo $uncheck;
                                 ?>
                                 7/ផ្សេងៗ

                            </label>
                        </div>
                    </div>
                </td>
            </tr>
            <!-- Footer -->
            <tr>
                <th colspan="4">
                    <div class="container-fluid">
                        <p>Description :</p>
                        <div style="border: 0.5px dashed black;"></div>
                    </div>
                    <br>
                    <div class="container-fluid">
                        <p>Note :</p>
                        <br>    
                        <br>    
                        <br>    
                        <div style="border: 0.5px dashed black;"></div>
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    <div class="row">
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <div style="width: 50%; margin: auto;">
                                <b>Prepared by </b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <div style="width: 50%; margin: auto;">
                                <b>Checked by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    <div class="row">
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <div style="width: 50%; margin: auto;">
                                <b>First Approved by </b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <div style="width: 50%; margin: auto;">
                                <b>Second Approved by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <script src="../../assets/global/plugins/jquery.min.js"></script>
    <script src="../../print_offline/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.par_rotate').each(function(e){
                $v_parent_width = $('.par_rotate').eq(e).width();
                $v_parent_height = $('.par_rotate').eq(e).height()+15;
                $('.rotate').eq(e).width($v_parent_height+'px');
                $('.rotate').eq(e).css('margin-left','-'+(($v_parent_height/2))+'px');
                $('.rotate').eq(e).css('margin-top',($v_parent_height/2)-10+'px');
            });
        });
    </script>
</body>
</html>
<script type="text/javascript">
    window.onload=function(){
        // $('.par_rotate').each(function(e){
        //     $v_parent_width = $('.par_rotate').eq(e).width();
        //     $v_parent_height = $('.par_rotate').eq(e).height()+15;
        //     $('.rotate').eq(e).width($v_parent_height+'px');
        //     $('.rotate').eq(e).css('margin-left','-'+(($v_parent_height/2))+'px');
        //     $('.rotate').eq(e).css('margin-top',($v_parent_height/2)-10+'px');
        // });
      var printme=document.getElementById('content');
      var wme=window.open("","","width=1200px");
      wme.document.write(printme.outerHTML);
      wme.document.close();
      wme.focus();
      wme.print();
      wme.close();
    }
  setTimeout(function(){
  window.close();
  },1000);
</script>