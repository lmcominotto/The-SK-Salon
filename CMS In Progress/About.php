<?php
	include 'includes/header.php';
	$title = "About";

	$sql = "SELECT * FROM aboutSK";
	$result = mysqli_query($conn, $sql);
?>
	
				<div class = "pageHeading">
					<p>ABOUT</p>
				</div>

				<div class = "gridContent">

				<?php
					if($result->num_rows > 0) {

						while ($row = mysqli_fetch_array($result)) {
							//check to see if post is image file
							$checkFile = $row['postInfo'];
							$extension = pathinfo($checkFile, PATHINFO_EXTENSION);

							//if post is an image
							if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
								echo "<div class = 'gridSubcontent'>
										<img src = 'img/" .$row['postInfo']. "'>
								 	  </div>";
							} else { //post is just text
								//if post has no title
								if(empty($row['postTitle'])) {
									echo "<div class = 'gridSubcontent'>
											<p>" .nl2br($row['postInfo']). "</p>
								 		</div>";
								} else {
									echo "<div class = 'gridSubcontent'>
											<div class = 'gridHeading'>
												" .$row['postTitle']. "
											</div>
											<p>" .nl2br($row['postInfo']). "</p>
								 		</div>";
								}
							}
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