<?php
	include 'includes/header.php';
	include 'dbh.php';
	$title = "Photos";

	$sql = "SELECT * FROM photoGallery";
	$result = mysqli_query($conn, $sql);
?>
				<div>
					<ul id = "gallery">
						
						<?php
							if($result->num_rows > 0) {
								while($row = mysqli_fetch_array($result)) {
									echo "<li><img src = 'img/" .$row['galleryImg']. "'></li>";
								}
							} else {
								echo "No results.<br>";
							}
						?>
						
					</ul> 
				</div>
			</div>
		</div>

		<script src = "js/lightbox.js"></script>
		
<?php
	include 'includes/footer.php';
?>