<?php
namespace TrabajoSube;
require 'Tarjeta.php';


Class franquiciaParcial extends Tarjeta {


    public function hacerViaje($costo){
       if( $this->saldo < -$costo/2 ){
            echo "no se puede pagar el viaje \n";
            return FALSE;
           }
     
       $this->saldo -= ($costo/2);
       $this->viajes += 1;
      
       return TRUE; 
   }
}

?>