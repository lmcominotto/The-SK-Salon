<?php include 'Include/header.php'; ?>
					
					<div class = "pageHeading">
						<p>CONTACT US</p>
					</div>
					
					<div id = "map">
						The SK Salon<br>
						1117 US Highway 72 East<br>
						Athens, AL 35611<br>
						256-800-1088<br><br>
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3276.8287231397726!2d-86.95209868541805!3d34.78508688041286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88628b067d0b969f%3A0x1948d096ac865d1c!2s
						1117+US+Hwy+72+E%2C+Athens%2C+AL+35611!5e0!3m2!1sen!2sus!4v1487990507115" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
					
					<div id = "contactArea">
						<p id = "contactMsg">
							To schedule an appointment, please go <a href = "https://www.vagaro.com/thesksalonatnewbeginnings/about"><b>HERE</b></a>.<br>
							For questions or comments, please fill out the form below.<br>
							We will get back to you shortly!<br>
							<b>*All fields are required!</b>
						</p>
						
						<form action = "contact_form.php" method = "post">
						
							<label for = "Name">Name</label><br>
							<input type = "text" name = "Name" id = "Name" required/><br>
				
							<label for ="Email">Email</label><br>
							<input type = "text" name = "Email" id = "Email" required/><br>
							
							<label for = "Subject">Subject</label><br>
							<input type = "text" name = "Subject" id = "Subject" required"/><br>
							
							<label for = "Message">Message</label><br>
							<textarea name = "Message" rows = "5" cols="10" id = "Message" required></textarea><br>

							<input type = "submit" name = "submit" value = "Submit" class = "submit-button"/>
						</form>
					</div>
					
<?php include 'Include/footer.php'; ?>