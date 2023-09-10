<?php
namespace TrabajoSube;
require 'Tarjeta.php';
define("VALOR_VIAJE_MIN", 60);
define("SALDO_NEG ", -60);

Class franquiciaParcial extends Tarjeta {


    public function hacerViaje($costo){
       if( $this->saldo < $SALDO_NEG ){
            echo "no se puede pagar el viaje \n";
            return FALSE;
           }
     
       $this->saldo -= ($costo/2);
       $this->viajes += 1;
      
       return TRUE; 
   }
}

?>