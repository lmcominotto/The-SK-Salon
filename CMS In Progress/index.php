<?php
	include 'includes/header.php';
	include 'dbh.php';
	$title = "The SK Salon";

	$sql_One = "SELECT * FROM carousel";
	$result_One = mysqli_query($conn, $sql_One);

	$sql_Two = "SELECT * FROM homePage";
	$result_Two = mysqli_query($conn, $sql_Two);

	$sql_Three = "SELECT * FROM contactHome";
	$result_Three = mysqli_query($conn, $sql_Three);	

	$count = mysqli_num_rows($result_One);

	$slides = '';
	$indicators = '';
	$cntr = 0;
?>

				<div id="myCarousel" class="carousel" data-ride="carousel">
					<?php
						if($count > 0) {
							while ($row = mysqli_fetch_array($result_One)) {
								
								$image = $row['carouselImg'];
								
								if ($cntr == 0) {
									$indicators .= "<li data-target = '#myCarousel' data-slide-to='" .$cntr. "'class = 'active'></li>";
									
									$slides .= "<div class = 'item active'>
													<img src = 'img/" .$image. "'>
												</div>";
								} else {
									$indicators .= "<li data-target='#myCarousel' data-slide-to='" .$cntr. "'></li>";
									
									$slides .= "<div class = 'item'>
													<img src = 'img/" .$image. "'>
												</div>";
								}

								$cntr++;
							}
						} else {
							echo "No results.<br>";
						}
					?>
					<!-- indicators -->
					<ol class="carousel-indicators">
						<?php echo $indicators; ?>
					</ol>

					<!-- wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<?php echo $slides; ?>
					</div>

					<!-- controls -->
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<!-- Left and right controls -->
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
				
				<!-- main text -->
				<div class = "main">
					<?php
						
						if($result_Two->num_rows > 0) {

							while ($row = mysqli_fetch_array($result_Two)) {
								echo nl2br($row['mainInfo']);
							}
						} else {
							echo "No results.<br>";
						}
					?>
				</div>
				
				<!--contact information-->
				<div class = "boxes">
					<?php
						$cnt = 1;
						if($result_Three->num_rows > 0) {

							while ($row = mysqli_fetch_array($result_Three)) {
								if ($cnt == 1) {
									echo "<div class = 'singleBox'>
											<div class = 'boxTitle'>
												<img class = 'iconStyle' src = 'img/" .$row['contactLogo']. "'><br><br>
												" .$row['contactTitle']. "<br>
											</div>
											<div class = 'boxStyle'>
												" .nl2br($row['contactInfo']). " <br><br>
												<a href = 'https://www.facebook.com/thesksalon/'>
													<img src = 'img/facebook-logo.png' height = '25'/>
												</a>
												<a href = 'https://www.instagram.com/sandee318/'>
													<img src = 'img/instagram-logo.png' height = '25'/>
												</a>
											</div>
										 </div>";

								} else {
									echo "<div class = 'singleBox'>
											<div class = 'boxTitle'>
												<img class = 'iconStyle' src = 'img/" .$row['contactLogo']. "'><br><br>
												" .$row['contactTitle']. "<br>
											</div>
											<div class = 'boxStyle'>
												" .nl2br($row['contactInfo']). "
											</div>
										 </div>";
								}
								
								$cnt++;
							}
						} else {
							echo "No results.<br>";
						}
					?>
				</div>
			</div>
		</div>
		
<?php
	include 'includes/footer.php';
?>