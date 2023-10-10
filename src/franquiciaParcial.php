<?php
namespace TrabajoSube;


class franquiciaParcial extends Tarjeta {
    //Almacenara la cantidad de viajes que se realizaron por día 
    protected $viajesConMedio = 4;
    protected $ultimoViajeConMedio = 0;

    public function hacerViaje($costo)
    {
        $tiempoActual= $this->tiempo->time();
        $horaActual=  $this->tiempo->hora();
        $diaActual= $this->tiempo->dia();

        if (intval($this->ultimoViajeConMedio/86400) < intval($this->tiempo->time()/86400)) {
            // Reiniciar los viajes con medio Boleto 
            $this->viajesConMedio = 4;
        }
        
        if($this->viajesConMedio == 0 || (in_array($diaActual , $this->diasSinFranquicia)) || !($horaActual<=22) || !($horaActual >= 6) ) return parent::hacerViaje($costo); 
        if(($tiempoActual - $this->ultimoViajeConMedio < 5*60 ) && $this->ultimoViajeConMedio != 0 ) return FALSE;
        $this->ultimoViajeConMedio = $tiempoActual;
        $this->viajesConMedio -= 1;
        return parent::hacerViaje($costo/2);
        
    }
    public function viajemedio(){
        return $this->viajesConMedio;
    }

}

?>