<?php
namespace TrabajoSube;
require 'Tarjeta.php';
require 'Boleto.php';

class Colectivo{

    public $tarifa = 120;

    function pagarCon($tarjeta){
        if($tarjeta->consultarSaldo()>= $this->tarifa){
            $tarjeta->hacerViaje($this->tarifa);
        }else{
            echo "No tiene saldo suficiente";
            return;
        }
    }
}