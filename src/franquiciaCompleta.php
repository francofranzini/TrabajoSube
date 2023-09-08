<?php
namespace TrabajoSube;
require 'Tarjeta.php';
define("COSTO_FIJO", 150);
Class franquiciaCompleta extends Tarjeta {

    public function consultarSaldo(){
        return COSTO_FIJO;
    }
    public function hacerViaje($costo){
        $this->viajes += 1;
        return TRUE; 
    }
}

?>