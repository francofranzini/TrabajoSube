<?php 

namespace TrabajoSube;


use PHPUnit\Framework\TestCase;

class franquiciaParcialTest extends TestCase{

    public function testBoletoMitadPrecio(){
        $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaParcial(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);
        $colectivoTest = new Colectivo(144);

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
        $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaParcial(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);

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
        $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaParcial(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);

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
   $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaParcial(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);

        $tarjetaTest->cargarTarjeta(600);
        
        //Realizamos 6 viaje 
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
    public function testViajarCasiMedianoche(){
        $tiempoFalso = new TiempoFalso();
        $tarjetaTest = new franquiciaParcial(1,$tiempoFalso);
        $tiempoFalso->avanzar(3600*8);
        $ct = new Colectivo(144);
     
      
        $tarjetaTest->cargarTarjeta(600);
        //Saldo = 600, viajesmedio = 4
        $tarjetaTest->hacerViaje($ct->tarifa());
        //Saldo = 540, viajesmedio = 3
        //No pasaron 5 min, no puede viajar. 
        $this->assertEquals(FALSE, $tarjetaTest->hacerViaje($ct->tarifa()));
        $tiempoFalso->avanzar(300);
        // deberia poder viajar
        $this->assertEquals(TRUE, $tarjetaTest->hacerViaje($ct->tarifa()));
        //Saldo = 480, viajesmedio = 2
        $tiempoFalso->avanzar(300);
       
        $tarjetaTest->hacerViaje($ct->tarifa());
        //Saldo = 420, viajesmedio = 1
        $this->assertEquals(1, $tarjetaTest->viajemedio());

        //PASAMOS LA MEDIANOCHE, cambiamos de dia y estamos en un horario habilitado para viajar
        $tiempoFalso->avanzar(3600*24);
        //Al hacer el siguiente viaje, viajesmedio = 4, pero como viajamos, 3.
        $tarjetaTest->hacerViaje($ct->tarifa());
        $this->assertEquals(3, $tarjetaTest->viajemedio());
        
    }


    public function testViajarFueraDeHorario(){
        $tiempoFalso = new TiempoFalso();
        $colectivoTest = new Colectivo;
        $tarjetaJubilado = new franquiciaParcial(1,$tiempoFalso);
        //Seteamos el tiempo a la 5 de la mañana es decir paga el boleto normal
        $tiempoFalso->avanzar(3600*5);
        $tarjetaJubilado->cargarTarjeta(150);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(30, $tarjetaJubilado->consultarSaldo());

        //Avanzamos 5 horas mas por lo que son las 10 de la mañana se puede viajar con medio
        $tiempoFalso->avanzar(3600*5);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(-30, $tarjetaJubilado->consultarSaldo());

        //Avanzamos 13 horas por lo que seran las 23hs por lo que tendra que pagar el boleto completo
        //Tendra que tener -90
        $tiempoFalso->avanzar(3600*13);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(-150, $tarjetaJubilado->consultarSaldo());
    }

    //Test para verificar que no viaje un sabado o un domingo con medio
    public function testViajarSabDom(){
        $tiempoFalso = new TiempoFalso();
        $colectivoTest = new Colectivo;
        $tarjetaJubilado = new franquiciaParcial(1,$tiempoFalso);
        
        // Puede viajar con medio son las 8 am de un jueves 
        $tiempoFalso->avanzar(3600*8);
        $tarjetaJubilado->cargarTarjeta(150);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(90, $tarjetaJubilado->consultarSaldo());

        //Tendra que pagar porque son las 8 de la mañana del Sabado 
        // ==> saldo = -30
        $tiempoFalso->avanzar(86400*2);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(-30, $tarjetaJubilado->consultarSaldo());

         //Tendra que pagar porque son las 8 de la mañana del Domingo 
        // ==> saldo = -150 
        $tiempoFalso->avanzar(86400);
        $tarjetaJubilado->hacerViaje(120);
        $this->assertEquals(-150, $tarjetaJubilado->consultarSaldo());

    }
    
}
?>