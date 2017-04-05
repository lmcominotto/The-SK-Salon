<?php
	include 'includes/header.php';
	include 'dbh.php';
	$title = "Services";

	$sql = "SELECT * FROM services";
	$result = mysqli_query($conn, $sql);
?>

				<div class = "pageHeading">
					<p>SERVICES</p>
				</div>
				
				<div class = "gridContent">

				<?php
					if($result->num_rows > 0) {

						while ($row = mysqli_fetch_array($result)) {
							//check to see if post is image file
							$checkFile = $row['serviceInfo'];
							$extension = pathinfo($checkFile, PATHINFO_EXTENSION);

							//if post is an image
							if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
								echo "<div class = 'gridSubcontent'>
										<img src = 'img/" .$row['serviceInfo']. "'>
								 	  </div>";
							} else { //post is just text
								//if post has no title
								if(empty($row['serviceTitle'])) {
									echo "<div class = 'gridSubcontent'>
											<p>" .nl2br($row['serviceInfo']). "</p>
								 		</div>";
								} else {
									echo "<div class = 'gridSubcontent'>
											<div class = 'gridHeading'>
												" .$row['serviceTitle']. "
											</div>
											<p>" .nl2br($row['serviceInfo']). "</p>
								 		</div>";
								}
							}
						}
					} else {
						echo "No results.<br>";
					}
				?>
					
				</div>

<?php
	include 'includes/footer.php';
?>