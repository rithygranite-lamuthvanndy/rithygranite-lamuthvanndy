<?php 
	function clearNull($v_value)
	{
		$strRe="";
		if($v_value==0)
			$strRe="-";
		else
			$strRe=number_format($v_value,2);
		return $strRe;
	}

	function isAlreadyExist($p_result,$p_search)
	{
		$array_tmp=[];
		while ($row=mysqli_fetch_array($p_result)) {
		    if($p_search==$row[1]){
		    	return [
		    			'status'=>true,
		    			'id'=>$row[0]
		    			];
		    	break;
		    }
		    else{
		    	return [
	    			'status'=>false,
	    			'id'=>false
	    			];
		    }
		}
	}
 ?>