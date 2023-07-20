$(document).ready(index);

function index() {
    var today = new Date(); // Recoger el día actual
    var months = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
    var actualMonth = today.getMonth();
    var actualMonthName = months[today.getMonth()];
    var actualYear = today.getFullYear();
    var fecha;

    $(document).resize(function () {
        $("#hour-list").height($("#calendar-table").height());
    });

    $("#header-title-calendar").append("<b><span id =" + today.getMonth() + ">" + actualMonthName + "</span> <span>" + actualYear + "</span></b>")


    createCalendar($("#calendar-table")[0], today.getFullYear(), today.getMonth());

    function createCalendar(elem, year, month) {
        let d = new Date(year, month);  // Montamos una fecha en base al año y el mes pasado
        let table = '<table class="table"><thead><th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th></thead><tr>';

        for (let i = 0; i < getDay(d); i++) {
            table += '<td></td>';
        }

        while (d.getMonth() == month) {
            table += '<td>' + d.getDate() + '</td>';

            if (getDay(d) % 7 == 6) {
                table += '</tr><tr>';
            }

            d.setDate(d.getDate() + 1);
        }

        if (getDay(d) != 0) {
            for (let i = getDay(d); i < 7; i++) {
                table += '<td></td>';
            }
        }

        table += '</tr></table>';
        elem.innerHTML = table;
    }

    function getDay(date) {
        let day = date.getDay();
        if (day == 0) day = 7;
        return day - 1;
    }


    $("#specialty").change(function () {
        let nameSpecialty = $("#specialty option:selected").text();

        $.ajax({
            type: "POST",
            url: "http://192.168.200.143:8000/doctor/get-doctor-specialty-api/?specialtyName=" + nameSpecialty,
            dataType: 'json',
            data: { "api_key": "Sistemas2005$" },
            success: function (response) {
                if (response.doctors.length > 0) {
                    $("#doctor option").remove();
                    for (let i = 0; i < response.doctors.length; i++) {
                        $.ajax({
                            type: "GET",
                            url: "http://192.168.200.143:8000/management/get-insurances-doctor-patient/?api_key=Sistemas2005$&patient=" + $("body").attr("data-pk") + "&doctor=" + response.doctors[i][0],
                            success: function (response2) {
                                if (response2.insurances.length > 0) {
                                    $("#doctor").append("<option disabled selected > Elige un Doctor</option>");
                                    let option = $("<option id='" + response.doctors[i][0] + "'>" + response.doctors[i][1] + " " + response.doctors[i][2] + "</option>");
                                    $("#doctor").append(option);

                                    createCalendar($("#calendar-table")[0], actualYear, actualMonth);
                                }

                            }
                        });
                    }
                }
            }
        });
    });

    $("#previousMonth").click(function (e) {
        e.preventDefault();

        if (actualMonth == 0) {
            actualMonth = 11;
            actualYear--;
            createCalendar($("#calendar-table")[0], actualYear, actualMonth);

            $("#header-title-calendar").text("");
            $("#header-title-calendar").append("<b><span id =" + 11 + ">" + months[11] + "</span> <span>" + actualYear + "</span></b>");
            setDatesCloses();
        } else {
            actualMonth--;
            createCalendar($("#calendar-table")[0], actualYear, actualMonth);
            $("#header-title-calendar").text("");
            $("#header-title-calendar").append("<b><span id =" + actualMonth + ">" + months[actualMonth] + "</span> <span>" + actualYear + "</span></b>");
            setDatesCloses();
        }

    });

    $("#nextMonth").click(function (e) {
        e.preventDefault();

        if (actualMonth == 11) {
            actualMonth = 0;
            actualYear++;
            createCalendar($("#calendar-table")[0], actualYear, actualMonth);
            $("#header-title-calendar").text("");
            $("#header-title-calendar").append("<b><span id =" + 0 + ">" + months[0] + "</span> <span>" + actualYear + "</span></b>");
            setDatesCloses();
        } else {
            actualMonth++;
            createCalendar($("#calendar-table")[0], actualYear, actualMonth);
            $("#header-title-calendar").text("");
            $("#header-title-calendar").append("<b><span id =" + actualMonth + ">" + months[actualMonth] + "</span> <span>" + actualYear + "</span></b>");
            setDatesCloses();
        }



    });


    $("#doctor, #dateType").change(function (e) {
        e.preventDefault();
        createCalendar($("#calendar-table")[0], actualYear, actualMonth);
        setDatesCloses();
    });

    $("#doctor").change(function (e) {

    });

    $("#btn-close-sesion").click(function () {
        $.ajax({
            type: "POST",
            url: "./closeSesion.php",
            success: function (response) {
                window.location.href = "../index.php";
            }
        });
    });



    $(".cerrarModalClientes").click(function (e) {
        e.preventDefault();
        $(".chooseDate").hide();
    });

    $(".saveDate").click(function (e) {
        e.preventDefault();
        // "http://app.policlinicagranada.com:8000/date/assign-date-patient-api/";     

        aux = fecha.split("-");
        aux = aux[2] + "-" + aux[1] + "-" + aux[0];
        console.log(aux + " " + $('#doctor option:selected').attr('id') + " " + $('#dateType option:selected').attr('id'));


        $.ajax({
            type: "POST",
            dataType: 'json',
            data: { "api_key": "Sistemas2005$", "patient": $("body").attr("data-pk"), "date": $(".dataTotalDate").attr("pkdate") },
            url: "http://192.168.200.143:8000/date/assign-date-patient-api/",
            success: function (response) {
                //location.reload();
                //function to show automatically the alert of the booked appointment
                $('#modal-test').modal("hide");
                //$('#success-alert').css("display","");
                alert("Su cita ha sido reservada correctamente");
                //window.location.href = window.location.href;  
            }
        });

    });

    function setDatesCloses() {
        let dateType = $('#dateType option:selected').attr('id');
        let doctorPk = $('#doctor option:selected').attr('id');

        $.ajax({
            type: "POST",
            url: "http://192.168.200.143:8000/date/get-free-dates-doctor-by-td/?doctorPk=" + doctorPk + "&dateType=" + dateType,
            dataType: 'json',
            data: { "api_key": "Sistemas2005$" },
            success: function (response) {
                if (response.status) {
                    let dates = response.dateList;

                    if (dates.length > 0) {
                        for (let i = 0; i < response.dateList.length; i++) {
                            let day = response.dateList[i].substring(0, 2);
                            if (day.substr(0, 1) == 0) {
                                day = day.substr(1);
                            }
                            if (response.dateList[i].substring(3, 5) == (actualMonth + 1)) {
                                for (let j = 0; j < document.querySelector("table").querySelectorAll("td").length; j++) {
                                    if (document.querySelector("table").querySelectorAll("td")[j].textContent == day) {
                                        document.querySelector("table").querySelectorAll("td")[j].setAttribute("class", "dt");
                                        document.querySelector("table").querySelectorAll("td")[j].childNodes[0].data = "";
                                        document.querySelector("table").querySelectorAll("td")[j].appendChild(document.createElement("a"));
                                        document.querySelector("table").querySelectorAll("td")[j].childNodes[1].setAttribute("href", "#");
                                        document.querySelector("table").querySelectorAll("td")[j].childNodes[1].setAttribute("class", "free");
                                        document.querySelector("table").querySelectorAll("td")[j].childNodes[1].text = day;
                                    }
                                }
                            }
                        }
                    } else {
                        createCalendar($("#calendar-table")[0], actualYear, actualMonth);
                    }

                } else {

                    createCalendar($("#calendar-table")[0], actualYear, actualMonth);
                }
            }
        });
    }

    $("#calendar").on("click", ".free", function (e) {
        e.preventDefault();

        let dateType = $('#dateType option:selected').attr('id');
        let doctorPk = $('#doctor option:selected').attr('id');
        let dia = this.text;
        let mes = parseInt($("#header-title-calendar > b > span").attr("id")) + 1;
        let anio = $("#header-title-calendar > b").find('span').text().substring($("#header-title-calendar > b").find('span').text().length - 4, $("#header-title-calendar > b").find('span').text().length);

        if (dia.length < 2) {
            dia = "0" + dia;
        }
        if (mes < 10) {
            mes = "0" + mes.toString();
        }

        fecha = dia + "-" + mes + "-" + anio;
        $.ajax({
            type: "POST",
            url: "http://192.168.200.143:8000/date/get-free-dates-hours-doctor-by-td/?doctorPk=" + doctorPk + "&dateType=" + dateType + "&day=" + fecha.split("-")[2] + "-" + fecha.split("-")[1] + "-" + fecha.split("-")[0],
            dataType: 'json',
            data: { "api_key": "Sistemas2005$" },
            success: function (response) {
                $("#hour-list a").remove();


                for (let i = 0; i < response.hourList.length; i++) {
                    document.querySelector("#hour-list > div > div").appendChild(document.createElement("a"));
                    document.querySelector("#hour-list > div > div").children[i].setAttribute("class", "btn btn-sm btn-primary hour");
                    document.querySelector("#hour-list > div > div").children[i].setAttribute("href", "#");
                    document.querySelector("#hour-list > div > div").children[i].setAttribute("data-pk", response.datePkList[i]);
                    document.querySelector("#hour-list > div > div").children[i].text = response.hourList[i];

                }

                $(".hour").click(function (e) {
                    e.preventDefault();
                    $(".dataTotalDate").attr("pkDate", $(this).attr("data-pk"));
                    $(".chooseDate").show();
                    $(".dataOfDate").text(dia + " " + $("#header-title-calendar > b").find('span').text().substring(0, $("#header-title-calendar > b").find('span').text().length - 4) + " " + $("#header-title-calendar > b").find('span').text().substring($("#header-title-calendar > b").find('span').text().length - 4));
                    $(".dataOfHour").text($(this).text().substring(0, $(this).text().length - 3));
                    $(".tipeOfDate").text($("#dateType option:selected").text());
                    $(".speciatyOfDate").text($("#specialty option:selected").text());
                    $(".doctorOfDate").text($("#doctor option:selected").text());
                });
            }
        });
    });






}