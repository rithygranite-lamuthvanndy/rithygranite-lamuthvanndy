<?php 
	function summaryMaterial($p_cat_id,$p_arr){
        $v_price_beg=0;
        $v_price_in=0;
        $v_price_out=0;
        $v_price_adjust=0;
        $v_price_end=0;
        foreach ($p_arr as $value1) {
            if(@$value1[$p_cat_id]==$p_cat_id){ 
                $obj=json_decode(json_encode($value1));
                $v_price_beg+=$obj->price_beg;
                $v_price_in+=$obj->price_in;
                $v_price_out+=$obj->price_out;
                $v_price_adjust+=$obj->price_adjust;
                $v_price_end+=$obj->price_end;
            }

        }
        return [
            't_price_beg'=>$v_price_beg,
            't_price_in'=>$v_price_in,
            't_price_out'=>$v_price_out,
            't_price_adjust'=>$v_price_adjust,
            't_price_end'=>$v_price_end
        ];
    }

    function myCalCostAverage($arg_arr)
    {
        $result=0;
        $result=
        ($arg_arr['begining_bal_price']+$arg_arr['current_in_price'])/
        MAX(($arg_arr['begining_bal_qty']+$arg_arr['current_in_qty']),1);
        return round($result,2);
    }
 ?>