<?php
namespace TrabajoSube;


class franquiciaParcial extends Tarjeta {
    //Almacenara la cantidad de viajes que se realizaron por día 
    protected $viajesConMedio = 4;
    protected $ultimoViajeConMedio = 0;

    public function hacerViaje($costo)
    {
        $tiempoActual= $this->tiempo->time();
        if ($tiempoActual - $this->ultimoViajeConMedio >= 24 * 60 * 60) {
            // Reiniciar los viajes con medio Boleto 
            $this->viajesConMedio = 4;
        }
        if($this->viajesConMedio == 0) return parent::hacerViaje($costo); 
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