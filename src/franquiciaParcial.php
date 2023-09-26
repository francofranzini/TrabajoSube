<?php
namespace TrabajoSube;


class franquiciaParcial extends Tarjeta {
    //Almacenara la cantidad de viajes que se realizaron por día 
    protected viajesMedioBoleto = 4; 
    protected $ultimoViajeConMedio = 0;

    public function hacerViaje($costo)
    {
        $tiempoActual= time();
        if ($tiempoActual - $this->ultimoViajeConMedio >= 24 * 60 * 60) {
            // Reiniciar los viajes con medio Boleto 
            $this->viajesConMedio = 4;
        }

        //Confirma si tenes medios boletos disponibles 
        // y tambien si pasaron 5 minutos de su ultimo uso 
        if($this->viajesConMedio > 0 && $tiempoActual - $this->ultimoViajeConMedio >= 5 * 60)
        {   // esto segun lo que dijo mauri no sé si es legal 
            $this->ultimoViajeConMedio = $tiempoActual; 
           return viajarConMedioBoleto($costo);
        }
        else
        {
            parent::hacerViaje($costo);
        }
    }

    public function viajarConMedioBoleto($costo){
        if( $this->saldo < -$costo/2 ){
            echo "no se puede pagar el viaje \n";
            return FALSE;
        }
        $this->saldo -= ($costo / 2);
        $this->viajes += 1;
        return TRUE; 
    }


}

?>