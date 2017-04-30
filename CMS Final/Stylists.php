<?php
	include 'includes/header.php';
	include 'dbh.php';
	$title = "Stylists";

	$sql = "SELECT * FROM stylists";
	$result = mysqli_query($conn, $sql);

	$count = 1;
?>
				<div class = "pageHeading">
					<p>STYLISTS</p>
				</div>
				
				<div class = "gridContent">
				<?php
					if($result->num_rows > 0) {

						while ($row = mysqli_fetch_array($result)) {
							//image post first, then text
							if($count %2 == 1)
							{
								echo "<div class = 'gridSubcontent'>
										<img src = 'img/" .$row['stylistImg']. "'>
									 </div>";
							
								echo "<div class = 'gridSubcontent'>
										<div class = 'gridHeading'>
											" .$row['stylistTitle']. "
										</div>
										<p>" .nl2br($row['stylistInfo']). "</p>
									 </div>";

								$count++;
							}
							//text post first, then image
							else if ($count %2 == 0) {
								echo "<div class = 'gridSubcontent'>
										<div class = 'gridHeading'>
											" .$row['stylistTitle']. "
										</div>
										<p>" .nl2br($row['stylistInfo']). "</p>
									 </div>";

								echo "<div class = 'gridSubcontent'>
										<img src = 'img/" .$row['stylistImg']. "'>
									 </div>";
								
								$count++;
							}
						}

					} else {
						echo "0 results.";
					}
				?>
				</div>
			</div>
		</div>
		
<?php
	include 'includes/footer.php';
?>