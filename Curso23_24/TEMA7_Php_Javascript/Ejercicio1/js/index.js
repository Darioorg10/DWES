const DIR_SERV = "http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Ejercicios_Servicios_Web/Ejercicio1/servicios_rest"

// Vamos a hacer la tabla con los productos
function obtener_productos() {
    $.ajax({        
        url: DIR_SERV + "/productos",
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
               //`<td><button class='enlace clickar' onclick='obtener_detalles("${tupla["cod"]}")'>  ${tupla["cod"]}  </button></td>`"               
                tabla_productos += <td><button class='enlace' onclick='obtener_detalles(\""+tupla["cod"]+"\")'> tupla["cod"] + "</button></td>;
                tabla_productos += "<td>" + tupla["nombre_corto"] + "</td>";
                tabla_productos += "<td>" + tupla["PVP"] + "</td>";
                tabla_productos += "</tr>";
            });
            tabla_productos += "</table>";
            $("#respuesta").html(tabla_productos);
        }
    })
}

// Vamos a hacer la tabla con los productos
function obtener_detalles(cod) {
    $.ajax({        
        url: DIR_SERV + "/producto/" + cod,
        dataType: "json",
        type: "GET",
    }).done(function(data){
        if (data.mensaje_error) {
            $("#respuesta").html(data.mensaje_error)
        } else {

            // Vamos a crear una tabla con los productos
            var detalles = "<strong>COD:</strong>";
            $("#detallitos").html(detalles);
        }
    })
}

$(document).ready(function () {
    
    // Nada más cargar la página quiero tener los productos
    obtener_productos();

});