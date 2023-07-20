<?php
session_start();
if (!isset($_SESSION["pk"])) {
	header('Location: ' . '../index.php');
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Buscador de Citas</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
		integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../static/css/search-dates.css">
</head>


<body class="position-relative" data-pk="<?php echo $_SESSION["pk"]; ?>">

	<?php
	$specialtyUrl = "http://192.168.200.143:8000/management/get-specialties-clinic-api/?api_key=Sistemas2005$&clinic=1152";
	$jsonSpecialty = file_get_contents($specialtyUrl);
	$responseSpecialty = json_decode($jsonSpecialty);

	//$doctorUrl = "http://192.168.200.143:8000/doctor/get-doctor-specialty-api/?specialtyName={$responseSpecialty->specialties[0]->name}";
	
	$postdata = http_build_query(
		array(
			'api_key' => 'Sistemas2005$',
		)
	);


	// $opts = array(
	// 	'http' =>
	// 	array(
	// 		'method' => 'POST',
	// 		'header' => 'Content-Type: application/x-www-form-urlencoded',
	// 		'content' => $postdata
	// 	)
	// );
	// $contextDoctor = stream_context_create($opts);
	// $jsonDoctor = file_get_contents($doctorUrl, false, $contextDoctor);
	// $responseDoctor = json_decode($jsonDoctor);
	
	?>
	<div id="background-container">
		<section id="close-session" class="pt-3">
			<div class="container w-75">
				<div class="row responsive-col">
					<div class="col-sm-8 col-12 col-md-8 col-lg-8 justify-content-around text-center responsiveText">
						<h4 id="name-patient" class="mr-auto p-2">
							<?php echo "Bienvenido/a, " . $_SESSION['patientName'] . " " . $_SESSION['patientLastName'] ?>
						</h4>
					</div>
					<div
						class="col-sm-3 col-12 col-md-3 col-lg-4 d-flex justify-content-center justify-content-end h-25 responsiveIcons">
						<a href="patient-dates.php" class="btn btn-primary btnSize m-1">
							<i class="fa-regular fa-calendar"></i>
						</a>
						<a id="btn-close-sesion" href="#" class="btn btn-danger btnSize  m-1">
							<i class="fa-solid fa-right-from-bracket"></i>
						</a>
					</div>
				</div>
			</div>
		</section>
		<hr class="mt-0">
		<section id="form-dates">
			<div class="container">
				<div class="row">
					<h1 class="mb-0 mb-1">Buscador de citas</h1>
				</div>
				<div class="row justify-content-center">
					<div class="col-12">
						<form>

							<div class="row selection  justify-content-center">
								<div class=" col-10 ms-2 col-sm-6 col-lg-3 ">
									<div class="row text-center mb-1 ">
										<label for="dateType">Tipo de cita:</label>
									</div>
									<div class="row">
										<select id="dateType" class="form-select">
											<option disabled selected> Elige un Tipo de Cita</option>
											<option id="0">Aseguradora</option>
											<option id="2">Privado</option>
											<option id="3">Revisión</option>
											<option id="4">Telefónica</option>
										</select>
									</div>
								</div>
								<div class=" col-10 ms-2 col-sm-6 col-lg-3">
									<div class="row text-center mb-1">
										<label for="specialty">Especialidad</label>
									</div>
									<div class="row">
										<select id="specialty" class="form-select">
											<option disabled selected> Elige una especialidad</option>
											<?php
											foreach ($responseSpecialty->specialties as $specialty) {
												echo "<option id='{$specialty->pk}'>" . $specialty->name . "</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class=" col-10 ms-2 col-sm-6 col-lg-3">
									<div class="row text-center mb-1">
										<label for="doctor">Médicos</label>
									</div>
									<div class="row">
										<select id="doctor" class="form-select">
											<option disabled selected> Elige un Doctor</option>
										</select>
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</section>

		<section id="dates">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-lg-5 me-0 me-lg-4 " id="calendar">
						<div class="row" id="header-calendar">
							<div id="header-title-calendar">

							</div>
							<div>
								<a href="#" class="btn btn-sm btn-primary me-2" id="previousMonth"><i
										class="fa-solid fa-chevron-left"></i></a>
								<a href="#" class="btn btn-sm btn-primary" id="nextMonth"><i
										class="fa-solid fa-chevron-right"></i></a>
							</div>
						</div>
						<div class="row" id="calendar-table">

						</div>
					</div>
					<div class="col-12 col-lg-6 mt-4 mt-lg-0" id="hours">
						<div class="row justify-content-between" id="header-hours">
							<div class="d-flex align-items-center">
								<span><b>HORAS DISPONIBLES</b></span>
							</div>
							<div>
								<a href="#" class="btn btn-sm btn-primary me-2">?</a>
							</div>
						</div>
						<div class="row" id="hour-list">
							<div class="col-12">
								<div class="row pt-1">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<!--modal reguistrar nueva cita-->
	<div class="modal chooseDate " tabindex="-1" id="modal-test">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Ajustes de la cita</h5>
					<button type="button" class="btn-close cerrarModalClientes" data-bs-dismiss="modal"
						aria-label="Close"></button>
				</div>
				<div class="modal-body dataTotalDate">
					<p class="nameOfPaitent">
						<?php echo $_SESSION["patientName"] . " " . $_SESSION["patientLastName"]; ?>
					</p>
					<hr class="mb-4">
					<div class="contentDataDate">
						<p><span><b>Fecha: </b></span><span class="dataOfDate"> </span><span><b> Hora: </b></span><span
								class="dataOfHour"></span></p>
						<p><span><b>Tipo de cita: </b></span><span class="tipeOfDate"></span></p>
						<p><span><b>Especialidad: </b></span><span class="speciatyOfDate"></span></p>
						<p><span><b>Doctor/a: </b></span><span class="doctorOfDate"></span></p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary saveDate btnSize" id="button">
						<i class="fa-solid fa-check"></i>
					</button>
				</div>
			</div>
		</div>
	</div>



	<!-- alerta para confirmar la cita reservada -->
	<!-- <div class="container alert show alert-success alert-dismissible shadow-lg fade col-10 col-sm-9 col-lg-6"
		id="success-alert" style="display: none;">
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		<div class="m-lg-3">
			<h6> <strong>Bien hecho!</strong></h6>
			<h7>Su cita ha sido reservada correctamente</h7>
		</div>
	</!-->


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.7.0.js"
		integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="../static/js/search-dates.js"></script>
</body>

</html>