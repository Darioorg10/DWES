<?php
class Producto
{
    private $precio;
    private $nombre;
    
    public function __construct(Type $var = null) {
        $this->var = $var;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    
}

$algo = new Producto();