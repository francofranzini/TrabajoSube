<?php
namespace TrabajoSube;

interface TiempoInterface {
    public function time();

}

class TiempoReal implements TiempoInterface 
{
    public function time(){
        return time();
    }
}

class TiempoFalso implements TiempoInterface 
{
    protected $tiempo; 
    public function __construct($iniciarEn = 0){
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