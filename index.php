<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Tomas Juarez">
    <title>Formulario de Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <style>
        .formulario{
            width: 680px;
            padding: 25px;
            margin: auto;
            background: #ccc;
        }
        .row{
            margin-bottom: 15px;
        }
        .alertMsg{
            display: none;
            width: 680px;
            padding: 1rem 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            margin: auto;
            border: 1 px solid;
        }
        .exito{
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }
        .error{
            color: #664d03;
            background-color: #fff3cd;
            border-color: #ffecb5;
        }
    </style>
</head>
<body>

    <div class="alertMsg exito">Buenas noticias! El mensaje se registr&oacute; correctamente.</div>
    <div class="alertMsg error">No puede generar otra petici&oacute;n para este formulario de contacto.</div>

    <div class="formulario">
        <form action="procesa_form.php" method="POST" id="formulario" class="row g-3 needs-validation" novalidate>
            <div class="row">
                <div class="col">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre" required>
                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                </div>
                <div class="col">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" placeholder="Ingrese su apellido" required>
                    <div class="invalid-feedback">Por favor, ingrese su apellido.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Ingrese su email" aria-describedby="emailHelp" required>
                    <div class="invalid-feedback">Por favor, ingrese un email v&aacute;lido.</div>
                </div>
                <div class="col">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control" id="dni" placeholder="Ingrese su DNI" required>
                    <div class="invalid-feedback">Por favor, ingrese su DNI.</div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" id="mensaje" placeholder="Ingrese un mensaje" rows="3" required></textarea>
                <div class="invalid-feedback">Por favor, ingrese su mensaje/consulta.</div>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

    <script>

        //Esta funcion anonima sirve para validar el formulario, basandose en las propiedades de HTML5
        (function () {

            var forms = document.querySelectorAll('.needs-validation');

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');
                    }
                    else{
                        event.preventDefault();
                        event.stopPropagation();
                        procesarForm();
                    }
                }, false);
                });
        })()

        //Funcion que procesa los datos para cargarlos en la BD
        function procesarForm(){

            //Armo un JSON con los datos
            var formData = {
                nombre      : $('#nombre').val(),
                apellido    : $('#apellido').val(),
                email       : $('#email').val(),
                dni         : $('#dni').val(),
                mensaje     : $('#mensaje').val()
            };

            //Ejecuto un request de tipo POST al archivo PHP que contiene la logica. A este archivo le paso los datos del formulario
            $.ajax({
                type        : 'POST',
                url         : 'procesa_form.php',
                processData : false,
                data        : JSON.stringify(formData),
                dataType    : 'text',
                encode      : true
            })
            .done(function(data) { //Si el request se completa exitosamente...

                //Todo salio bien, asi que muestro un mensaje de confirmacion y limpio el formulario
                if(data == "OK"){
                    $(".exito").slideDown('slow', function () {
                        $(this).delay(3000).slideUp('slow');
                    });
                    $("#formulario").trigger('reset')
                }
                else{ //El DNI ingresado ya existe en la BD, asi que muestro un mensaje de error
                    $(".error").slideDown('slow', function () {
                        $(this).delay(3000).slideUp('slow');
                    });
                }

            })
            .fail(function(jqXHR, textStatus, errorThrown) { 
                //Si el request termina con un error NO contemplado, muestro un mensaje generico
                $(".error").text('Ups, algo salió mal!');
                $(".error").slideDown('slow', function () {
                    $(this).delay(3000).slideUp('slow');
                });
            });

        }

    </script>
</body>
</html>