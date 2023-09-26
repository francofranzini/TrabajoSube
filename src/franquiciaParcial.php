<?php
namespace TrabajoSube;


class franquiciaParcial extends Tarjeta {

    public function hacerViaje($costo){
       if( $this->saldo < -$costo/2 ){
            return FALSE;
        }
        $this->saldo -= ($costo / 2);
        $this->viajes += 1;
        return TRUE; 
    }
}

?>