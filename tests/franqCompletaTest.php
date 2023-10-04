<?php 

namespace TrabajoSube;



use PHPUnit\Framework\TestCase;

class franqCompletaTest extends TestCase{

    public function testProbarViaje(){
        $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaCompleta(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);
        $this->assertEquals(1, $tarjetaTest->getID());
        $tarjetaTest->cargarTarjeta(150);
        //Verificamos si puede viajar 1 vez
        $this->assertEquals(TRUE, $tarjetaTest->hacerViaje(120));
        
        //Verificamos que si puede viajar 2 veces
        $this->assertEquals(TRUE, $tarjetaTest->hacerViaje(120));
        $this->assertEquals(150, $tarjetaTest->consultarSaldo());
        //Verificamos que puede viajar 3 veces, pero ahora pago del saldo
        $this->assertEquals(TRUE, $tarjetaTest->hacerViaje(120));
        $this->assertEquals(30, $tarjetaTest->consultarSaldo());
    }
    public function testPagarViajes(){
        $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaCompleta(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);

        $tarjetaTest->cargarTarjeta(150);
        $tarjetaTest->hacerViaje(120);
        $tarjetaTest->hacerViaje(120);
        $tarjetaTest->hacerViaje(120);
        //verificamos que haya viajado 2 veces y luego con tarifa normal
        $this->assertEquals(30, $tarjetaTest->consultarSaldo());
    }

    public function testPasoDelDia(){
        $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaCompleta(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);
        $tarjetaTest->cargarTarjeta(600);
        for ($i = 0; $i < 6; $i++) {
            $tarjetaTest->hacerViaje(120);
            $tiempoFalso->avanzar(300);
           
        }
        //En menos de 24 horas no se puede viajar 
        $this->assertEquals(120, $tarjetaTest->consultarSaldo());
    }

    public function testViajarCasiMedianoche(){
        $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaCompleta(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);

        $ct = new Colectivo(144);
        
        $tarjetaTest->cargarTarjeta(600);
        //Saldo = 600, viajesgratis = 2
        $tarjetaTest->hacerViaje($ct->tarifa());
        //Saldo = 600, viajesgratis = 1
       
        $this->assertEquals(600, $tarjetaTest->consultarSaldo());
        $this->assertEquals(1, $tarjetaTest->viajesGratis());
        $this->assertEquals(TRUE, $tarjetaTest->hacerViaje($ct->tarifa()));
        //Saldo = 480, viajesGratis = 0
        $tiempoFalso->avanzar(300);
        
        $tarjetaTest->hacerViaje($ct->tarifa());
        //Saldo = 480 por hacer viajes sin viajes gratis tarifa normal
        $this->assertEquals(0, $tarjetaTest->viajesGratis());
        $this->assertEquals(480, $tarjetaTest->consultarSaldo());
        //PASAMOS LA MEDIANOCHE
        $tiempoFalso->avanzar(3600*24);
        //Al hacer el siguiente viaje, viajesGratis = 2, pero como viajamos, 1.
        $tarjetaTest->hacerViaje($ct->tarifa());
        $this->assertEquals(1, $tarjetaTest->viajesGratis());
        
    }
    public function testViajarFueraDeHorario(){
        $tiempoFalso = new TiempoFalso();
        $colectivoTest = new Colectivo;
        $tarjetaJubilado = new franquiciaCompleta(1,$tiempoFalso);
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
        $tarjetaJubilado = new franquiciaCompleta(1,$tiempoFalso);
        
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
?>