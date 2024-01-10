<?php 

    class Fruta{             

        private $color, $tamanio;
        private static $n_frutas = 0;
        
        public function __construct($color, $tamanio) {
                $this->color = $color;
                $this->tamanio = $tamanio;
                self::$n_frutas++;
        }
        
        public function __destruct()
        {
                self::$n_frutas--;
        }
        
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