<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';

    $date = date('Y-m-d');
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i>Exchange rate List</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>


    <!-- Exchange money calculate -->
    <div class="col-xs-4" style="padding: 7px;">
        <label style="float: left; font-size: 19px;">From</label><br>
        <div class="col-xs-9" style="text-align: center;">
            <select id="from" style="width: 132px; margin-left: -28px;">
                <option>Dollar</option>
                <option>Riel</option>
                <option>Dong</option>
                <option>Yuan</option>
            </select>
        </div>
        <label style="float: left; font-size: 19px;">Amount</label>
        <div class="col-xs-9" style="float: left;">
            <input id="m_from" type="text" name="" placeholder="" style="padding: 6px;">
            <input type="hidden" name="" id="txt_date" value="<?=$date;?>">
        </div>

    </div>

    <!-- End exchange money calculate -->
    <!-- Exchange money calculate -->
    <div class="col-xs-4" style="padding: 7px;">

        <label style="float: left; font-size: 19px;">Result</label><br>
        <label style="float: left; font-size: 19px;">To</label>
        <div class="col-xs-9" style="text-align: center;">
            <select id="to" style="width: 132px; margin-left: 15px;">
            </select>
        </div>

        <br><br>


        <div class="col-xs-9" style="float: left; margin-left: 13px; ">
            <input id="result" type="text" name="" placeholder="" style="padding: 6px;">
        </div>

    </div>

    <!-- End exchange money calculate -->


    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date</th>
                        <th>Date Record</th>
                        <th>Exchange From</th>
                        <th>To</th>
                        <th>Rate</th>
                        <th>Period</th>
                        <th>User</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i =1;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_exchange_rate 
                            INNER JOIN tbl_user
                            ON tbl_user.user_id=tbl_exchange_rate.user_id
                            ORDER BY id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            $ex_cur = explode('-', $row->description);
                            echo '<tr>';
                                // no
                                echo '<td>'.($i++).'</td>';
                                // date
                                echo '<td>'.$row->from_date.'</td>';
                                // date record
                                echo '<td>'.$row->date_update.'</td>';
                                // ex_ from
                                echo '<td>'.$ex_cur[0].'</td>';
                                // ex_ to
                                echo '<td>'.$ex_cur[1].'</td>';
                                
                                ?>
                                    <td>
                                        <?php
                                            if($ex_cur[1]=="Riel")
                                            {
                                                echo "KHR ";
                                            }
                                            else if($ex_cur[1]=="Dong")
                                            {
                                                echo "VND ";
                                            }
                                            else if($ex_cur[1]=="Yuan")
                                            {
                                                echo "CNY ";
                                            }
                                            else
                                            {
                                                echo "$ ";
                                            }
                                            echo $row->rate;
                                        ?>
                                    </td>

                                     <td>
                                        <?php
                                            echo $row->from_date." to ".$row->to_date;
                                        ?>
                                    </td>
                                <?php

                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a href="delete.php?del_id='.$row->id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var ex_from = $('#from option:selected').text();
        var ex_to = $('#to option:selected').text();

        var curr = ['<option>Riel</option><option>Dong</option><option>Yuan</option>','<option>Dong</option><option>Yuan</option><option>Dollar</option>','<option>Dollar</option><option>Riel</option><option>Yuan</option>','<option>Riel</option><option>Dollar</option><option>Dong</option>'];

        $('#to').html(curr[0]);

        // Amount keyup
        $('#m_from').keyup(function(){
            // alert(1);
            exchange();
        });

        // select option change
        $('#from').on('change',function(){
            ex_from = $('#from option:selected').text();

            if(ex_from=='Dollar')
            {
                $('#to').html(curr[0]);
            }
            else if(ex_from=='Riel')
            {
                $('#to').html(curr[1]);
            }
            else if(ex_from=='Dong')
            {
                $('#to').html(curr[2]);
            }
            else if(ex_from=='Yuan')
            {
                $('#to').html(curr[3]);
            }
            ex_to = $('#to option:selected').text();
            exchange();
        });

        // select option change
        $('#to').on('change', function(){
            ex_from = $('#from option:selected').text();
            ex_to = $("#to option:selected").text();
            exchange();
        });

        function exchange(){
            var ex_from = $('#from option:selected').text();
            var ex_to = $('#to option:selected').text();
            var money = $('#m_from').val();

            var result;

            var date = $("#txt_date").val();
            // alert(ex_from);
            // alert(ex_to);
            // alert(money);
            // alert(date);
            $.ajax({
                // this use without form
                url:"getRate.php",
                type: "POST",
                //data: {m:money_to.val(), curr:ex_to, date:date},
                data: {m_f:ex_from, m_t:ex_to, amount: money, date:date},
                cache: false,
                // processData: false,
                // contentType: false,
                dataType: 'json',
                success:function(data){
                    if(data.id != "0")
                    {
                        if(ex_from=='Dollar' && ex_to=='Riel')
                        {
                            result=data.id*money;
                        }
                        else if(ex_from=='Riel' && ex_to=='Dollar')
                        {
                            result=money/data.id;
                        }
                        else if(ex_from=='Dollar' && ex_to=='Dong')
                        {
                            result=data.id*money;
                        }
                        else if(ex_from=='Dong' && ex_to=='Dollar')
                        {
                            result=money/data.id;
                        }
                        else if(ex_from=='Dollar' && ex_to=='Yuan')
                        {
                            result=data.id*money;
                        }
                        else if(ex_from=='Yuan' && ex_to=='Dollar')
                        {
                            result=money/data.id;
                        }
                        else if(ex_from=='Riel' && ex_to=='Dong')
                        {
                            result = data.id*money;
                        }
                        else if(ex_from=='Dong' && ex_to=='Riel')
                        {
                            result = money/data.id;
                        }
                        else if(ex_from=='Riel' && ex_to=='Yuan')
                        {
                            result=data.id*money;
                        }
                        else if(ex_from=='Dong' && ex_to=='Yuan')
                        {
                            result=data.id*money;
                        }
                        else if(ex_from=='Yuan' && ex_to=='Dong')
                        {
                            result=money/data.id;
                        }
                        else if(ex_from=='Yuan' && ex_to=='Riel')
                        {
                            result = money/data.id;
                        }
                    }
                    else
                    {
                        result = "Can't exchange";
                    }

                    $('#result').val(result.toFixed(2));
                }
            });
        }

     });
</script>
<?php include_once '../layout/footer.php' ?>
