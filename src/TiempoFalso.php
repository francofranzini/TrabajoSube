<?php
namespace TrabajoSube;

class TiempoFalso implements TiempoInterface 
{
    protected $tiempo; 
    protected $mes; 

    public function __construct($iniciarEn = 1){
        $this->tiempo = $iniciarEn;
    }

    public function time(){
        return $this->tiempo;
    }

    public function avanzar($segundos){
        $this->tiempo += $segundos;
        $this->mes = date('F', $this->tiempo);
    }
   
    public function avanzarDias($dias){
        $this->avanzar($dias*24*60*60);    
    }
    
    public function mes(){
        return $this->mes;
    }

}

?>

