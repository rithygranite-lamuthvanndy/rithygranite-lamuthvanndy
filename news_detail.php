<?php 
	$active = 3; 
    include_once 'config/database.php';
?>
<?php 
	$news_id = @$_GET['news_id']; 
	@$get_news_detail = @$connect->query("SELECT * FROM tbl_news WHERE news_id='$news_id'");
	$row_news_detail = mysqli_fetch_object($get_news_detail);
?>
<?php 
	$layout_title = @$row_news_detail->news_title_en;
	include_once('layout/header.php'); 
?> 
<div class="container mt14 content p28" style="margin-top: -342px;">
	<div class="row m0">
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 p0 pr28">
			<section class="text_slider_detail">
				<h4 style="text-transform: uppercase;"> <?= $layout_title ?> </h4>
				<div class="ruler"></div>
				<?= @$row_news_detail->news_detail_en ?>
			</section>
			<img src="img/img_news/<?=$row_news_detail->news_image?>"class="img-responsive" alt="Image">
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p0">
			<section>
				<h4>
					LATEST NEWS
				</h4>
				<div class="ruler"></div>
				
				<?php 
					$v_get_news1 = $connect->query("SELECT * FROM tbl_news WHERE news_id !='$news_id' ORDER BY news_id DESC");
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