<?php
    session_start();

    $_SESSION["pk"] = $_POST["pk"];
    $_SESSION["patientName"] = $_POST["patientName"];
    $_SESSION["patientLastName"] = $_POST["patientLastName"];
    $_SESSION["insurance"] = $_POST["insurance"];
    echo "paciente creado ";
?>