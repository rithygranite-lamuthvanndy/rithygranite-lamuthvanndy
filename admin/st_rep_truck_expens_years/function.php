<?php

   function spar_part_repare_by_year(){

     global $connect;
   }
    function getSummaryHistoyofTrack($p_track_id)
    {
        global $connect;
        $arr_tmp = [];
        $v_total_sumary = 0;
        $obj_json = null;
        $v_sql_detail = "SELECT 
                        A.stsout_date_out,B.pro_id,
                        DATE_FORMAT(A.stsout_date_out,'%Y') AS group_year,
                        B.out_qty
                        FROM tbl_st_stock_out AS A 
                        LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                        LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                        LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                        WHERE A.stock_status=3
                        AND B.track_mac_id='$p_track_id'
                        GROUP BY B.std_id,YEAR(A.stsout_date_out)
                        ORDER BY A.stsout_date_out";
        $v_result = $connect->query($v_sql_detail);
        while ($row = mysqli_fetch_object($v_result)) {
            $amo = getCostPerProductName($row->stsout_date_out, $row->pro_id, 3) * $row->out_qty;
            @$arr_tmp[$row->group_year] += $amo;
            $v_total_sumary += $amo;
        }
        @$obj_json->year = $arr_tmp;
        @$obj_json->sumary = $v_total_sumary;
        return json_encode($obj_json);
    }
    function getSummaryHistoyofTrackMonthly($p_track_id, $p_month_year,$p_type=3)
    {
        global $connect;
        $v_total_sumary = 0;
        $obj_json = null;
        $v_sql_detail = "SELECT 
                        A.stsout_date_out,B.pro_id,
                        DATE_FORMAT(A.stsout_date_out,'%Y-%m') AS group_month_year,
                        B.out_qty
                        FROM tbl_st_stock_out AS A 
                        LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                        LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                        LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                        WHERE A.stock_status='$p_type'
                        AND B.track_mac_id='$p_track_id'
                        AND DATE_FORMAT(A.stsout_date_out,'%Y-%m')='$p_month_year'
                        GROUP BY B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out),B.pro_id
                        ORDER BY A.stsout_date_out";
        // echo $v_sql_detail. '<br><br>';
        $v_result = $connect->query($v_sql_detail);
        while ($row = mysqli_fetch_object($v_result)) {
            // echo $row->pro_id.'===';
            $amo = getCostPerProductName($row->stsout_date_out, $row->pro_id, $p_type);
            $v_total_sumary += $amo;
        }
        @$obj_json->sumary = $v_total_sumary;
        return json_encode($obj_json);
    }
?>