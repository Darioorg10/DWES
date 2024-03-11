const DIR_SERV="http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Ejercicios_Servicios_Web/Ejercicio1/servicios_rest";

$(document).ready(function(){
    obtener_productos();
});

function obtener_productos()
{
    $.ajax({
        url:DIR_SERV+"/productos",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#errores').html(data.mensaje_error);
            $('#respuestas').html("");
            $('#productos').html("");
        }
        else
        {
            var html_tabla_prod="<table class='centrado'>";
            html_tabla_prod+="<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><button class='enlace' onclick='montar_form_crear();'>Productos+</button></th></tr>";

            $.each(data.productos, function(key, tupla){
                html_tabla_prod+="<tr>";
                html_tabla_prod+="<td><button class='enlace' onclick='detalles(\""+tupla["cod"]+"\")'>"+tupla["cod"]+"</button></td>";
                html_tabla_prod+="<td>"+tupla["nombre_corto"]+"</td>";
                html_tabla_prod+="<td>"+tupla["PVP"]+"</td>";
                html_tabla_prod+="<td><button class='enlace' onclick='confirmar_borrar(\""+tupla["cod"]+"\");'>Borrar</button> - Editar</td>";
                html_tabla_prod+="</tr>";
            });

            html_tabla_prod+="</table>";
            $('#errores').html("");
            $('#productos').html(html_tabla_prod);
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#respuestas').html("");
        $('#productos').html("");
    });
}

function detalles(cod)
{
    $.ajax({
        url:encodeURI(DIR_SERV+"/producto/"+cod),
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#errores').html(data.mensaje_error);
            $('#respuestas').html("");
            $('#productos').html("");
        }
        else if(data.mensaje)
        {
            $('#errores').html("");
            $('#respuestas').html("<p class='mensaje'>El producto con cod: <strong>"+cod+"</strong> ya no se encuentra en la BD.</p>");
            obtener_productos();
        }
        else
        {
            $.ajax({
                url:encodeURI(DIR_SERV+"/familia/"+data.producto["familia"]),
                type:"GET",
                dataType:"json"
            })
            .done(function(data2){
                if(data2.mensaje_error)
                {
                    $('#errores').html(data2.mensaje_error);
                    $('#respuestas').html("");
                    $('#productos').html("");
                }
                else
                {
                    var html_respuesta="<h2>Información del producto: "+cod+"</h2>";
                    html_respuesta+="<p><strong>Nombre: </strong>";
                    if(data.producto["nombre"])
                        html_respuesta+=data.producto["nombre"];
                    html_respuesta+="</p>";
                    html_respuesta+="<p><strong>Nombre corto: </strong>"+data.producto["nombre_corto"]+"</p>";
                    html_respuesta+="<p><strong>Descripción: </strong>";
                    if(data.producto["descripcion"])
                        html_respuesta+=data.producto["descripcion"];
                    html_respuesta+="</p>";
                    html_respuesta+="<p><strong>PVP: </strong>"+data.producto["PVP"]+"€</p>";
                    html_respuesta+="<p><strong>Familia: </strong>";
                    if(data2.mensaje)
                        html_respuesta+="No se encuentra ninguna familia con cod: "+data.producto["familia"];
                    else
                        html_respuesta+=data2.familia["nombre"];
                    html_respuesta+="</p>";
                    html_respuesta+="<p><button onclick='volver();'>Volver</button></p>";

                    $('#respuestas').html(html_respuesta);

                }
            })
            .fail(function(a,b){
                $('#errores').html(error_ajax_jquery(a,b));
                $('#respuestas').html("");
                $('#productos').html("");
            });
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#respuestas').html("");
        $('#productos').html("");
    });
}

function confirmar_borrar(cod)
{
    html_conf_borrar="<p class='centrado'>Se dispone usted a borrar el producto: <strong>"+cod+"</strong></p>";
    html_conf_borrar+="<p class='centrado'>¿Estás Seguro?</p>";
    html_conf_borrar+="<p class='centrado'><button onclick='volver();'>Volver</button> <button onclick='borrar(\""+cod+"\")'>Continuar</button></p>";
    $('#respuestas').html(html_conf_borrar);
}

function borrar(cod)
{
    $.ajax({
        url:encodeURI(DIR_SERV+"/producto/borrar/"+cod),
        type:"DELETE",
        dataType:"json"
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#errores').html(data.mensaje_error);
            $('#respuestas').html("");
            $('#productos').html("");
        }
        else 
        {
            $('#errores').html("");
            $('#respuestas').html("<p class='mensaje'>El producto con cod: <strong>"+cod+"</strong> se ha borrado con éxito.</p>");
            obtener_productos();
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#respuestas').html("");
        $('#productos').html("");
    });
}


function montar_form_crear()
{
    $.ajax({
        url:DIR_SERV+"/familias",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#errores').html(data.mensaje_error);
            $('#respuestas').html("");
            $('#productos').html("");
        }
        else
        {
            //Si obtengo las familias monto el formulario
            var html_form_crear="<h2>Creando un producto</h2>";
            html_form_crear+="<form onsubmit='event.preventDefault();comprobar_nuevo();'>";
            html_form_crear+="<p><label for='cod'>Código: </label><input type='text' id='cod' required/><span class='error' id='error_cod'></span></p>";
            html_form_crear+="<p><label for='nombre'>Nombre: </label><input type='text' id='nombre'/></p>";
            html_form_crear+="<p><label for='nombre_corto'>Nombre Corto: </label><input type='text' id='nombre_corto' required/><span class='error' id='error_nombre_corto'></span></p>";
            html_form_crear+="<p><label for='descripcion'>Descripción: </label><textarea id='descripcion'></textarea></p>";
            html_form_crear+="<p><label for='PVP'>PVP: </label><input type='number' id='PVP' min='0.01' step='0.01' required/></p>";
            html_form_crear+="<p><label for='familia'>Seleccione una familia: </label>";
            html_form_crear+="<select id='familia'>";
            $.each(data.familias, function(key, tupla){
                html_form_crear+="<option value='"+tupla["cod"]+"'>"+tupla["nombre"]+"</option>"
            });
            html_form_crear+="</select></p>";
            html_form_crear+="<p><button onclick='event.preventDefault();volver();'>Volver</button>";
            html_form_crear+="<button>Continuar</button></p>"

            html_form_crear+="</form>"; 

            $('#respuestas').html(html_form_crear);
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#respuestas').html("");
        $('#productos').html("");
    });
}


function comprobar_nuevo()
{
    $('#error_cod').html("");
    $('#error_nombre_corto').html("");


    var cod=$('#cod').val();
    var nombre_corto=$('#nombre_corto').val();
    $.ajax({
        url:encodeURI(DIR_SERV+"/repetido/producto/cod/"+cod),
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#errores').html(data.mensaje_error);
            $('#respuestas').html("");
            $('#productos').html("");
        }
        else if(data.repetido)
        {
            //Informo código repetido y compruebo también nombre corto  pero ya no inserto
            $('#error_cod').html("Código repetido");

            $.ajax({
                url:encodeURI(DIR_SERV+"/repetido/producto/nombre_corto/"+nombre_corto),
                type:"GET",
                dataType:"json"
            })
            .done(function(data){
                if(data.mensaje_error)
                {
                    $('#errores').html(data.mensaje_error);
                    $('#respuestas').html("");
                    $('#productos').html("");
                }
                if(data.repetido)
                {
                    $('#error_nombre_corto').html("Nombre corto repetido");
                }
            })
            .fail(function(a,b){
                $('#errores').html(error_ajax_jquery(a,b));
                $('#respuestas').html("");
                $('#productos').html("");
            });
        }
        else
        {
            //Compruebo nombre corto y si está repetido informo y no inserto, pero si no está repetido inserto
            $.ajax({
                url:encodeURI(DIR_SERV+"/repetido/producto/nombre_corto/"+nombre_corto),
                type:"GET",
                dataType:"json"
            })
            .done(function(data){
                if(data.mensaje_error)
                {
                    $('#errores').html(data.mensaje_error);
                    $('#respuestas').html("");
                    $('#productos').html("");
                }
                if(data.repetido)
                {
                    $('#error_nombre_corto').html("Nombre corto repetido");
                }
                else
                {
                    var nombre=$('#nombre').val();
                    var descripcion=$('#descripcion').val();
                    var PVP=$('#PVP').val();
                    var familia=$('#familia').val();

                    $.ajax({
                        url:DIR_SERV+"/producto/insertar",
                        type:"POST",
                        dataType:"json",
                        data:{"cod":cod, "nombre":nombre, "nombre_corto":nombre_corto, "descripcion":descripcion, "PVP":PVP, "familia":familia}
                    })
                    .done(function(data){
                        if(data.mensaje_error)
                        {
                            $('#errores').html(data.mensaje_error);
                            $('#respuestas').html("");
                            $('#productos').html("");
                        }
                        else
                        {
                            $('#respuestas').html("<p class='mensaje'>El producto con cod: <strong>"+cod+"</strong> se ha insertado con éxito<p>");
                            obtener_productos();
                        }

                    })
                    .fail(function(a,b){
                        $('#errores').html(error_ajax_jquery(a,b));
                        $('#respuestas').html("");
                        $('#productos').html("");
                    });
                }
            })
            .fail(function(a,b){
                $('#errores').html(error_ajax_jquery(a,b));
                $('#respuestas').html("");
                $('#productos').html("");
            });

        }

    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#respuestas').html("");
        $('#productos').html("");
    });
}


function volver()
{
    $('#respuestas').html("");
}


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