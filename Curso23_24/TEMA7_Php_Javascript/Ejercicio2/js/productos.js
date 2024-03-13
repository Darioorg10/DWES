const DIR_SERV = "./servicios_rest_key";

// ----- MOSTRAR TABLA CON PRODUCTOS -----
function vista_productos () {
    $.ajax({
        url: DIR_SERV + "/productos",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            // si no hay errores que mostrar pone la tabla
            if (data.mensaje_error) {
                $('#errores').html(data.mensaje_error);
                $('#respuestas').html("");
                $('#productos').html("");
            }
            else {
                // creo la tabla 
                let html_tabla_prod = "<table class='centrado'>";
                html_tabla_prod += "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><button class='enlace' onclick='seguridad(formInsertar);'>Productos+</button></th></tr>";

                $.each(data.productos, function (key, tupla) {
                    html_tabla_prod += "<tr>";
                    html_tabla_prod += "<td><button class='enlace' onclick='seguridad(detalles,\"" + tupla["cod"] + "\")'>" + tupla["cod"] + "</button></td>";
                    html_tabla_prod += "<td>" + tupla["nombre_corto"] + "</td>";
                    html_tabla_prod += "<td>" + tupla["PVP"] + "</td>";
                    html_tabla_prod += "<td><button class='enlace' onclick='seguridad(dudaBorrar,\"" + tupla["cod"] + "\");'>Borrar</button> - <button class='enlace' onclick='seguridad(formEditar,\"" + tupla["cod"] + "\");'>Editar</button></td>";
                    html_tabla_prod += "</tr>";
                });

                html_tabla_prod += "</table>";
                $('#errores').html("");
                $('#productos').html(html_tabla_prod);
            }
        })
        // errores
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#respuestas').html("");
            $('#productos').html("");
            localStorage.clear()
        });
}




// +++++++++++++++++++++++++++++++++++++++++++ VISTA NORMAL +++++++++++++++++++++++++++++++++++++++++++

function vista_productos_normal () {
    $.ajax({
        url: "servicios_rest_key/productos",
        type: "GET",
        dataType: "json",
        data: { "api_session": localStorage.api_session }
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $('#errores').html(data.mensaje_error);
                $('#respuestas').html("");
                $('#productos').html("");
            } else {
                var html_tabla_prod = "<table class='centrado'>";
                html_tabla_prod += "<tr><th>COD</th><th>Nombre</th><th>PVP</th></tr>";

                $.each(data.productos, function (key, tupla) {
                    html_tabla_prod += "<tr>";
                    html_tabla_prod += "<td><button class='enlace' onclick='seguridad(detalles,\"" + tupla["cod"] + "\")'>" + tupla["cod"] + "</button></td>";
                    html_tabla_prod += "<td>" + tupla["nombre_corto"] + "</td>";
                    html_tabla_prod += "<td>" + tupla["PVP"] + "</td>";
                    html_tabla_prod += "</tr>";
                });

                html_tabla_prod += "</table>";
                $('#errores').html("");
                $('#productos').html(html_tabla_prod);
            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#respuestas').html("");
            $('#productos').html("");
            localStorage.clear()
        });
}

// ----- MOSTRAR DETALLES DE X PRODUCTO -----
function detalles (cod) {
    $.ajax({
        url: encodeURI(DIR_SERV + "/producto/" + cod),
        type: "GET",
        dataType: "json",
        data: { "api_session": localStorage.api_session }
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $('#errores').html(data.mensaje_error);
                $('#respuestas').html("");
                $('#productos').html("");
            }
            else if (data.mensaje) { // El producto se ha borrado
                $('#errores').html("");
                $('#respuestas').html("<p class='mensaje'>El producto con cod: <strong>" + cod + "</strong> ya no se encuentra en la BD.</p>");
                vista_productos();
            }
            else {
                $.ajax({
                    url: encodeURI(DIR_SERV + "/familia/" + data.producto["familia"]),
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data2) {
                        if (data2.mensaje_error) {
                            $('#errores').html(data2.mensaje_error);
                            $('#respuestas').html("");
                            $('#productos').html("");
                        }
                        else {  // Detalles de producto
                            let html_respuesta = "<h2>Información del producto: " + cod + "</h2>";
                            html_respuesta += "<p><strong>Nombre: </strong>";
                            if (data.producto["nombre"])
                                html_respuesta += data.producto["nombre"];
                            html_respuesta += "</p>";
                            html_respuesta += "<p><strong>Nombre corto: </strong>" + data.producto["nombre_corto"] + "</p>";
                            html_respuesta += "<p><strong>Descripción: </strong>";
                            if (data.producto["descripcion"])
                                html_respuesta += data.producto["descripcion"];
                            html_respuesta += "</p>";
                            html_respuesta += "<p><strong>PVP: </strong>" + data.producto["PVP"] + "€</p>";
                            html_respuesta += "<p><strong>Familia: </strong>";
                            if (data2.mensaje)
                                html_respuesta += "No se encuentra ninguna familia con cod: " + data.producto["familia"];
                            else
                                html_respuesta += data2.familia["nombre"];
                            html_respuesta += "</p>";
                            html_respuesta += "<p><button onclick='seguridad(volver)'>Volver</button></p>";

                            $('#respuestas').html(html_respuesta);

                        }
                    })
                    .fail(function (a, b) {
                        $('#errores').html(error_ajax_jquery(a, b));
                        $('#respuestas').html("");
                        $('#productos').html("");
                        localStorage.clear()
                    });
            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#respuestas').html("");
            $('#productos').html("");
            localStorage.clear()
        });
}
// Borrar el div
function volver () {
    $('#respuestas').html("");
}


// Confirmación del borrado del producto
function dudaBorrar (cod) {
    html_conf_borrar = "<p class='centrado'>¿Está seguro de que quiere borrar el producto: <strong>" + cod + "</strong>?</p>";
    html_conf_borrar += "<p class='centrado'><button onclick='seguridad(volver)'>Volver</button> <button onclick='seguridad(borrar,\"" + cod + "\")'>Continuar</button></p>";
    $('#respuestas').html(html_conf_borrar);
}

// ----- BORRAR EL PRODUCTO X -----
function borrar (cod) {
    $.ajax({
        url: encodeURI(DIR_SERV + "/producto/borrar/" + cod),
        type: "DELETE",
        dataType: "json",
        data: { "api_session": localStorage.api_session }
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $('#errores').html(data.mensaje_error);
                $('#respuestas').html("");
                $('#productos').html("");
            }
            else {
                $('#errores').html("");
                $('#respuestas').html("<p class='mensaje'>El producto: <strong>" + cod + "</strong> se ha borrado</p>");
                vista_productos();
            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#respuestas').html("");
            $('#productos').html("");
            localStorage.clear()
        });
}



// +++++++++++++++++++++++++++++++++++++++++++ FUNCIONES DE ADMIN +++++++++++++++++++++++++++++++++++++++++++


// Enseña el formulario con el que se inserta
function formInsertar () {
    $.ajax({
        url: DIR_SERV + "/familias",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $('#errores').html(data.mensaje_error);
                $('#respuestas').html("");
                $('#productos').html("");
            }
            else {
                let mostrarFormInsert = "<h2>Creando un producto</h2>";
                mostrarFormInsert += "<form onsubmit='event.preventDefault();insertarProduct();'>";
                mostrarFormInsert += "<p><label for='cod'>Código: </label><input type='text' id='cod' required/><span class='error' id='errorCod'></span></p>";
                mostrarFormInsert += "<p><label for='nombre'>Nombre: </label><input type='text' id='nombre'/></p>";
                mostrarFormInsert += "<p><label for='nombre_corto'>Nombre Corto: </label><input type='text' id='nombre_corto' required/><span class='error' id='errorNomCort'></span></p>";
                mostrarFormInsert += "<p><label for='descripcion'>Descripción: </label><textarea id='descripcion'></textarea></p>";
                mostrarFormInsert += "<p><label for='PVP'>PVP: </label><input type='number' id='PVP' min='0.01' step='0.01' required/></p>";
                mostrarFormInsert += "<p><label for='familia'>Seleccione una familia: </label>";
                mostrarFormInsert += "<select id='familia'>";
                $.each(data.familias, function (key, tupla) {
                    mostrarFormInsert += "<option value='" + tupla["cod"] + "'>" + tupla["nombre"] + "</option>"
                });
                mostrarFormInsert += "</select></p>";
                mostrarFormInsert += "<p><button onclick='event.preventDefault();seguridad(volver)';>Volver</button>";
                mostrarFormInsert += "<button>Continuar</button></p>"

                mostrarFormInsert += "</form>";

                $('#respuestas').html(mostrarFormInsert);
            }
        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#respuestas').html("");
            $('#productos').html("");
            localStorage.clear()
        });
}

// ----- +++++ INSERTAR PRODUCTO +++++ -----
function insertarProduct () {
    $('#errorCod').html("");
    $('#errorNomCort').html("");

    let cod = $('#cod').val();
    let nombre_corto = $('#nombre_corto').val();

    // Primero hay que comprobar que el codigo no está repetido
    $.ajax({
        url: encodeURI(DIR_SERV + "/repetido/producto/cod/" + cod),
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $('#errores').html(data.mensaje_error);
                $('#respuestas').html("");
                $('#productos').html("");
            }
            // si está repetido lo muestro, y compruebo tambien el nombre corto
            else if (data.repetido) {
                $('#errorCod').html("Código repetido");

                $.ajax({
                    url: encodeURI(DIR_SERV + "/repetido/producto/nombre_corto/" + nombre_corto),
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data) {
                        if (data.mensaje_error) {
                            $('#errores').html(data.mensaje_error);
                            $('#respuestas').html("");
                            $('#productos').html("");
                        }
                        // si esta repetido lo muestra
                        if (data.repetido) {
                            $('#errorNomCort').html("Nombre corto repetido");
                        }
                    })
                    .fail(function (a, b) {
                        $('#errores').html(error_ajax_jquery(a, b));
                        $('#respuestas').html("");
                        $('#productos').html("");
                        localStorage.clear()
                    });
            } else {
                // Si el código no está repetido pregunto por le nombre corto
                $.ajax({
                    url: encodeURI(DIR_SERV + "/repetido/producto/nombre_corto/" + nombre_corto),
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data) {
                        if (data.mensaje_error) {
                            $('#errores').html(data.mensaje_error);
                            $('#respuestas').html("");
                            $('#productos').html("");
                        }
                        // Muestro que nombre corto esta repe
                        if (data.repetido) {
                            $('#errorNomCort').html("Nombre corto repetido");
                        } else {    // si no esta repe cojo los datos 
                            let nombre = $('#nombre').val();
                            let descripcion = $('#descripcion').val();
                            let PVP = $('#PVP').val();
                            let familia = $('#familia').val();

                            // hago la inserción del producto
                            $.ajax({
                                url: DIR_SERV + "/producto/insertar",
                                type: "POST",
                                dataType: "json",
                                data: { "cod": cod, "nombre": nombre, "nombre_corto": nombre_corto, "descripcion": descripcion, "PVP": PVP, "familia": familia }
                            })
                                .done(function (data) {
                                    if (data.mensaje_error) {
                                        $('#errores').html(data.mensaje_error);
                                        $('#respuestas').html("");
                                        $('#productos').html("");
                                    } else { // Muestro mensaje
                                        $('#respuestas').html("<p class='mensaje'>El producto: <strong>" + cod + "</strong> se ha insertado con éxito<p>");
                                        vista_productos();
                                    }

                                })
                                .fail(function (a, b) {
                                    $('#errores').html(error_ajax_jquery(a, b));
                                    $('#respuestas').html("");
                                    $('#productos').html("");
                                    localStorage.clear()
                                });
                        }
                    })
                    .fail(function (a, b) {
                        $('#errores').html(error_ajax_jquery(a, b));
                        $('#respuestas').html("");
                        $('#productos').html("");
                        localStorage.clear()
                    });

            }

        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#respuestas').html("");
            $('#productos').html("");
            localStorage.clear()
        });
}

// ----- +++++ EDITAR PRODUCTO +++++ -----
function editarProd (cod) {
    let nombre_corto = $('#nombre_corto').val();
    $.ajax({
        url: encodeURI(DIR_SERV + "/repetido/producto/nombre_corto/" + nombre_corto + "/cod/" + cod),
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {

            if (data.repetido) {
                // muestra mensaje error
                $('#errorNomCort').html("Nombre corto repetido");
            }
            else if (!data.repetido) {
                let nombre = $('#nombre').val();
                let descripcion = $('#descripcion').val();
                let PVP = $('#PVP').val();
                let familia = $('#familia').val();
                $.ajax({
                    url: encodeURI(DIR_SERV + "/producto/actualizar/" + cod),
                    type: "PUT",
                    dataType: "json",
                    data: { "nombre": nombre, "nombre_corto": nombre_corto, "descripcion": descripcion, "PVP": PVP, "familia": familia }
                })
                    .done(function (data) {
                        if (data.mensaje) {
                            $('#respuestas').html("<p class='mensaje'>El producto: <strong>" + cod + "</strong> se ha editado con éxito<p>");
                            vista_productos();
                        }
                        else {
                            $('#errores').html(data.mensaje_error);
                            $('#principal').html("");
                        }
                    })
                    .fail(function (a, b) {
                        $('#errores').html(error_ajax_jquery(a, b));
                        $('#principal').html("");
                        localStorage.clear()
                    });

            }
            else {
                $('#errores').html(data.mensaje_error);
                $('#principal').html("");
            }

        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#principal').html("");
            localStorage.clear()
        });
}

// Muestra el formulario para editar
function formEditar (cod) {
    // cojo los datos del producto para meterlo en los inputs
    $.ajax({
        url: encodeURI(DIR_SERV + "/producto/" + cod),
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $('#errores').html(data.mensaje_error);
                $('#principal').html("");
            }
            else if (data.producto) {
                // llamo a todas las familias para mostrarlas en el select
                $.ajax({
                    url: DIR_SERV + "/familias",
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data2) {
                        if (data2.mensaje_error) {
                            $('#errores').html(data2.mensaje_error);
                            $('#principal').html("");
                            // si no hay errores monto el formulario
                        } else {
                            let formEditar = "<h2>Editar producto: " + cod + "</h2>";
                            formEditar += "<form onsubmit='event.preventDefault();editarProd(\"" + cod + "\");'>";
                            formEditar += "<p><label for='nombre'>Nombre: </label><input type='text' id='nombre' ";
                            if (data.producto["nombre"])
                                formEditar += "value='" + data.producto["nombre"] + "'";
                            formEditar += "/></p>";
                            formEditar += "<p><label for='nombre_corto'>Nombre Corto: </label><input type='text' id='nombre_corto' required value='" + data.producto["nombre_corto"] + "'/><span id='errorNomCort'></span></p>";
                            formEditar += "<p><label for='descripcion'>Descripción: </label><textarea id='descripcion'>" + data.producto["descripcion"] + "</textarea></p>";
                            formEditar += "<p><label for='PVP'>PVP: </label><input type='number' id='PVP' min='0.01' step='0.01' required value='" + data.producto["PVP"] + "'/></p>";
                            formEditar += "<p><label for='familia'>Seleccione una familia: </label>";
                            formEditar += "<select id='familia'>";
                            $.each(data2.familias, function (key, tupla) {
                                if (tupla["cod"] == data.producto["familia"])
                                    formEditar += "<option selected value='" + tupla["cod"] + "'>" + tupla["nombre"] + "</option>";
                                else
                                    formEditar += "<option value='" + tupla["cod"] + "'>" + tupla["nombre"] + "</option>"
                            });
                            formEditar += "</select>";
                            formEditar += "</p>";
                            formEditar += "<p><button onclick='seguridad(volver);event.preventDefault();'>Volver</button> <button>Continuar</button></p>";
                            formEditar += "</form>";
                            $('#respuestas').html(formEditar);
                        }

                    })
                    .fail(function (a, b) {
                        $('#errores').html(error_ajax_jquery(a, b));
                        $('#principal').html("");
                        localStorage.clear()
                    });

            } else {
                output = "<p>El producto con cod: <strong>" + cod + "</strong> ya no se encuentra en la BD</p>";
                $('#respuestas').html(output);
                vista_productos();
            }


        })
        .fail(function (a, b) {
            $('#errores').html(error_ajax_jquery(a, b));
            $('#principal').html("");
            localStorage.clear()
        });
}

// Funcion de seguridad
function seguridad (nombre_func, param_func=undefined) {
    if (localStorage.ultima_accion && localStorage.api_session) {
        //Pasar la seguridad y cargar vista oportuna
        // Si ha pasado el tiempo
        if (((new Date() / 1000) - localStorage.ultima_accion) < TIEMPO_SESION_MINUTOS * 60) {
            $.ajax({
                url: "servicios_rest_key/logueado",
                type: "GET",
                dataType: "json",
                data: { "api_session": localStorage.api_session }
            })
                .done(function (data) {
                    if (data.usuario) {
                        localStorage.setItem("ultima_accion", (new Date() / 1000));
                        nombre_func(param_func)
                    }
                    else if (data.mensaje) {
                        localStorage.clear();
                        cargar_vista_login("Usted ya no se encuentra registrado en la BD");

                    }
                    else if (data.no_auth) {
                        localStorage.clear();
                        cargar_vista_login("El tiempo de sesión de la API ha expirado.");
                    }
                    else {
                        $('#errores').html(data.mensaje_error);
                        $('#principal').html("");
                    }
                })
                .fail(function (a, b) {
                    $('#errores').html(error_ajax_jquery(a, b));
                    $('#principal').html("");
                    localStorage.clear()
                });
        }
        else {
            localStorage.clear();
            cargar_vista_login("Su tiempo de sesión ha expirado");
        }
    }
    else {
        cargar_vista_login("");
    }
}


