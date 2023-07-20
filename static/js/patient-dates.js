$(document).ready(index);
function index(){
    var pkPatient = $("body").attr("data-pk");

    //Mirar Bien
    var dateType = ["ASEGURADORAS","PRIMERA VEZ", "PRIVADO", "REVISION", "TELEFONICA"];    
    var dateSelected = "";
    var startTimeSelected = "";
    var finishTimeSelected = "";
    var dateTypeSelected = "";
    var specialtySelected = "";
    var doctorSelected = "";


    $(".cerrarModalClientes").click(function(e){
        e.preventDefault();
        $(".chooseDate").hide();
    });

    $("#info-my-dates a").click(function(e){
        e.preventDefault();

        let pk = $(this).attr("id");
        
        // Petición AJAX al clickar en la cita para recoger datos y mostrar en el modal
        $.ajax({
            url: "http://192.168.200.143:8000/date/get-date-api/?datepk=" + pk,
            type: "POST",
            data: {"api_key": "Sistemas2005$"},
            success: function(response){
                console.log("Datos de la cita: "+response["date"]);

                $(".dataOfDate").text(response["date"][1]);
                $(".startTime").text(response["date"][3]);
                $(".finishTime").text(response["date"][4]);

                switch (response["date"][6]) {
                    case 0:
                        $(".tipeOfDate").text("ASEGURADORA");
                        break;
                    case 1:
                        $(".tipeOfDate").text("PRIMERA VEZ");
                        break;
                    case 2:
                        $(".tipeOfDate").text("PRIVADO");
                        break;
                    case 3:
                        $(".tipeOfDate").text("REVISIÓN");
                        break;
                    case 4:
                        $(".tipeOfDate").text("TELEFÓNICA");
                        break;
                    default:
                        $(".tipeOfDate").text("OTRO");
                  }
                $(".speciatyOfDate").text(response["date"][5]);
                $(".doctorOfDate").text(response["date"][2]);
                $(".chooseDate").show();
                $(".chooseDate").attr("id-date" , response["date"][0]);
               

                
            }
        });
    });

    $(".deleteDate").click(function(e){
        e.preventDefault();
        $.ajax({
            url: "http://192.168.200.143:8000/date/unassign-date-patient-api/",
            type: "POST",
            data: {"api_key": "Sistemas2005$", "date":$(".chooseDate").attr("id-date")},
            success: function(response){
                $(".chooseDate").hide();
                location.reload();
            }
        });


    });
    $("#btn-close-sesion").click(function(){
        $.ajax({ 
            type: "POST",
            url: "./closeSesion.php",
            success: function(response){
                window.location.href = "../index.php";
            }
        });
    });

    
}