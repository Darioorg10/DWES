<?php 

    class Empleado{

        private $nombre;
        private $sueldo;

        // Constructor
        public function __construct($nombre, $sueldo) {
            $this->nombre = $nombre;
            $this->sueldo = $sueldo;
        }

        // Getters y setters
        public function getNombre()
        {
                return $this->nombre;
        }

        public function setNombre($nombre): self
        {
                $this->nombre = $nombre;

                return $this;
        }

        public function getSueldo()
        {
                return $this->sueldo;
        }

        public function setSueldo($sueldo): self
        {
                $this->sueldo = $sueldo;

                return $this;
        }

        // Método que imprima el nombre y un mensaje si debe pagar o no impuestos
        public function impuestos(){
            if ($this->getSueldo() > 3000) {
                echo "<p>El empleado <strong>".$this->getNombre()."</strong> con un sueldo de <strong>".$this->sueldo."€</strong> debe pagar impuestos</p>";
            } else {
                echo "<p>El empleado <strong>".$this->getNombre()."</strong> con un sueldo de <strong>".$this->sueldo."€</strong> no debe pagar impuestos</p>";
            }
        }

    }

?>