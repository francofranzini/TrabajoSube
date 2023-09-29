<?php 

namespace TrabajoSube;


use PHPUnit\Framework\TestCase;

class franquiciaParcialTest extends TestCase{

    public function testBoletoMitadPrecio(){
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new franquiciaParcial(1,$tiempoReal);
        $colectivoTest = new Colectivo;

        $tarjetaTest->cargarTarjeta(150);
        $this->assertEquals(150, $tarjetaTest->consultarSaldo());

        $colectivoTest->pagarCon($tarjetaTest);
        //De ser 90 el saldo entonces el viaje salio la mitad del boleto general 
        $this->assertEquals(90, $tarjetaTest->consultarSaldo());

        $colectivoTest->pagarCon($tarjetaTest);
        //no deberia viajar puesto que no pasaron 5min
        $this->assertEquals(90, $tarjetaTest->consultarSaldo());
    }
    
    public function testProbarViajePlus(){
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new franquiciaParcial(1,$tiempoReal);
        
        $tarjetaTest->cargarTarjeta(150);
        
        //Realizamos 3 viaje 
        for ($i = 0; $i < 4; $i++) {
            $tarjetaTest->hacerViaje(120);
            //primer viaje -> 60
            //segudno viaje -> noviaja uoop 60
            //tercerviaje -> noviaja dou 60
        }

        //Si el saldo es 90, solo se hizo un viaje (150 - 120/2 = 90)
        $this->assertEquals(90, $tarjetaTest->consultarSaldo());
        //Verifica que se realizaron 1 viajes
        $this->assertEquals(1, $tarjetaTest->consultarViajes());

        //Verifica que no pueda realizar mas viajes 
        $this->assertEquals(FALSE, $tarjetaTest->hacerViaje(120));
    }

    public function testProbarTiempoViajePlus(){
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new franquiciaParcial(1,$tiempoFalso);
        $tarjetaTest->cargarTarjeta(150);
        //Realizo un viaje 
        //$tiempoFalso->avanzar(120);
        $tarjetaTest->hacerViaje(120);
        $this->assertEquals(90, $tarjetaTest->consultarSaldo());
        //Avanzo el tiempo
        $tiempoFalso->avanzar(120);
        //No pasan mas de 5 minutos no se puede viajar 
        $this->assertEquals(FALSE, $tarjetaTest->hacerViaje(120));

        $tiempoFalso->avanzar(500);
        //Se puede viajar porque ya pasaron mas de 5 minutos 
        $this->assertEquals(TRUE, $tarjetaTest->hacerViaje(120));
        // En este caso no ya que no paso el tiempo 
        $this->assertEquals(FALSE, $tarjetaTest->hacerViaje(120));
        
        $tiempoFalso->avanzar(300);
        //Aca ya si porque el tiempo volvio a avanzar
        $this->assertEquals(TRUE, $tarjetaTest->hacerViaje(120));
       
    }

    public function testLimiteViajesPlus(){
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new franquiciaParcial(1,$tiempoFalso);
        
        $tarjetaTest->cargarTarjeta(600);
        
        //Realizamos 5 viaje 
        for ($i = 0; $i < 6; $i++) {
            $tarjetaTest->hacerViaje(120);
            $tiempoFalso->avanzar(300);
           
        }
        //Verificamos que luego de realizar 4 viajes 
        // Ya cobre el valor correcto 
        //Cargamos 600
        // Hicimos 6 viajes  
        // 600 - (60*4+120*2) = 120 
        $this->assertEquals(120, $tarjetaTest->consultarSaldo());
        //Verifica que se realizaron 1 viajes
        $this->assertEquals(0, $tarjetaTest->viajemedio());
        $this->assertEquals(6, $tarjetaTest->consultarViajes());

        //Verifica que no pueda realizar mas viajes 
       //$this->assertEquals(FALSE, $tarjetaTest->hacerViaje(120));
    }
}
?>