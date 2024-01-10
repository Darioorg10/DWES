<?php 

    class Pelicula{

        // Creamos los atributos
        private $nombre;
        private $anio;
        private $director;
        private $alquilada;
        private $precio;
        private $fechaDevolucion;

        // Constructor
        public function __construct($nombre, $anio, $director, $alquilada, $precio, $fechaDevolucion) {
            $this->nombre=$nombre;
            $this->anio=$anio;
            $this->director=$director;
            $this->alquilada=$alquilada;
            $this->precio=$precio;
            $this->fechaDevolucion = new DateTime($fechaDevolucion);
        }


        // Getters y setters
         function getNombre()
        {
                return $this->nombre;
        }

        public function setNombre($nombre): self
        {
                $this->nombre = $nombre;

                return $this;
        }

        public function getAnio()
        {
                return $this->anio;
        }

        public function setAnio($anio): self
        {
                $this->anio = $anio;

                return $this;
        }

        public function getDirector()
        {
                return $this->director;
        }

        public function setDirector($director): self
        {
                $this->director = $director;

                return $this;
        }

        public function getAlquilada()
        {
                return $this->alquilada;
        }

        public function setAlquilada($alquilada): self
        {
                $this->alquilada = $alquilada;

                return $this;
        }

        public function getPrecio()
        {
                return $this->precio;
        }

        public function setPrecio($precio): self
        {
                $this->precio = $precio;

                return $this;
        }

        public function getFechaDevolucion()
        {
                return $this->fechaDevolucion->format('d/m/Y');
        }

        public function setFechaDevolucion($fechaDevolucion): self
        {
                $this->fechaDevolucion = new DateTime($fechaDevolucion);

                return $this;
        }

        // Método para calcular el recargo
        public function calcularRecargo(){

        }

    }

?>