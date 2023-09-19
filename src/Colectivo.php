<?php
namespace TrabajoSube;

class Colectivo{

    protected $tarifa = 120;
    protected $linea;

    /*public function __construct(int $linea) {
        $this->linea = $linea;
    }
    */
    public function linea(){
        return $this->linea;
    }

    function pagarCon($tarjeta){
        if($tarjeta->consultarSaldo()>= $this->tarifa){
            $tarjeta->hacerViaje($this->tarifa);
        }else{
            echo "No tiene saldo suficiente";
            return;
        }
    }
}

?>