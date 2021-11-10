<?php $active = 3 ?>
<?php $layout_title = "Cambodia Real Estate | Khmer Real Estate | Khmer Property | Cambodia Property | Real Estate in Cambodia | ".$_SERVER['HTTP_HOST']; ?>
<?php include_once('layout/header.php') ?>
<?php 
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = 1;
	}
	$end_limit = 6;
	$start_limit = ($page-1)*$end_limit;
?> 
<?php 
	$sql = "SELECT * FROM tbl_news";
	$query = $connect->query($sql);
	$all_record = mysqli_num_rows($query);
	$allpage = ceil($all_record/$end_limit);
?>
<div class="container mt14 content p28" style="margin-top: -342px;">
	<div class="row m0">
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 p0 pr28">
			<?php 
				$v_now=date("Y-m-d H:i:s");
				$v_get_news = $connect->query("SELECT * FROM tbl_news ORDER BY news_id DESC LIMIT $start_limit,$end_limit");
				while ($row_news = mysqli_fetch_object($v_get_news)) {
					?>
						<section>
							<h4><a style="color: #555;" href="news_detail.php?news_id=<?= $row_news->news_id ?>"><?= $row_news->news_title_en ?></a></h4>
							<div class="ruler"></div>
							<span class="description">Shared publicly - <?= $row_news->news_created_at ?></span><br>
							<?=
								
								$date2=date("Y-m-d H:i:s");
								$diff = abs(strtotime($date2) - strtotime($row_news->news_created_at));

								$minutes = round(abs($diff / 60));
								if($minutes<60){
									$str_status=date("H:i:s",$diff).'Shared publicly : '.$minutes.' minutes ago.';
								}
								else{
									$hours = round($minutes/60);
									if($hours<24){
										$str_status='Shared publicly : '.$hours.' Hours ago.';
									}
									else{
										$days = round($hours/24);
										if($days<31){
											$str_status='Shared publicly : '.$days.' days ago.';
										}
										else{
											$month = round($days/30);
											if($month<12){
												$str_status='Shared publicly : '.$month.' months ago.';
											}
											else{
												$year =round($month/12);
												$str_status='Shared publicly : '.$year.' years ago.';
											}
										}
									}
								}
								echo '<span class="badge badge-danger">'.$str_status.'</span>';
							?>
							<div class="row">
								<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
									<p>
										<?= $row_news->news_description_en ?>
										<a href="news_detail.php?news_id=<?= $row_news->news_id ?>" style="color: #fdb913;">...មើលច្រើនទៀត</a>
									</p>
								</div>
								<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
									<a href="news_detail.php?news_id=<?= $row_news->news_id ?>" style="color: #fdb913;"><img src="img/img_news/<?= $row_news->news_image ?>" class="img-responsive" alt="Image"></a>
								</div>
							</div>
						</section><br>		
					<?php
				}
			 ?>
			

			<!-- pagination -->
			<div class="text-center">
				<ul class="pagination" style="padding: 0; margin: 0; margin-top: 5px;">		
					<?php
						if($page>1){
							$prev = $page - 1;
							echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page=1"><i class="fa fa-step-backward"></i></a></li>';
							echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'"><i class="fa fa-angle-double-left"></i></a></li>';
						}else{
							$prev = $page - 1;
							echo '<li class="disabled"><a href="#"><i class="fa fa-step-backward"></i></a></li>';
							echo '<li class="disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>';
						}
						$rank = 3;
						for ($i=$page-$rank; $i <= $page+$rank; $i++) { 
							if($i >= 1 && $i <= $allpage ){
								if($page == $i){
									echo '<li class="active"><a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a></li>';
								}
							}
						}
						if($page<$allpage){
							$next = $page + 1;
							echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$next.'"><i class="fa fa-angle-double-right"></i></a></li>';
							echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$allpage.'"><i class="fa fa-step-forward"></i></a></li>';
						}else{
							$next = $page + 1;
							echo '<li class="disabled"><a href="#"><i class="fa fa-angle-double-right"></i></a></li>';
							echo '<li class="disabled"><a href="#"><i class="fa fa-step-forward"></i></a></li>';
						}
					?>
				</ul>
			</div>
			<!-- end pagination -->

		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p0">
			<section>
				<div class="bg-blue">
					<h4>
						LATEST NEWS
					</h4>
				</div>
				<div class="ruler"></div>
				
				<?php 
					$v_get_news1 = $connect->query("SELECT * FROM tbl_news ORDER BY news_id DESC");
					while ($row_news1 = mysqli_fetch_object($v_get_news1)) {
						echo '<p style="text-indent: 0px; text-align: left; word-break: break-all; hyphens: auto;">';
							echo '<a style="color: #666" href="news_detail.php?news_id='.$row_news1->news_id.'"><strong>'.$row_news1->news_title_en.'</strong> </a>';
						echo '</p>';
						echo '<div class="ruler" style="height: 1px;"></div>';
					}
				?>
			</section><br>
		</div>
	</div>
</div>
<?php include_once('layout/footer.php') ?>