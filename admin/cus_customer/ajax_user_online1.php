<?php 
	include_once '../../config/database.php';
 ?>
<?php 
	if(@$_GET['action']=='fetch_data'){
	    echo '<ul class="media-list list-items">';
			$v_now=date("Y-m-d H:i:s");
			$time = date("Y-m-d H:i:s", time() - 60);
			$v_sql="SELECT A.*,B.up_name
			FROM tbl_user AS A  
			LEFT JOIN tbl_user_position AS B ON A.user_position=B.up_id
			WHERE last_activity >= '$time' 
			ORDER BY DATE(last_activity) DESC";
			$result=$connect->query($v_sql);
			while ($row_user_online=mysqli_fetch_object($result)) {
	            echo '<li class="media">
                        <div class="media-status">
                            <span style="background-color: #89E818;" class="badge badge-success">Active Now</span>
                        </div>
                        <img class="media-object" src="../../img/img_user/'.$row_user_online->user_photo.'" alt="...">
                        <div class="media-body">
                            <h4 class="media-heading">'.$row_user_online->user_name.'</h4>
                            <div class="media-heading-sub">'.$row_user_online->up_name.'</div>
                        </div>
                    </li>';
			}
			$v_now=date("Y-m-d H:i:s");
			$v_sql="SELECT A.*,B.up_name
			FROM tbl_user AS A  
			LEFT JOIN tbl_user_position AS B ON A.user_position=B.up_id
			WHERE last_activity < '$time' 
			ORDER BY DATE(last_activity) DESC";
			$result=$connect->query($v_sql);
			while ($row_user_offline=mysqli_fetch_object($result)) {
				$date1=$row_user_offline->last_activity;
				$date2=date("Y-m-d H:i:s");
				$diff = abs(strtotime($date2) - strtotime($date1));

				$seconds 	= 	$diff;
				$minutes 	= 	round(abs($diff / 60));
				$hours		=	round(abs($diff / 3600));
				$days		=	round(abs($diff / 86400));
				$weeks		=	round(abs($diff / 604800));
				$months		=	round(abs($diff / 2629440));
				$years		=	round(abs($diff / 31553280));
				
				if($minutes<60){
					$str_status='Active '.$minutes.' minutes ago.';
				}
				else{
					$hours = round($minutes/60);
					if($hours<24){
						$str_status='Active '.$hours.' Hours ago.';
					}
					else{
						$days = round($hours/24);
						if($days<31){
							$str_status='Active '.$days.' days ago.';
						}
						else{
							$month = round($days/30);
							if($month<12){
								$str_status='Active '.$month.' months ago.';
							}
							else{
								$year =round($month/12);
								$str_status='Active '.$year.' years ago.';
							}
						}
					}
				}

	            echo '<li class="media">
                        <div class="media-status">
                            <span class="badge badge-danger">'.$str_status.'</span>
                        </div>
                        <img class="media-object" src="../../img/img_user/'.$row_user_offline->user_photo.'" alt="...">
                        <div class="media-body">
                            <h4 class="media-heading">'.$row_user_offline->user_name.'</h4>
                            <div class="media-heading-sub">'.$row_user_offline->up_name.'</div>
                        </div>
                    </li>';
			}
		echo '</ul>';
		// echo $v_sql;
	}
	else if(@$_GET['action']=='update_user'){
		$v_user_id=$_SESSION['user']->user_id;
		$v_last_ativity=date("Y-m-d H:i:s");
	    $connect->query("UPDATE tbl_user SET last_activity='$v_last_ativity' WHERE user_id='$v_user_id'");
	    // echo $v_user_id;
	}

	if(isset($_GET['is_hide_left_menu'])){
		$v_is_hide_left_menu=($_GET['is_hide_left_menu']?1:0);
		$_SESSION['is_hide_side_bar']=!$v_is_hide_left_menu;
	}
	
 ?>