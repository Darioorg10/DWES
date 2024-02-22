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
            let tabla_productos = "<table>";
            tabla_productos += "<tr><th>COD</th><th>Nombre corto</th><th>PVP</th><th>Acción</th></tr>"

            // Recorremos el json
            $.each(data.productos, function(key, tupla) { 
                tabla_productos += "<tr>";
               //`<td><button class='enlace clickar' onclick='obtener_detalles("${tupla["cod"]}")'>  ${tupla["cod"]}  </button></td>`"               
                tabla_productos += `<td><button name='btnDetalles' class='enlace' onclick='obtener_detalles("${tupla.cod}")'>  ${tupla.cod}  </button></td>`;
                tabla_productos += "<td>" + tupla["nombre_corto"] + "</td>";
                tabla_productos += "<td>" + tupla["PVP"] + "</td>";
                tabla_productos += `<td><button name='btnBorrar' class='enlace' onclick='borrar_producto("${tupla.cod}")'>Borrar</button> - <button class='enlace'>Editar</button></td>`;
                tabla_productos += "</tr>";
            });
            tabla_productos += "</table>";
            $("#respuesta").html(tabla_productos);
        }
    })
}

// Vamos a mostrar la información del producto sobre el que se dé click
function obtener_detalles(cod) {
    $.ajax({        
        url: DIR_SERV + "/producto/" + cod,
        dataType: "json",
        type: "GET",
    }).done(function(data){
        if (data.mensaje_error) {
            $("#respuesta").html(data.mensaje_error)
        } else {            

            // Que no se muestren mensajes si se han puesto
            $("#mensaje").html("")

            // Vamos a crear una tabla con los productos
            var detalles = "<strong>INFORMACIÓN DEL PRODUCTO: </strong>" + data.producto[0].cod;
            $("#detallitos").html(detalles);

            var info = "";            
            info += "<p><strong>Nombre:</strong> " + (data.producto[0].nombre ?? "") + "</p>"; // Lo del ?? sirve por si no existe (es null), para que aparezca vacío en vez de null
            info += "<p><strong>Nombre corto:</strong> " + data.producto[0].nombre_corto + "</p>";
            info += "<p><strong>Descripción:</strong> " + data.producto[0].descripcion + "</p>";
            info += "<p><strong>PVP:</strong> " + data.producto[0].PVP + "</p>";

            $("#informacion").html(info)            

        }
    })
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

$(document).ready(function () {
    
    // Nada más cargar la página quiero tener los productos
    obtener_productos();

});