<?php 

namespace TrabajoSube;


use PHPUnit\Framework\TestCase;

class franquiciaParcialTest extends TestCase{

    public function testBoletoMitadPrecio(){
        $tarjetaTest = new franquiciaParcial;
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
        $tarjetaTest = new franquiciaParcial;
        
        $tarjetaTest->cargarTarjeta(150);
        
        //Realizamos 3 viaje 
        for ($i = 0; $i < 4; $i++) {
            $tarjetaTest->hacerViaje(120);
            //primer viaje -> 60
            //segudno viaje -> noviaja uoop 60
            //tercerviaje -> noviaja dou 60
        }

        //Verifica si el saldo es de menos 90 que es el valor que le deberia quedar a la tarjeta
        $this->assertEquals(-90, $tarjetaTest->consultarSaldo());
        //Verifica que se realizaron 3 viajes
        $this->assertEquals(4, $tarjetaTest->consultarViajes());

        //Verifica que no pueda realizar mas viajes 
        $this->assertEquals(FALSE, $tarjetaTest->hacerViaje(120));
    }


}
?>