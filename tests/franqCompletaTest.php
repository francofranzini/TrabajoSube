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
}       
?>