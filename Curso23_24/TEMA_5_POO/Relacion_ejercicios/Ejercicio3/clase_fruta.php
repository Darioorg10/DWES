<?php 

    class Fruta{             

        private $color, $tamanio;
        private static $n_frutas = 0; // Añadimos el contador con el static
        
        public function __construct($color, $tamanio) {
                $this->color = $color;
                $this->tamanio = $tamanio;
                self::$n_frutas++; // Para hacer referencia a algo static se utiliza el self::
        }

        /* Añadimos el destructor */
        public function __destruct()
        {
                self::$n_frutas--;
        }

        /* Creamos un método estático que nos devuelva el número de instancias */
        public static function cuantaFruta(){
                return self::$n_frutas;
        }

        public function getColor()
        {
                return $this->color;
        }

        public function setColor($color)
        {
                $this->color = $color;                
        }

        public function getTamanio()
        {
                return $this->tamanio;
        }

        public function setTamanio($tamanio)
        {
                $this->tamanio = $tamanio;                
        }        

    }        

?>