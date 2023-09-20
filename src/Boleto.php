<?php
namespace TrabajoSube;

class Boleto{
    private $hoy;
    protected $tarjeta;
    protected $saldo;
    protected $tipo;
    protected $id;
    protected $linea;

    public function fecha(){
        return $this->hoy;
    }

    public function __construct(Tarjeta $tarjeta, Colectivo $colectivo ){
        $this->tarjeta = $tarjeta;
        $this->saldo = $tarjeta->consultarSaldo();
        $this->tipo = $this->tipoDeTarjeta($tarjeta);
        $this->linea = $colectivo->linea();
        $this->id = $tarjeta->getID();
        $this->fecha = date('d-m-Y', time());
    }

    public function saldoRestante($tarjeta){
        return $tarjeta->consultarSaldo();
    }
    public function tipoDeTarjeta($tarjeta){
        return get_class($tarjeta);
    }
    public function lineaColectivo($colectivo){
        return $colectivo->getLinea();
    }
    public function retornarBoleto(){
        return array([$this->fecha, $this->tipo, $this->id, $this->saldo, $this->linea,]);
    }

}

?>