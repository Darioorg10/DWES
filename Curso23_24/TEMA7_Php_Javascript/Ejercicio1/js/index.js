const DIR_SERV = "http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Ejercicios_Servicios_Web/Ejercicio1/servicios_rest"


$(document).ready(function(){

    obtener_productos(); // Nada más empezar queremos mostrar la tabla con los productos

})

function error_ajax_jquery( jqXHR, textStatus) 
{
    var respuesta;
    if (jqXHR.status === 0) {
  
      respuesta='Not connect: Verify Network.';
  
    } else if (jqXHR.status == 404) {
  
      respuesta='Requested page not found [404]';
  
    } else if (jqXHR.status == 500) {
  
      respuesta='Internal Server Error [500].';
  
    } else if (textStatus === 'parsererror') {
  
      respuesta='Requested JSON parse failed.';
  
    } else if (textStatus === 'timeout') {
  
      respuesta='Time out error.';
  
    } else if (textStatus === 'abort') {
  
      respuesta='Ajax request aborted.';
  
    } else {
  
      respuesta='Uncaught Error: ' + jqXHR.responseText;
  
    }

    return respuesta;
}

// Vamos a hacer la tabla con los productos
function obtener_productos() {
    $.ajax({        
        url: DIR_SERV + "/productos",
        dataType: "json",
        type: "GET",

    }).done(function(data){
        if (data.mensaje_error) {
            $("#errores").html(data.mensaje_error)
            $("#principal").html("")
        } else {
            // Vamos a crear una tabla con los productos
            var html_tabla_prod = "<table class='centrado'>"
            html_tabla_prod += "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><button onclick='montar_form_crear()' class='enlace'>Productos+</button></th></tr>"
            
            $.each(data.productos, function(key, tupla){
                html_tabla_prod += "<tr>"
                html_tabla_prod += "<td><button class='enlace' onclick='detalles(\""+ tupla["cod"] +"\")'>"+ tupla["cod"] +"</button></td>"
                html_tabla_prod += "<td>"+ tupla["nombre_corto"] +"</td>"
                html_tabla_prod += "<td>"+ tupla["PVP"] +"</td>"
                html_tabla_prod += "<td>Borrar - Editar</td>"

                html_tabla_prod += "</tr>"
            })

            html_tabla_prod+="</table>"


            $("#errores").html("")
            $("#respuestas").html("")
            $("#productos").html(html_tabla_prod);
        }

    }).fail(function(a,b){
        $("#errores").html(error_ajax_jquery(a,b))
        $("#principal").html("")
    })
}

// Vamos a mostrar la información del producto sobre el que se dé click
function detalles(cod) {
    $.ajax({        
        url:encodeURI(DIR_SERV + "/producto/" + cod),
        dataType: "json",
        type: "GET",

    }).done(function(data){
        if (data.mensaje_error) {
            $("#errores").html(data.mensaje_error)
            $("#principal").html("")
        } else if(data.mensaje) {
            $("#errores").html("")
            $("#respuestas").html("<p>El producto con cod: <strong>"+ cod +"</strong> ya no se encuentra en la base de datos</p>")
            obtener_productos()
        } else {

            var familia;
            $.ajax({        
                url: encodeURI(DIR_SERV + "/familia/" + data.producto["familia"]),
                dataType: "json",
                type: "GET",
        
            }).done(function(data2){

                if (data2.mensaje_error) {
                    $("#errores").html(data2.mensaje_error)
                    $("#principal").html("")
                } else {
                    var html_respuesta = "<h2>Información del producto: "+ cod +"</h2>"
                    html_respuesta += "<p><strong>Nombre: </strong>"
                    if (data.producto["nombre"]) {
                        html_respuesta += data.producto["nombre"]
                    }
                    html_respuesta += "</p>"

                    html_respuesta += "<p><strong>Nombre corto: </strong>"+data.producto["nombre_corto"] + "</p>"
                    html_respuesta += "<p><strong>Descripción: </strong>"
                    if (data.producto["descripcion"]) {
                        html_respuesta += data.producto["descripcion"]
                    }
                    html_respuesta += "</p>"

                    html_respuesta += "<p><strong>PVP: </strong>"+data.producto["PVP"] + "€</p>"
                    html_respuesta += "<p><strong>Familia: </strong>"
                    if (data2.mensaje) {
                        html_respuesta += "No se encuentra ninguna"
                    } else {
                        html_respuesta += data2.familia["nombre"]
                    }
                    html_respuesta += "</p>"
                    html_respuesta += "<p><button onclick='volver()'>Volver</button></p>"

                    $("#respuestas").html(html_respuesta)

                }
                
            }).fail(function(a,b){
                $("#errores").html(error_ajax_jquery(a,b))
                $("#principal").html("")
            })


        }
        
    }).fail(function(a,b){

        $("#errores").html(error_ajax_jquery(a,b))
        $("#principal").html("")
    })
}

function montar_form_crear() {
    $.ajax({        
        url: DIR_SERV + "/familias",
        dataType: "json",
        type: "GET",

    }).done(function(data){
        if (data.mensaje_error) {
            $("#errores").html(data.mensaje_error)
            $("#principal").html("")
        } else {
            
            // Si obtengo las familias monto el formulario
            var html_form_crear = "<h2>Creando un producto</h2>"
            html_form_crear += "<form onsubmit='event.preventDefault()'>"

        }

    }).fail(function(a,b){
        $("#errores").html(error_ajax_jquery(a,b))
        $("#principal").html("")
    })
}

function volver(){
    $("#respuestas").html("")
}

// Vamos a borrar el producto sobre el que se dé click
function borrar_producto(cod) {
    $.ajax({        
        url: DIR_SERV + "/producto/borrar/" + cod,
        dataType: "json",
        type: "DELETE",
    }).done(function(data){
        if (data.mensaje_error) {
            $("#respuesta").html(data.mensaje_error)
        } else {                                    

            var mensaje = "<p class='seguridad'>Producto borrado con éxito</p>";

            // Mostramos un mensaje de borrado con éxito
            $("#mensaje").html(mensaje)

            // Ponemos esto para que no aparezcan los detalles del producto o la información si se le ha dado click antes
            $("#detallitos").html("")
            $("#informacion").html("")
            obtener_productos(); // Mostramos la tabla actualizada

        }
    })
}