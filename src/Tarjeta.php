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
    //Almacena los dias que no se podra utilizar la franquicia
    protected $diasSinFranquicia = array( "Saturday", "Sunday");
    
    protected $mesDeUso; //Almacena el ultimo mes en el que se uso la tarjeta 

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

    public function consultarCargasPendientes(){
        return $this->cargasPendientes;
    } 

    public function hacerViaje($costo){

        if( $this->saldo <  -$costo){
            echo "no se puede pagar el viaje \n";
            return FALSE;
        } 

        $claseActual = get_class($this);
      //  echo "soy $claseActual ";
        if ($claseActual == 'TrabajoSube\Tarjeta') 
        {   
            $this->reiniciarViajes();
            $this->usarDescuento($costo);
        }
        else
        {   
            $this->saldo -= $costo;
        }

        if($this->cargasPendientes > 0){
            $this->saldo += $this->cargasPendientes;
            if($this->saldo >= 6600){
                $dif = $this->saldo - 6600;
                if($dif > 0) $this->saldo -= $dif;
                $this->cargasPendientes = $dif;
            }
        }
 
        $this->viajes += 1;
        return TRUE; 
    }

    public function usarDescuento($costo){
        $mesActual = $this->tiempo->mes();
        if( $this->viajes < 29  )
            {
                $this->saldo -= $costo;
            }
        
        else {
            if($this->viajes < 80) {
            $this->saldo -= ($costo*0.8);
            } 
           else{
                $this->saldo -= ($costo*0.75);
            } 
        }

      

        $this->mesDeUso = $mesActual;
    }

    public function reiniciarViajes(){
    
        $mesActual = $this->tiempo->mes();
        if($this->mesDeUso != $mesActual)
        {
            $this->viajes = 0;
        }
    }
}
?>