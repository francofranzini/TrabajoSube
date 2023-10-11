<?php
namespace TrabajoSube;

class Colectivo{

    protected $tarifa = 120;
    protected $linea;

    public function __construct(int $linea = -1) {
        $this->linea = $linea;
    }
    public function linea(){
        return $this->linea;
    }
    public function tarifa(){
        return $this->tarifa;
    }

    public function pagarCon($tarjeta){
       
        if($tarjeta->hacerViaje($this->tarifa)){
            $boleto = new Boleto($tarjeta, $this);
        };
    }
}

?>