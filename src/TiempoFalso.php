<?php
namespace TrabajoSube;

class TiempoFalso implements TiempoInterface 
{
    protected $tiempo; 
    protected $dias = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    protected $diaSemana; 
    protected $hora; 

    public function __construct($iniciarEn = 1){
        $this->tiempo = $iniciarEn;
        $this->diaSemana = date('l', $iniciarEn); 
        $this->hora = date('G', $this->tiempo);
    }

    public function time(){
        return $this->tiempo;
    }

    public function avanzar($segundos){
        $this->tiempo += $segundos;
        $this->diaSemana = date('l', $this->tiempo); 
        $this->hora = date('G', $this->tiempo);
    }

    public function dia(){
        return $this->diaSemana;
    }

    public function hora(){
        return $this->hora;
    }
}

?>