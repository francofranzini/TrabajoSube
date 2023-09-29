<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase{

    public function testCargarBoleto(){
        $colectivoTest = new Colectivo(144);
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new Tarjeta(1,$tiempoReal);


        //verificar que el colecctivo guarde bien su linea, para pasarlo al boleto
        $this->assertEquals(144, $colectivoTest->linea());
        
        $boletoTest = new Boleto($tarjetaTest, $colectivoTest);
        //verificar que el boleto guarde bien la linea
        $this->assertEquals($colectivoTest->linea(), $boletoTest->lineaColectivo());
        //verificar el saldo del boleto sea el mismo que el de la tarjeta
        $this->assertEquals($tarjetaTest->consultarSaldo(), $boletoTest->saldoRestante());
        //verificar que el tipo de tarjeta sea el que corresponde
        $this->assertEquals(get_class($tarjetaTest), $boletoTest->tipoDeTarjeta());
        //verificar que la id de la tarjeta sea la que corresponde
        $this->assertEquals($tarjetaTest->getID(), $boletoTest->id());
         //verificar que la fecha de la tarjeta sea la que corresponde
        //$this->assertEquals(date('d-m-Y', $tiempoReal->tiempo->time()), $boletoTest->fecha());
        $this->assertEquals(date('d-m-Y', time()), $boletoTest->fecha());
        

        $tarjetaMF = new franquiciaParcial(1,$tiempoReal);
        $boletoMF = new Boleto($tarjetaMF, $colectivoTest);
        //verificar que el boleto guarde bien la linea
        $this->assertEquals($colectivoTest->linea(), $boletoMF->lineaColectivo());
        //verificar el saldo del boleto sea el mismo que el de la tarjeta
        $this->assertEquals($tarjetaMF->consultarSaldo(), $boletoMF->saldoRestante());
        //verificar que el tipo de tarjeta sea el que corresponde
        $this->assertEquals(get_class($tarjetaMF), $boletoMF->tipoDeTarjeta());
        //verificar que la id de la tarjeta sea la que corresponde
        $this->assertEquals(date('d-m-Y', time()),$boletoMF->fecha() );
        
        $tarjetaFC = new franquiciaCompleta(1,$tiempoReal);
        $boletoFC = new Boleto($tarjetaFC, $colectivoTest);
        //verificar que el boleto guarde bien la linea
        $this->assertEquals($colectivoTest->linea(), $boletoFC->lineaColectivo());
        //verificar el saldo del boleto sea el mismo que el de la tarjeta
        $this->assertEquals($tarjetaFC->consultarSaldo(), $boletoFC->saldoRestante());
        //verificar que el tipo de tarjeta sea el que corresponde
        $this->assertEquals(get_class($tarjetaFC), $boletoFC->tipoDeTarjeta());
        //verificar que la id de la tarjeta sea la que corresponde
        $this->assertEquals($tarjetaFC->getID(), $boletoFC->id());
         //verificar que la fecha de la tarjeta sea la que corresponde
        $this->assertEquals(date('d-m-Y', time()),$boletoFC->fecha() );
        
            
    }   


}
?>