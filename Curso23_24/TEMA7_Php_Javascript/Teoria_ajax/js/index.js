// Guardamos la api que vamos a utilizar
const DIR_SERV = "http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Teoria_Servicios_Web(APIs)/primera_api/";

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

function llamada_get1() {
    $.ajax({        
        url: DIR_SERV+"/saludo",
        dataType: "json",
        type: "GET",
    }).done(function(data){
        $("#respuesta").html(data.mensaje) // Cogemos el mensaje, que en la api es $respuesta["mensaje"]
    }).fail(function(a, b){
        $("#respuesta").html(error_ajax_jquery(a, b));
    })
}

function llamada_get2() {

    var nombre = "María";

    $.ajax({        
        url: encodeURI(DIR_SERV + "/saludo/" + nombre),
        dataType: "json",
        type: "GET",
    }).done(function(data){
        $("#respuesta").html(data.mensaje) // Cogemos el mensaje, que en la api es $respuesta["mensaje"]
    }).fail(function(a, b){
        $("#respuesta").html(error_ajax_jquery(a, b));
    })
}

function llamada_post() {

    var nombre = "José";

    $.ajax({        
        url: DIR_SERV + "/saludo",
        dataType: "json",
        type: "POST",
        data:{"name":nombre}, // Lo primero es el param, y lo segundo lo que pasamos (solo cuando pasamos datos por debajo)
    }).done(function(data){
        $("#respuesta").html(data.mensaje) // Cogemos el mensaje, que en la api es $respuesta["mensaje"]
    }).fail(function(a, b){
        $("#respuesta").html(error_ajax_jquery(a, b));
    })
}

function llamada_delete() {

    var id = 5;

    $.ajax({        
        url: encodeURI(DIR_SERV + "/borrar_saludo/" + id),
        dataType: "json",
        type: "DELETE",        
    }).done(function(data){
        $("#respuesta").html(data.mensaje) // Cogemos el mensaje, que en la api es $respuesta["mensaje"]
    }).fail(function(a, b){
        $("#respuesta").html(error_ajax_jquery(a, b));
    })
}

function llamada_put() {

    var id = 5;
    var nombre = "Adrián";

    $.ajax({
        url: encodeURI(DIR_SERV + "/actualizar_saludo/" + id),
        dataType: "json",
        type: "PUT",
        data:{"nombre":nombre}
    }).done(function(data){
        $("#respuesta").html(data.mensaje) // Cogemos el mensaje, que en la api es $respuesta["mensaje"]
    }).fail(function(a, b){
        $("#respuesta").html(error_ajax_jquery(a, b));
    })
}

const DIR_SERV2 = "http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Ejercicios_Servicios_Web/Ejercicio1/servicios_rest"

function obtener_productos() {
    $.ajax({        
        url: DIR_SERV2 + "/productos",
        dataType: "json",
        type: "GET",
    }).done(function(data){
        if (data.mensaje_error) {
            $("#respuesta").html(data.mensaje_error)
        } else {

            // Vamos a crear una tabla con los productos
            var tabla_productos = "<table>";
            tabla_productos += "<tr><th>COD</th><th>Nombre corto</th><th>PVP</th></tr>"

            // Recorremos el json
            $.each(data.productos, function(key, tupla) { 
                tabla_productos += "<tr>";
                tabla_productos += "<td>" + tupla["cod"] + "</td>";       
                tabla_productos += "<td>" + tupla["nombre_corto"] + "</td>";
                tabla_productos += "<td>" + tupla["PVP"] + "</td>";
                tabla_productos += "</tr>";
            });
            tabla_productos += "</table>";
            $("#respuesta").html(tabla_productos);
        }
    })
}

$(document).ready(function () {
    
    // Nada más cargar la página quiero tener los productos
    obtener_productos()

});