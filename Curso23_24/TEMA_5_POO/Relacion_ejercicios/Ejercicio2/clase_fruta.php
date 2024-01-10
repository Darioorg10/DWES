<?php 

    class Fruta{             

        private $color, $tamanio;        

        /* Añadimos ahora el constructor */
        public function __construct($color, $tamanio) {
                $this->color = $color;
                $this->tamanio = $tamanio;
                $this->imprimir();
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

        /* Hacemos el método para imprimir */
        private function imprimir(){
                echo "<h2>Información de mi fruta</h2>";
                echo "<p><strong>Color: </strong>".$this->color."</p>"; // Se puede llamar así, o con el get como abajo
                echo "<p><strong>Tamaño: </strong>".$this->getTamanio()."</p>";
        }

    }        

?>