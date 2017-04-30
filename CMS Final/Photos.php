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
								$i = 0;
								while($row = mysqli_fetch_array($result)) {
									echo "<li><img src = 'img/" .$row['galleryImg']. "' num='".$i."'></li>";
									$i += 1;
								}
								echo ("<script>max = ".($i - 1).";</script>");
							} else {
								echo "No results.<br>";
							}
						?>
						
					</ul> 
				</div>
			</div>
		</div>

		<script>
			$num = 0;
		
			$(document).ready(function() {
				$("img").click(function() {
					$src = $(this).attr("src");
					$num = $(this).attr("num");
					
					if (!$("#lightbox").length > 0) {
						
						$("body").append("<div id='lightbox'><div id='close'><button>CLOSE</button></div><img src=''><div id='previous'><button>Previous</button></div><div id='next'><button>Next</button></div></div>");
						$("#lightbox").show();
						$("#lightbox img").attr("src", $src);
					
						$("#previous").click(function() {
							$num--;
							if ($num < 0)
							{
								$num = max;
							}
							setImageToNumber($num);
						});
						
						$("#next").click(function() {
							$num++;
							if ($num > max)
							{
								$num = 0;
							}
							setImageToNumber($num);
						});
						
					} 
					else {
						$("#lightbox").show();
						$("#lightbox img").attr("src", $src);
					}
					
					});
					
				
				
				$("body").on("click", "#close", function() {
					$("#lightbox").hide();
				});
			});
			
			function setImageToNumber(number)
			{
				var allTags = document.getElementsByTagName("img");
				$src="";
				for (var x = 0; x < allTags.length; x++)
				{
					if (allTags[x].getAttribute("num") != null)
					{
						if (allTags[x].getAttribute("num") == number)
						{
							$src = allTags[x].src;
						}
					}
				}
				
				$("#lightbox").show();
				$("#lightbox img").attr("src", $src);
			}
		</script>
		
<?php
	include 'includes/footer.php';
?>