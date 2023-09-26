<?php
namespace TrabajoSube;

define("COSTO_FIJO", 0);
Class franquiciaCompleta extends Tarjeta {
    protected viajesGratis = 2; 
    //  considero que no es necesario ya que con la iteracion 3 ya no puede viajar infinito
    
    /* public function consultarSaldo(){
        return $COSTO_FIJO;
    }
    */
    /*7
    public function hacerViaje($costo){
        if ( this->viajesGratis = 0 ){
        $this->viajes += 1;
        return TRUE; 
        }
        else {
            if( $this->saldo <  -$costo){
                echo "no se puede pagar el viaje \n";
                return FALSE;
               } 
           $this->saldo -= $costo;
           $this->viajes += 1;
           return TRUE; 
        }
    }
    */
    protected $ultimoViajeGratis = 0;

    public function hacerViaje($costo) {
        $tiempoActual= time();

        // Verificar si ha pasado un día desde el último viaje
        if ($tiempoActual - $this->ultimoViajeGratis >= 24 * 60 * 60) {
            // Reiniciar los viajes gratis
            $this->viajesGratis = 2;
        }

        if ($this->viajesGratis > 0) {
            // Realizar un viaje gratis
            $this->viajesGratis--;
            //Almacena cuando se hizo ese ultimo viaje
            $this->ultimoViajeGratis = $tiempoActual;
            $this->viajes += 1;
             return true;
        } 
        else 
        {
            parent::hacerViaje($costo);
        }
        
    }
}




?>