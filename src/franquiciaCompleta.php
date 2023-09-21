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
    
    public function hacerViaje($costo){
        if ( this->viajesGratis < 0 ){
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
}

?>