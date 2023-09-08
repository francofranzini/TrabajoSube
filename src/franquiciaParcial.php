<?php
namespace TrabajoSube;
require 'Tarjeta.php';
define("VALOR_VIAJE_MIN", 60);

Class franquiciaParcial extends Tarjeta {

 
    public function hacerViaje($costo){
        if( $this->viajeplus == 0 ){
            echo "no se puede pagar el viaje \n";
            return FALSE;
           }
       if ( $this->saldo < VALOR_VIAJE_MIN ) 
           { 
           $this->viajeplus--; 
           }     
       $this->saldo -= ($costo/2);
       $this->viajes += 1;
      
       return TRUE; 
   }
}

?>