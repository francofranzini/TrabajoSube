<?php
namespace TrabajoSube;
define("SALDO_NEG ", -120);

class Tarjeta{
    public $saldo = 0;
    public $viajes = 0;
    public $cargasPosibles = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);
    

    public function cargarTarjeta($monto){
        
        if($this->saldo + $monto > 6600){
            echo "no se puede cargar ".$monto." ya que excede los 6600 pesos \n";
            return ;
        }
        if(in_array($monto, $this->cargasPosibles)){
            $this->saldo += $monto;
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
         if( $this->saldo < $SALDO_NEG ){
             echo "no se puede pagar el viaje \n";
             return FALSE;
            } 
        if ( $this->saldo < 120 ) 
            { 
            $this->viajeplus--; 
            }     
        $this->saldo -= $costo;
        $this->viajes += 1;
        return TRUE; 
    }
   // no se fran si es necesario porque si viajeplus esta declarada como public 
    //desde colectivo puedo acceder directamente desde colectivo
    // public function viajePlus(){
     //   return $this->viajeplus;
   // }
}
?>