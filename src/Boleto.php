<?php
namespace TrabajoSube;

class Boleto{
    private $fecha;
    protected $saldo;
    protected $tipo;
    protected $id;
    protected $linea;
  
    public function fecha(){
        return $this->fecha;
    }

    public function __construct(Tarjeta $tarjeta, Colectivo $colectivo ){
        $this->saldo = $tarjeta->consultarSaldo();
        $this->tipo = get_class($tarjeta);
        $this->linea = $colectivo->linea();
        $this->id = $tarjeta->getID();
        $this->fecha = date('d-m-Y', time());
    }

    public function id(){
        return $this->id;
    }

    public function saldoRestante(){
        return $this->saldo;
    }
    public function tipoDeTarjeta(){
        return $this->tipo;
    }
    public function lineaColectivo(){
        return $this->linea;
    }
    public function retornarBoleto(){
        echo([$this->fecha, $this->tipo, $this->id, $this->saldo, $this->linea,]);
    }

}

?>