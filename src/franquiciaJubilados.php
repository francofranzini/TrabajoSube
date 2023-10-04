<?php
namespace TrabajoSube;


Class franquiciaJubilados extends Tarjeta {
    public function hacerViaje($costo){
        if((in_array($diaActual , $this->diasSinFranquicia)) || !($horaActual<=22) || !($horaActual >= 6) ) return parent::hacerViaje($costo); 
       
        $this->viajes ++;
        return TRUE;
    }

}




?>