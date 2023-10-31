<?php 
	function cal_mater_cub($v_length,$v_width,$v_height)
	{
		return $v_length*$v_width*$v_height;
	}
	function cal_mater($v_length,$v_width,$v_pc)
	{
		return $v_length*$v_width*$v_pc;
	}
	function sum_salary($v_salary,$v_dwork,$v_inde,$v_adeduct,$v_reduce)
	{
		return ($v_salary/30)*$v_dwork+$v_inde+$v_adeduct+$v_reduce;
	}
 ?>