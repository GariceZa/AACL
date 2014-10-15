<!DOCTYPE public>
<html>
<head>
	<!--Web browser tab title-->
	<title>About Animals</title>
	<!--Getting web styling from css file -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mycss.css">
</head>
<body>
	<!--Creates a border around entire web page-->
	<div class="container">
		<!--Bootstrap feature-->		
		<div class="jumbotron">
				<img src="images/aacl.png" alt="" class="pic image-responsive" align="left">
				<h1>Animal Anti-Cruelty League</h1>
				<h5>Est. 1956</h5>								
		</div>
		<!--Navigation bar across the top of the webpage-->
			<div class="row">
				<div class="col-md-12"> 
					<ul class="nav nav-tabs" data-tabs="tabs" >
			  			<li><a href="home.php">Home</a></li>		  			
				  		<li class="active" data-toggle="tab"><a href="animals.php">Animals</a></li>
				  		<li><a href="qrcode.php">QR Codes</a></li>
				  		<li><a href="users.php">Users</a></li>
				  		<li><a href="inspectors.php">Inspectors</a></li>
				  		<li><a href="reportsd.php">Reports</a></li>

					</ul> 
				</div> 					
			</div>

			<div class="row">				
				<div class="col-xs-12 col-md-12">
					<h2>Adoption Form</h2>					
				</div>				
			</div>
			
			<div class="row">				
				<div class="col-xs-7 col-md-2">
					<p class="labels" title="Potential Owner's First Name">Adopter Name:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					<input type="text" name="adptName" id="adptName" title="Potential Owner's First Name"/>
				</div>				
				<div class="col-xs-7 col-md-2">
					<p class="labels" title="Potential Owner's Last Name">Adopter Surname:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					<input type="text" name="adptSname" id="adptSname" title="Potential Owner's Last Name"/>
				</div>				
				
			</div>

			<div class="row">							
				<div class="col-xs-7 col-md-2">
					</br><p class="labels" title="13 digits">Adopter's ID Number:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					</br><input type="text" name="adptrid" id="adptrid" title="13 digits"/>
				</div>	
				<div class="col-xs-7 col-md-2">
					</br><p class="labels" title="Date adoption initiated">Adoption Date:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					</br><input type="date" name="adptdate" id="adptdate" title="Date adoption initiated"/>
				</div>											
			</div>		

			<div class="row">
				<div class="col-xs-7 col-md-2">
					</br><p class="labels" title="Home contact number">Telephone:</p>
				</div>	
				<div class="col-xs-3 col-md-3">
					</br><input type="text" name="telnum" id="telnum" title="Home contact number"/>
				</div>	
				<div class="col-xs-7 col-md-2">
					</br><p class="labels" title="Cellphone number">Mobile:</p>
				</div>	
				<div class="col-xs-3 col-md-2">
					</br><input type="text" name="cellnum" id="cellnum" title="Cellphone number"/>
				</div>
			</div>		

			<div class="row">			
				<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Potential owner's email details">Email:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					</br><input type="text" name="email" id="email" title="Potential owner's email details"/>
				</div>
				<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Potential owner's work contact details">Work Number:</p>
					</div>	
					<div class="col-xs-3 col-md-3">
						</br><input type="text" name="worknum" id="worknum" title="Potential owner's work contact details"/>
					</div>
			</div>

			<div class="row">				
				<div class="col-xs-5 col-md-2">
					</br><p class="labels" title="Potential owner's place of residence">Address:</p>
				</div>	
				<div class="col-xs-5 col-md-3">
						</br><textarea rows="5" cols="30" name="Addr" title="Potential owner's place of residence"> </textarea>
				</div>
				<div class="col-xs-2 col-md-1">
					</br><button  onclick ="window.location.href='inspection.php'" class="btn btn-primary center" type="submit" title="Property inspection form">Inspections</button>
				</div>												
			</div>	
			<div class="row">
				<div class="col-md-12">
				</div>
			</div>
	</div>
	<!-- Scripts -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>