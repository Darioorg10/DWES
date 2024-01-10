<?php 

    require "clase_fruta.php";

    // Creamos la clase uva que hereda de Fruta
    class Uva extends Fruta{

        private $tieneSemilla; // Agregamos el atributio tieneSemilla

        // Constructor
        public function __construct($color, $tamanio, $tiene) {
            $this->tieneSemilla = $tiene;
            parent::__construct($color, $tamanio); // Esto es el equivalente al super
        }

        // Creamos el método que nos devuelve el valor del atributo tieneSemilla (es igual que un getter pero con el nombre cambiado)
        public function tieneSemilla(){
            return $this->tieneSemilla;
        }
        

    }

?>