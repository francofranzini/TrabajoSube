<?php
namespace TrabajoSube;

define("COSTO_FIJO", 0);
Class franquiciaCompleta extends Tarjeta {

    public function consultarSaldo(){
        return $COSTO_FIJO;
    }
    public function hacerViaje($costo){
        $this->viajes += 1;
        return TRUE; 
    }
}

?>