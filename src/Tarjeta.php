<?php
namespace TrabajoSube;


class Tarjeta{
    protected $saldo = 0;
    protected $viajes = 0;
    protected $id;
    protected $saldoNegativo;
    protected $cargasPosibles = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);
    protected $cargasPendientes= 0;
    protected $tiempo; 
   
    public function __construct(int $id = -1, TiempoInterface $tiempo ) {
        $this->id = $id;
        $this->tiempo  = $tiempo;
    }

    public function getID(){
        return $this->id;
    }

    public function cargarTarjeta($monto){
        if(in_array($monto, $this->cargasPosibles)){
            if($this->saldo == 6600) $this->cargasPendientes += $monto;
            if($this->saldo < 6600){
                $this->saldo += $monto;
                if($this->saldo > 6600){
                    $this->cargasPendientes = $this->saldo - 6600;
                    $this->saldo -= $this->cargasPendientes;
                }
            }

            /*else{
                echo "el saldo a cargar excede el maximo de 6600";
            }*/
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
       
        if($this->cargasPendientes > 0){
            $this->cargasPendientes -= $costo;         
        }
        else{
            $this->saldo -= $costo;
        }

        $this->viajes += 1;
        return TRUE; 
    }
  
}
?>