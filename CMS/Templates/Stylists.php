<?php 
$title = "Stylists";
include 'Include/header.php'; 
include 'dbh.php';?>

	<div class = "pageHeading">
		<p>STYLISTS</p>
	</div>
	
	<div class = "productsContent">
	
	<!--Creating variable to store query and then running query-->
	<?php
	$sql = "SELECT * FROM stylists";
	$result = mysqli_query($conn, $sql);
	$count = $result->num_rows;
	$i = 0;
	
	if ($count !=0)
	{
		while($row = $result->fetch_object()){
			if($i %2 == 0)
			{
			
			
	?>
	<div id = "productsOne">
		<img src="img/skranz.jpg" alt = "Sandee Kranz">
	</div>
	
	<div id = "productsTwo">  <!-- Filler Text -->
		<div id = "heading">
			<?php echo $row->Title; ?>
		</div>
		<p>
			<?php echo $row->Text; ?>
			
		</p>
	</div>
		
		<?php
			}
			
			else {
		?>
		
	<div id = "productsThree">
		<div id = "heading">
			<?php echo $row->Title; ?>
		</div>
		<p>
			<?php echo $row->Text; ?>.
		</p>
	</div>
	
	<div id = "productsFour">
		<img src = "img/skranz.jpg">
	</div>
	
	<?php
			}
			$i += 1;
		}
	}
	?>			
	
	</div>					
<?php include 'Include/footer.php'; ?>
