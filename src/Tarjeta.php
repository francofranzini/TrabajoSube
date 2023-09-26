<?php
namespace TrabajoSube;


class Tarjeta{
    protected $saldo = 0;
    protected $viajes = 0;
    protected $id;
    protected $saldoNegativo;
    protected $cargasPosibles = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);
    protected $cargasPendientes= 0;

    public function __construct(int $id = -1) {
        $this->id = $id;
    }

    public function getID(){
        return $this->id;
    }

    public function cargarTarjeta($monto){
        /*
        if($this->saldo + $monto > 6600){
            return ;
        }*/
        if(in_array($monto, $this->cargasPosibles)){
            if($this->saldo + $monto > 6600){
                $this->$cargasPendientes=  ($this->saldo + $monto)-6600 
            
            /* falta terminar */    
          
          
            return ;
        }else{
            echo "no se puede cargar ese monto! \n";
        }
    }


    public function consultarSaldo(){
        return $this->saldo;
    }

    public function consultarViajes(){
        return $this->viajes;
    }

    public function hacerViaje($costo){
         if( $this->saldo <  -$costo){
             echo "no se puede pagar el viaje \n";
             return FALSE;
            } 
        $this->saldo -= $costo;
        $this->viajes += 1;
        return TRUE; 
    }
  
}
?>