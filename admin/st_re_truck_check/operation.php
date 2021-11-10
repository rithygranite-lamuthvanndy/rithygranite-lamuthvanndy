<?php 
    include_once '../../config/database.php';
?>
<?php
    function myCalCostAverage($arg_arr)
    {
        $result = 0;
        $result = ($arg_arr['begining_bal_price'] + $arg_arr['current_in_price']) /
            MAX(($arg_arr['begining_bal_qty'] + $arg_arr['current_in_qty']), 1);
        return round($result, 2);
    }
    function summaryMaterial($p_cat_id, $p_arr)
    {
        $v_price_beg = 0;
        $v_price_in = 0;
        $v_price_out = 0;
        $v_price_adjust = 0;
        $v_price_end = 0;
        foreach ($p_arr as $value1) {
            if (@$value1[$p_cat_id] == $p_cat_id) {
                $obj = json_decode(json_encode($value1));
                $v_price_beg += $obj->price_beg;
                $v_price_in += $obj->price_in;
                $v_price_out += $obj->price_out;
                $v_price_adjust += $obj->price_adjust;
                $v_price_end += $obj->price_end;
            }
        }
        return [
            't_price_beg' => $v_price_beg,
            't_price_in' => $v_price_in,
            't_price_out' => $v_price_out,
            't_price_adjust' => $v_price_adjust,
            't_price_end' => $v_price_end
        ];
    }

    // For Report History of Track
    function getCostPerProductName($p_date,$p_pro_id,$p_status)
    {
        global $connect;
        $v_date_start=date('Y-m-01',strtotime($p_date));
        $v_date_end=date('Y-m-d',strtotime($p_date));
        $v_sql = "SELECT 
                    (
                        (
                            SELECT IFNULL(SUM(in_qty),0)
                            FROM tbl_st_stock_in AS AA 
                            LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                            WHERE AA.stsin_date_in<'{$v_date_start}'
                            AND BB.pro_id=A.stpron_id
                        )-
                        (
                            SELECT IFNULL(SUM(out_qty),0)
                            FROM tbl_st_stock_out AS AA 
                            LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                            WHERE AA.stsout_date_out<'{$v_date_start}'
                            AND BB.pro_id=A.stpron_id
                        )+
                        (
                            SELECT IFNULL(SUM(qty_adjust),0)
                            FROM tbl_st_stock_adjustment AS AA 
                            LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                            WHERE  AA.stsadj_date_record <'{$v_date_start}'
                            AND BB.pro_id=A.stpron_id
                        )
                    ) AS begining_bal_qty,
                    (
                        (
                            SELECT SUM(
                                        (IFNULL(in_qty,0)*in_price_vn/stsin_exchange_rate)
                                            +(in_price_dollar*IFNULL(in_qty,0))
                                        )
                            FROM tbl_st_stock_in AS AA 
                            LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                            WHERE AA.stsin_date_in<'{$v_date_start}'
                            AND BB.pro_id=A.stpron_id
                        )
                    ) AS begining_bal_price,
                    (
                        SELECT CONCAT(
                                    SUM(in_qty),
                                    '=',
                                    SUM((in_price_vn/stsin_exchange_rate)+in_price_dollar)*IFNULL(SUM(in_qty),0)
                                )
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id
                    ) current_in
                    FROM tbl_st_product_name AS A 
                    WHERE A.stpron_material_type='$p_status'
                    AND A.stpron_id='$p_pro_id'
                    ";
       //echo $v_sql."<br>";
        $row=mysqli_fetch_object($connect->query($v_sql));
        if( !empty($row)) {
        $v_begining_bal_qty = ($row->begining_bal_qty ?: 0);
       // echo $v_begining_bal_qty."<br>";
       
        $v_begining_bal_price = round(($row->begining_bal_price ?: 0), 2);

        $v_arr_in = explode("=", $row->current_in);
        $v_current_in_qty = (@$v_arr_in[0] ?: 0);
        $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);
        $v_array = [
            'begining_bal_price' => $v_begining_bal_price,
            'begining_bal_qty' => $v_begining_bal_qty,
            'current_in_price' => $v_current_in_price,
            'current_in_qty' => $v_current_in_qty
        ];

        $result_cost = myCalCostAverage($v_array);
        return $result_cost;
    }
   }
?>