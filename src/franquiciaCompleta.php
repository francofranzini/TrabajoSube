<?php
namespace TrabajoSube;


Class franquiciaCompleta extends Tarjeta {

    public function hacerViaje($costo){
        $this->viajes += 1;
        return TRUE; 
    }
}

?>