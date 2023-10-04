<?php 

namespace TrabajoSube;


use PHPUnit\Framework\TestCase;

class franqJubiladoTest extends TestCase{
    public function testViajarJubilados(){
        $tiempoReal = new TiempoReal();
        $colectivoTest = new Colectivo;
        $tarjetaJubilado = new franquiciaJubilados(1,$tiempoReal);

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
}