	<br>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<img src="img/img_logo/logo.png" alt="">
					<br>
					<br>
					<p class="text-left">
						<strong>© Copyright <?= date('Y') ?><br>
							Rithy Granite (Cambodia)
						</strong>
					</p>
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<p class="text-left" style="margin-bottom: 15px;"> <strong>LOCATION</strong> </p>
					<a href="#">1.ការិយាល័យភ្នំពេញ (Head Office Phnom Penh)</a><br>
					<a href="#">2.រោងចក្ររ៉ែថ្មភ្នំព្រិច (Factory & Mine Granite)</a><br>
					<a href="#">3.រោងចក្ររ៉ែថ្មត្រពាំងស្រែ (Factory Granite)</a><br>
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<p class="text-left" style="margin-bottom: 15px;"> <strong>PRODUCT COMPANY</strong> </p>
					<a href="#">1.អង្គរប្លាសប៉ូលារលោង (Angkor Black Polish)</a><br>
					<a href="#">2.អង្គរប្លាសបាញ់ខ្សាច់គ្រឿម (Angkor Black SandBlast)</a><br>
					<a href="#">3.អង្គរប្លាសប៉ូលា ៥០% យកទៅបូស (Angkor Black Antique)</a><br>
					
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<p class="text-left" style="margin-bottom: 15px;"> <strong>CONNECT WITH US</strong> </p>

					<table width="100%">
						<tr>
							<td><a href="#"><i class="fa fa-facebook"></i></a></td>
							<td><a href="#"><i class="fa fa-linkedin"></i></a></td>
							<td><a href="#"><i class="fa fa-twitter"></i></a></td>
							<td><a href="#"><i class="fa fa-google-plus"></i></a></td>
							<td><a href="#"><i class="fa fa-youtube"></i></a></td>
						</tr>
					</table>
					<span style="color: #eee;"> Visitor History  &nbsp;&nbsp; <a href='https://www.counter12.com'><img src='https://www.counter12.com/img-5Z660075AbYw6wZ0-3.gif' border='0' alt='counter'></a><script type='text/javascript' src='https://www.counter12.com/ad.js?id=5Z660075AbYw6wZ0'></script></span>
					<br>
					<span style="color: #eee;">Online Visitor  &nbsp;&nbsp;&nbsp; </span>

					
				</div>
			</div>
		</div>
	</footer>

	<script type="text/javascript">
		// set submeu click
		$(document).ready(function(){
			$('ul.sub_menu_drop ul.sub_menu > li > a').click(function(){
				$(this).toggleClass("show");
				// return false;
			});
		});

		$("a.left,a.right").click(function(){
			$(".content_items").fadeOut(300);
			$(".content_items").fadeIn(100);
		});
	</script>

	<!-- set menu when scroll out of slider -->
	<script type="text/javascript">
		$(document).ready(function(){
			$(window).scroll(function(){
				$offsetTop = $("header").height();
				if($(this).scrollTop() >= $offsetTop){
					$("header nav").css("background","rgba(20, 61, 8,1)");
				}else{
					$("header nav").css("background",'rgba(20, 61, 8,0.5)');
				}
			});
		});
	</script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>