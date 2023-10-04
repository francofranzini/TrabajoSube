<?php
namespace TrabajoSube;


Class franquiciaJubilados extends Tarjeta {
    public function hacerViaje($costo){
        $this->viajes ++;
        return TRUE;
    }
}




?>