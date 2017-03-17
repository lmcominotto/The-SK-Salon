<?php 
$title = "Photo Gallery";
include 'include/header.php'; 
include 'dbh.php';?>
				
	<div>
		<ul id = "gallery">
			<?php
				$sql = "SELECT * FROM photos";
				$result = mysqli_query($conn, $sql);
				$count = $result->num_rows;
							
				if ($count !=0)
			{
				while($row = $result->fetch_object()){ ?>
						<li><img src = "<?php echo $row->Image; ?>"></li>
			<?php
				}
			}
			?>
				<!--		<li><img src = "img/img2.jpg"></li>
						<li><img src = "img/img3.jpeg"></li>
						<li><img src = "img/img4.jpg"></li>
						<li><img src = "img/img5.jpeg"></li>
						<li><img src = "img/img6.jpeg"></li>
						<li><img src = "img/img7.jpg"></li>
						<li><img src = "img/img8.jpeg"></li>
						<li><img src = "img/img9.jpg"></li>
						<li><img src = "img/img10.jpeg"></li>
						<li><img src = "img/img11.jpeg"></li>
						<li><img src = "img/img12.jpeg"></li>
						<li><img src = "img/img13.jpeg"></li>
						<li><img src = "img/img14.jpeg"></li>
						<li><img src = "img/img15.jpg"></li>
						<li><img src = "img/img16.jpg"></li>-->
					</ul> 
				</div>
				
				<script src = "lightbox.js"></script>
				
<?php include 'include/footer.php'; ?>