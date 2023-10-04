<?php
namespace TrabajoSube;

class TiempoFalso implements TiempoInterface 
{
    protected $tiempo; 
    public function __construct($iniciarEn = 1){
        $this->tiempo = $iniciarEn;
    }

    public function time(){
        return $this->tiempo;
    }

    public function avanzar($segundos){
        $this->tiempo += $segundos;
    }

}

?>