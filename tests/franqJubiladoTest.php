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

   public function testViajarFueraDeHorario(){
        $tiempoFalso = new TiempoFalso();
        $colectivoTest = new Colectivo;
        $tarjetaJubilado = new franquiciaJubilados(1,$tiempoFalso);
        //Seteamos el tiempo a la 5 de la mañana es decir paga el boleto normal
        $tiempoFalso->avanzar(3600*5);
        $tarjetaJubilado->cargarTarjeta(150);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(30, $tarjetaJubilado->consultarSaldo());

        //Avanzamos 5 horas mas por lo que son las 10 de la mañana se puede viajar gratis 
        $tiempoFalso->avanzar(3600*5);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(30, $tarjetaJubilado->consultarSaldo());

        //Avanzamos 13 horas por lo que seran las 23hs por lo que tendra que pagar el boleto 
        //Tendra que tener -90
        $tiempoFalso->avanzar(3600*13);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(-90, $tarjetaJubilado->consultarSaldo());
    }

    //Test para verificar que no viaje un sabado o un domingo
    public function testViajarSabDom(){
        $tiempoFalso = new TiempoFalso();
        $colectivoTest = new Colectivo;
        $tarjetaJubilado = new franquiciaJubilados(1,$tiempoFalso);
        
        // Puede viajar gratis son las 8 am de un jueves 
        $tiempoFalso->avanzar(3600*8);
        $tarjetaJubilado->cargarTarjeta(150);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(150, $tarjetaJubilado->consultarSaldo());

        //Tendra que pagar porque son las 8 de la mañana del Sabado 
        // ==> saldo = 30 
        $tiempoFalso->avanzar(86400*2);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(30, $tarjetaJubilado->consultarSaldo());

         //Tendra que pagar porque son las 8 de la mañana del Domingo 
        // ==> saldo = -90 
        $tiempoFalso->avanzar(86400);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(-90, $tarjetaJubilado->consultarSaldo());

    }
    
}