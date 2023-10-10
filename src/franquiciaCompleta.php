<?php
namespace TrabajoSube;


Class franquiciaCompleta extends Tarjeta {

    protected $viajesGratis = 2; 
    
    protected $ultimoViajeGratis = 0;

    public function hacerViaje($costo) {
        $tiempoActual= $this->tiempo->time();
        $horaActual=  $this->tiempo->hora();
        $diaActual= $this->tiempo->dia();
        // Verificar si ha pasado un día desde el último viaje
        if (intval($this->ultimoViajeGratis/86400) < intval($this->tiempo->time()/86400))  {
            // Reiniciar los viajes gratis
            $this->viajesGratis = 2;
        }
        
        if ($this->viajesGratis > 0 && !(in_array($diaActual , $this->diasSinFranquicia))&& $horaActual<=22 && $horaActual >= 6  )
         {
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