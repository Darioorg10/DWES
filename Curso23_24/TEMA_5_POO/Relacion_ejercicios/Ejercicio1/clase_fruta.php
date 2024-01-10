<?php 

    class Fruta{             

        private $color; // Para declarar las dos se podría poner private $color, $tamanio
        private $tamanio;

        /* Getters y setters */
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