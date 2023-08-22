<!doctype html>
 <!-- lee el archivo Readme al principio del repositorio  -->
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!--Jquery!-->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>

    <!--Iconos!-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--Pooper!-->
    <script src="../node_modules/@popperjs/core/dist/umd//popper.min.js"></script>

    <!--ClockPicker!-->
    <link rel="stylesheet" href="../node_modules/clockpicker-gh-pages/dist/bootstrap-clockpicker.css">
    <script src="../node_modules/clockpicker-gh-pages/dist/bootstrap-clockpicker.js"></script>

    <!--Calendar!-->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');
            $('.clockpicker').clockpicker();
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: "es",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: '../controllers/datoseventos.php?accion=listar',
                dateClick: function(info) {
                    limpiarFormulario();
                    $('#BotonAgregar').show();
                    $('#BotonModificar').hide();
                    $('#BotonBorrar').hide();

                    if (info.allDay) {
                        $('#FechaInicio').val(info.dateStr);
                        $('#FechaFin').val(info.dateStr)
                    } else {
                        // let fechaHora = info.dateStr.split("T");
                        // $('#FechaInicio').val(fechaHora[0]);
                        // $('#FechaFin').val(fechaHora[0]);
                        // $('#HoraInicio').val(fechaHora[1].substring(0,5));
                    }

                    $("#formularioEventos").modal('show');
                },
                //Modificar
                eventClick: function(info) {
                    $('#BotonAgregar').hide();
                    $('#BotonModificar').show();
                    $('#BotonBorrar').show();

                    $('#Id').val(info.event.id);
                    $('#Titulo').val(info.event.title);
                    $('#FechaInicio').val(moment(info.event.start).format("YYYY-MM-DD"));
                    $('#HoraInicio').val(moment(info.event.start).format("HH:mm"));
                    $('#FechaFin').val(moment(info.event.end).format("YYYY-MM-DD"));
                    $('#HoraFin').val(moment(info.event.end).format("HH:mm"));
                    $('#Descripcion').val(info.event.extendedProps.descripcion);
                    // $('#ColorFondo').val(info.eventBackgroundColor);
                    // $('#ColorTexto').val(info.event.textColor);
                    
                    // alert($('#Id').val(info.event.id));

                    $("#formularioEventos").modal('show');
                    
                }
            });
            calendar.render();

            //Boton agregar

            $('#BotonAgregar').click(function() {
                let registror = recuperarDatosFormulario();
                agregarRegistro(registror);
                $("#formularioEventos").modal('hide');
            });

            //boton modificar

            $('#BotonModificar').click(function() {
                
                let registro = recuperarDatosFormulario();
                modificarRegistro(registro);
                $("#formularioEventos").modal('hide');
            });

            // boton Eliminar

            $('#BotonBorrar').click(function() {
                
                let registro = recuperarDatosFormulario();
                borrarRegistro(registro);
                $("#formularioEventos").modal('hide');
            });


            //funcion para cominicarse con AJAX (Agregar)
            function agregarRegistro(registro) {
                $.ajax({
                    data: registro,
                    type: 'POST',
                    url: '../controllers/datoseventos.php?accion=agregar',
                    success: function(msg) {
                        calendar.refetchEvents();
                    },
                    error: function(error) {
                        var erro = JSON.stringify(error);
                        console.log(erro);
                        alert("Hubo un error al agregar el evento: " + error);
                    }
                })
            };

            //funcion para modificar resgitro

            function modificarRegistro(registro) {
                $.ajax({
                    data: registro,
                    type: 'POST',
                    url: '../controllers/datoseventos.php?accion=modificar',
                    success: function(msg) {
                        calendar.refetchEvents();
                    },
                    error: function(error) {
                        var erro = JSON.stringify(error);
                        console.log(erro);
                        alert("Hubo un error al modificar el evento: " + error);
                    }
                })
            };
 
            //funcion para borrar

            function borrarRegistro(registro) {
                $.ajax({
                    data: registro,
                    type: 'POST',
                    url: '../controllers/datoseventos.php?accion=borrar',
                    success: function(msg) {
                        calendar.refetchEvents();
                    },
                    error: function(error) {
                        var erro = JSON.stringify(error);
                        console.log(erro);
                        alert("Hubo un error al borrar el evento: " + error);
                    }
                })
            };


            //funciones de interaccion con el formulario
            function limpiarFormulario() {
                $('#Id').val('');
                $('#Titulo').val('');
                $('#Descripcion').val('');
                $('#FechaInicio').val('');
                $('#FechaFin').val('');
                $('#HoraInicio').val('');
                $('#HoraFin').val('');
                $('#ColorFondo').val('#3788D8');
                $('#ColorTexto').val('#FFFFFF');
            };

            function recuperarDatosFormulario() {
                let registro = {
                    id: $('#Id').val(),
                    titulo: $('#Titulo').val(),
                    descripcion: $('#Descripcion').val(),
                    inicio: $('#FechaInicio').val() + ' ' + $('#HoraInicio').val(),
                    fin: $('#FechaFin').val() + ' ' + $('#HoraFin').val(),
                    colorBackground: $('#ColorFondo').val(),
                    colorText: $('#ColorTexto').val()
                }
                return registro;
            };

        });
    </script>



    <!--Data Tables!-->
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>



    <!--Moment!-->
    <script src="../js/moment-with-locales.js"></script>

    <!--Estilos A parte!-->
    <style>
        nav,
        .offcanvas {
            background-color: #1e293b;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        @media(max-width:768px) {
            .navbar-nav>li:hover {
                background-color: #0dcaf0;
            }
        }
    </style>
</head>

<body>

    <?php include('../controllers/conexion.php') ?>

    <nav class="navbar navbar-expand-lg navbar-dark">

        <div class="container-fluid">

            <a href="http://" class="navbar-brand text-info fw-semibold fs-semibold fs-4">Pruebas</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">

                <span class="navbar-toggler-icon">
                </span>

            </button>

            <section class="offcanvas offcanvas-start" id="menuLateral" tabindex="-1">
                <div class="offcanvas-header" data-bs-theme="dark">
                    <h5 class="offcanvas-title  text-info">EMPERINOS</h5>
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body d-flex flex-column justify-content-between px-0">

                    <ul class="navbar-nav fs-5 justify-content-evenly">
                        <li class="nav-item p-3 py-md-1"><a href="" class="nav-link">Home</a></li>
                        <li class="nav-item p-3 py-md-1"><a href="" class="nav-link">Projects</a></li>
                        <li class="nav-item p-3 py-md-1"><a href="" class="nav-link">About</a></li>
                        <li class="nav-item p-3 py-md-1"><a href="" class="nav-link">Contact</a></li>
                    </ul>

                    <div class="d-lg-none align-self-center py-3">
                        <a href=""><i class="bi bi-twitter px-2 text-info fs-2"></i></a>
                        <a href=""><i class="bi bi-facebook px-2 text-info fs-2"></i></a>
                        <a href=""><i class="bi bi-github px-2 text-info fs-2"></i></a>
                        <a href=""><i class="bi bi-whatsapp px-2 text-info fs-2"></i></a>
                    </div>

                </div>
            </section>

        </div>

    </nav>
    <main>
        <div class="container-fluid">
            <div class="col-md-8 offset-md-2 ">
                <div id='calendar'></div>
            </div>
        </div>

        <!--Formulario de Eventos-->

        <div class="modal fade" id="formularioEventos" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="Id">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Titulo del Evento:</label>
                                <input type="text" class="form-control" placeholder="" id="Titulo">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Fecha de inicio:</label>
                                <div class="input-group" data-autoclose="true">
                                    <input type="date" class="form-control" id="FechaInicio">
                                </div>
                            </div>

                            <div class="form-group col-md-6" id="TituloHoraInicio">

                                <label for="">Hora de inicio:</label>

                                <div class="input-group clockpicker" data-autoclose="true">

                                    <input type="text" class="form-control" id="HoraInicio" autocomplete="off" value="">

                                </div>

                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Fecha de fin:</label>
                                <div class="input-group" data-autoclose="true">
                                    <input type="date" class="form-control" id="FechaFin">
                                </div>
                            </div>

                            <div class="form-group col-md-6">

                                <label for="">Hora de fin:</label>

                                <div class="input-group clockpicker" data-autoclose="true">

                                    <input type="text" class="form-control" id="HoraFin" autocomplete="off">

                                </div>

                            </div>
                        </div>

                        <div class="form-row">
                            <label for="">Descripcion:</label>
                            <textarea id="Descripcion" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-row">
                            <label for="">Color de Fondo</label>
                            <input type="color" value="#3788D8" id="ColorFondo" class="form-control" style="height: 36px;">
                        </div>

                        <div class="form-row">
                            <label for="">Color de Texto</label>
                            <input type="color" value="#FFFFFF" id="ColorTexto" class="form-control" style="height: 36px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="BotonAgregar" class="btn btn-success">Agregar</button>
                        <button type="button" id="BotonModificar" class="btn btn-success">Modificar</button>
                        <button type="button" id="BotonBorrar" class="btn btn-success">Borrar</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>