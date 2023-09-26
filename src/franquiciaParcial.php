<?php
namespace TrabajoSube;


class franquiciaParcial extends Tarjeta {
    //Almacenara la cantidad de viajes que se realizaron por día 
    protected $viajesMedioBoleto = 4;
    protected $ultimoViajeConMedio = 0;

    public function hacerViaje($costo)
    {
        $tiempoActual= time();
        if ($tiempoActual - $this->ultimoViajeConMedio >= 24 * 60 * 60) {
            // Reiniciar los viajes con medio Boleto 
            $this->viajesConMedio = 4;
        }
        if($this->viajesConMedio == 0) return parent::hacerViaje($costo); 
        if($tiempoActual - $this->ultimoViajeConMedio < 5*60) return FALSE;
        return parent::hacerViaje($costo/2);
        
    }

}

?>