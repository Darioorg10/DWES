<?php 
    
    class Menu{
        
        private $enlaces = array();

        // Creamos el método cargar
        public function cargar($url, $nombre){
            $this->enlaces[$nombre] = $url;
        }

        // Creamos el método que nos pone el menú en vertical
        public function vertical(){
            echo "<p>";
            foreach ($this->enlaces as $nombre => $url) {
                echo "<a href='$url'>$nombre</a><br>";

            }
            echo "</p>";
        }

        // Creamos el método que nos pone el menú en horizontal
        public function horizontal(){
            $imprimir = "";
            foreach ($this->enlaces as $nombre => $url) {
                $imprimir.="<a href='$url'>$nombre</a> - ";
            }
            echo "<p>".substr($imprimir, 0, -2)."</p>";
        }
        
    }

?>