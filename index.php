
<?php
    session_start();

    if (isset($_SESSION["pk"])){
        header('Location: '. './php/search-dates.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="static/css/index.css">
</head>
<body>
	<section id="login">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-10 col-sm-8 col-md-6 col-xl-4" id="bclogin">
					<div class="row mb-4">
						<h1>Iniciar sesión</h1>
					</div>
					<div class="row">
						<form action="./php/search-dates.php" method="post">
							<div class="mb-4">
						    	<input type="text" class="form-control" placeholder="Usuario" id="username">
						    	<!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
						  	</div>
						  	<div class="mb-4">
						    	<input type="password" class="form-control" placeholder="Contraseña" id="pass">
						  	</div>
						  	<div class="mb-4 form-check">
						    	<input type="checkbox" class="form-check-input" id="keepSession">
						    	<label class="form-check-label" for="keepSessionCheck">Mantener sesión iniciada</label>								
							</div>
						  	<input type="submit" class="btn btn-primary w-100" value="Acceder">

							<input type="hidden" id="patientPK" value=""/>
							<input type="hidden" id="patientName" value=""/>
							<input type="hidden" id="patientLastName" value=""/>

							<div id="errorHelp" class="form-text" style="display:none">Error al Iniciar Sesión</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"integrity="sha256-xH4q8N0pEzrZMaRmd7gQVcTZiFei+HfRTBPJ1OGXC0k=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="static/js/index.js"></script>
</body>
</body>
</html>