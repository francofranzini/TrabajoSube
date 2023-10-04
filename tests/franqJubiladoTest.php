<?php 

namespace TrabajoSube;


use PHPUnit\Framework\TestCase;

class franqJubiladoTest extends TestCase{
    public function testViajarJubilados(){
        $tiempoFalso = new TiempoFalso();
        $colectivoTest = new Colectivo;
        $tarjetaJubilado = new franquiciaJubilados(1,$tiempoFalso);

        $tiempoFalso->avanzar(3600*8);

        $tarjetaJubilado->cargarTarjeta(150);
        $this->assertEquals(150, $tarjetaJubilado->consultarSaldo());
        $tarjetaJubilado->hacerViaje(120);
        $tarjetaJubilado->hacerViaje(120);
        $tarjetaJubilado->hacerViaje(120);
        $tarjetaJubilado->hacerViaje(120);
        $tarjetaJubilado->hacerViaje(120);
        $tarjetaJubilado->hacerViaje(120);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(150, $tarjetaJubilado->consultarSaldo());

    }

   /* public function testViajarFueraDeHorario(){
        $tiempoFalso = new TiempoFalso();
        $colectivoTest = new Colectivo;
        $tarjetaJubilado = new franquiciaJubilados(1,$tiempFalsol);
        $this->assertEquals(150, $tarjetaJubilado->consultarSaldo());
    }
    */
}