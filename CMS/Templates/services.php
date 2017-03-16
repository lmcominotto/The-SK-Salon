<?php 
$title = "Services";
include 'include/header.php'; 
include 'dbh.php';?>
					
	<div class = "pageHeading">
		<p>SERVICES</p>
	</div>
					
	<div class = "productsContent">
	
		<!--Creating variable to store query and then running query-->
		<!-- While loop creates alternating rows of picture/text -->
		<?php
			$sql = "SELECT * FROM services";
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
				<img src= "
					<?php echo $row->Image; ?>
				">
			</div>
									
			<div id = "productsTwo">  
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
				<img src= "
					<?php echo $row->Image; ?>
				">
			</div>
			
			<?php
					}
					$i += 1;
				}
			}
			?>
		</div>
					
<?php include 'include/footer.php'; ?>