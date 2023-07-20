<?php
session_start();
if (!isset($_SESSION["pk"])) {
	header('Location: ' . '../index.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Citas Paciente</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
		integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../static/css/patient-dates.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
		integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body data-pk="<?php echo $_SESSION["pk"]; ?>">

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
						<a href="search-dates.php" class="btn btn-primary btnSize m-1">
							<i class="fa-solid fa-house"></i>
						</a>
						<a id="btn-close-sesion" href="#" class="btn btn-danger btnSize m-1">
							<i class="fa-solid fa-right-from-bracket"></i>
						</a>
					</div>
				</div>
			</div>
		</section>
		<hr>
		<section id="my-dates">
			<div class="container">
				<div class="row">
					<h1>Mis Citas</h1>
				</div>
				<div class="row justify-content-center ">
					<div class="col-12 col-lg-6 mt-4 mt-lg-0 w-75 ">
						<div id="info-my-dates">
							<?php
							$getDates = file_get_contents("http://192.168.200.143:8000/date/dates-patient-api/?api_key=Sistemas2005$&patient=" . $_SESSION["pk"]);
							$data = json_encode($getDates);
							$data = json_decode($getDates);

							foreach ($data->dates as $row) {
								$time = strtotime($row->date);
								$esFormat = date('d-m-Y', $time);
								$specialtiesStr = "";
								$countSpecialty = 0;
								foreach ($row->speciality as $specialty) {
									$countSpecialty++;
									$specialtiesStr .= $specialty . ((count($row->speciality) != $countSpecialty) ? ", " : "");
								}

								echo "<a href='#' id='{$row->pk}' class='date'>$esFormat -  {$row->start_time} - $specialtiesStr - {$row->doctor}</a>";
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>

	</div>

	<!--modal registrar nueva cita-->
	<div class="modal chooseDate" tabindex="-1">
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
						<p><span><b>Fecha: </b></span><span class="dataOfDate"> </span><span><b> Hora Inicio:
								</b></span><span class="startTime"></span></p><span><b> Hora Fin: </b></span><span
							class="finishTime"></span></p>
						<p><span><b>Tipo de cita: </b></span><span class="tipeOfDate"></span></p>
						<p><span><b>Especialidad: </b></span><span class="speciatyOfDate"></span></p>
						<p><span><b>Doctor/a: </b></span><span class="doctorOfDate"></span></p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary deleteDate btnSize">
						<i class="fa-solid fa-trash"></i></button>
				</div>
			</div>
		</div>
	</div>







	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.7.0.js"
		integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="../static/js/patient-dates.js"></script>
</body>

</html>