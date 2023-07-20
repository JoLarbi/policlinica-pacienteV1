$(document).ready(index);

function index() { 

    $("form").submit(function(e){
        e.preventDefault();

        let username = $("#username").val();
        let pass = $("#pass").val();

        $.ajax({ 
            type: "POST",
            url: "http://192.168.200.143:8000/account/login-api/",
            dataType: 'json',
            data:{"api_key":"Sistemas2005$","username": username, "password" : pass},
            success: function(response){
                console.log(response.user.pk);
                if(response.login){  

                    $("#patientPK").val(response.user.pk); // Mandar el pk del paciente
                    $("#patientName").val(response.user.first_name); // Mandar el nombre del paciente
                    $("#patientLastName").val(response.user.last_name); // Mandar el apellido del paciente
                    $("#errorHelp").css("display","none");                  

                    $.ajax({ 
                        type: "POST",
                        url: "./php/infoLogin.php",
                        data:{"pk":response.user.pk,"patientName":response.user.first_name,"patientLastName":response.user.last_name,"insurance":response.user.insurance},
                        success: function(response){
                            console.log(response);
                            window.location.href = "./php/search-dates.php";                     
                        }
                    });
                }else{
                    $("#errorHelp").css({"display":"", "text-align" : "center"}); 
                    $("#errorHelp").css("color","red");

                }
            }
        });
    });


    
}