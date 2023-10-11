<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;


class ColectivoTest extends TestCase{
    public function testPagarConSaldo(){
        //Instancia de colectivo
        $colectivoTest = new Colectivo;
        //Creamos una instancia de tarjeta para hacer pruebas
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
        $tarjetaTest->cargarTarjeta(200);

        //traemos el valor del boleto a partir del colectivo
        $tarifa = $colectivoTest->tarifa();

        //Pagamos el bondi
        $colectivoTest->pagarCon($tarjetaTest);

        //Verificar que:
        //- se este cargando correctamente la tarifa
        $this->assertEquals($tarifa, 120);
        //- el saldo se reduzca correctamente
       // $this->assertEquals(1, $tarjetaTest->consultarViajes());
        $this->assertEquals(80, $tarjetaTest->consultarSaldo());
    }
    public function testPagarSinSaldo(){
        //Instancia de colectivo
        $colectivoTest = new Colectivo;
        //Creamos una instancia de tarjeta para hacer pruebas

        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
        $tarjetaTest->cargarTarjeta(100);

        //Verifica que no se haya cargado debido a que no se puede cargar 100 pesos
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());

        //Damos una carga valida
        $tarjetaTest->cargarTarjeta(150);

        //Pagamos el bondi
        $colectivoTest->pagarCon($tarjetaTest);

        //Consultamos que el saldo restante sea 30
        $this->assertEquals(30, $tarjetaTest->consultarSaldo());

    }
  
}