<?php 
$title = "About Us";
include 'include/header.php';
include 'dbh.php';?>
					
	<div class = "pageHeading">
			<p>ABOUT</p>
	</div>
		
	<div class = "productsContent">
					
		<!--Creating variable to store query and then running query-->
		<!-- While loop creates alternating rows of picture/text -->
		<?php
			$sql = "SELECT * FROM about";
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
			<!--grabbing image stored in database-->
			<img src= "
				<?php echo $row->Image; ?>
			">
		</div>
								
		<div id = "productsTwo">  
			<div id = "heading">
			<!--Grabbing title and text from database-->
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
		<!--grabbing next title and text from database-->
				<?php echo $row->Title; ?>
		</div>
			<p>
				<?php echo $row->Text; ?>.
			</p>
		</div>
		
		<div id = "productsFour"> 
			<!--grabbing image from database-->
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