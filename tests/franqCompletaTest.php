<?php 

namespace TrabajoSube;



use PHPUnit\Framework\TestCase;

class franqCompletaTest extends TestCase{

    public function testProbarViaje(){
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new franquiciaCompleta(1,$tiempoReal);
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
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new franquiciaCompleta(1,$tiempoReal);
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
        
        $tarjetaTest->cargarTarjeta(600);
        for ($i = 0; $i < 6; $i++) {
            $tarjetaTest->hacerViaje(120);
            $tiempoFalso->avanzar(300);
           
        }
        //En menos de 24 horas no se puede viajar 
        $this->assertEquals(120, $tarjetaTest->consultarSaldo());
    }
}       
?>