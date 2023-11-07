var anterior = 0; // 0 es false y 1 es true
var actual = 1;
var secuencia = "";
function temporizador() {
    if (!anterior) { // Esto es solo para que el primero no te ponga guión
        secuencia += " " + actual;
    } else {
        secuencia += " - " + actual;
    }
    postMessage(secuencia);
    aux = anterior + actual; // Este es el siguiente (el de antes más el de hora)
    anterior = actual; // Para hacer la próxima llamada el "anterior" será el que ahora es el actual
    actual = aux;
    setTimeout("temporizador()", 500); // Llamamos a la función cada 500ms
}
temporizador();