<?php
namespace TrabajoSube;


Class franquiciaCompleta extends Tarjeta {

    protected $viajesGratis = 2; 
    
    protected $ultimoViajeGratis = 0;

    public function hacerViaje($costo) {
        $tiempoActual= $this->tiempo->time();

        // Verificar si ha pasado un día desde el último viaje
        if (intval($this->ultimoViajeGratis/86400) < intval($this->tiempo->time()/86400))  {
            // Reiniciar los viajes gratis
            $this->viajesGratis = 2;
        }

        if ($this->viajesGratis > 0) {
            // Realizar un viaje gratis
            $this->viajesGratis--;
            //Almacena cuando se hizo ese ultimo viaje
            $this->ultimoViajeGratis = $tiempoActual;
            $this->viajes += 1;
             return TRUE;
        } 
        else 
        {
            return parent::hacerViaje($costo);
        }
        
    }

    public function viajesGratis(){
        return $this->viajesGratis;
    }
}




?>