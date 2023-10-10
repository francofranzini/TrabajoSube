<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;


class tarjetaTest extends TestCase{
    
    public function testProbarTodoslosSaldos(){
        $cargasPosibles = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);

        foreach ($cargasPosibles as $carga) {
            $tiempoFalso= new TiempoFalso();
            $tarjetaTest = new Tarjeta(1,$tiempoFalso);
            $tarjetaTest->cargarTarjeta($carga);
            $this->assertEquals($carga, $tarjetaTest->consultarSaldo());
        }
    }

    

    public function testCargarValoresNoValidos(){
        
        //Creamos una instancia de tarjeta para hacer pruebas
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
        $tarjetaTest->cargarTarjeta(100);

        //Verifica que no se haya cargado debido a que no se puede cargar 100 pesos
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());

        
        $tarjetaTest->cargarTarjeta(30);
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());

        $tarjetaTest->cargarTarjeta(3300);
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());

        $tarjetaTest->cargarTarjeta(1233);
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());
        
        $tarjetaTest->cargarTarjeta(160);
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());
       

    }
    public function testCargarDeMas(){
        
        //Creamos una instancia de tarjeta para hacer pruebas
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
        $this->assertEquals(1, $tarjetaTest->getID());
        
        $tarjetaTest->cargarTarjeta(600);
        $tarjetaTest->cargarTarjeta(2000);
        $tarjetaTest->cargarTarjeta(4000);
        //Verificamos que se haya cargado correctamente:
        $this->assertEquals(6600, $tarjetaTest->consultarSaldo());

        //Intentamos cargar en el excedente y verificamos que siga igual
        $tarjetaTest->cargarTarjeta(600);
        $this->assertEquals(6600, $tarjetaTest->consultarSaldo());
    }
    public function testCargarDeMas2(){
        
        //Creamos una instancia de tarjeta para hacer pruebas
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
        $this->assertEquals(1, $tarjetaTest->getID());
        
        $tarjetaTest->cargarTarjeta(4000);
        //saldo = 4000
        $tarjetaTest->cargarTarjeta(2000);
        //saldo = 6000
        $tarjetaTest->cargarTarjeta(4000);
        //saldo = 6600 y cargasPendientes = 3400
        //Verificamos que se haya cargado correctamente:
        $this->assertEquals(6600, $tarjetaTest->consultarSaldo());
        $this->assertEquals(3400, $tarjetaTest->consultarCargasPendientes());

    }

    public function testViajePlus()
    {
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
        
        $tarjetaTest->cargarTarjeta(150);
        
        //Realizamos 3 viaje 
        for ($i = 0; $i < 3; $i++) {
            $tarjetaTest->hacerViaje(120);
        }

        //Verifica si el saldo es de menos 210 que es el valor que le deberia quedar a la tarjeta
        $this->assertEquals(-210, $tarjetaTest->consultarSaldo());
        //Verifica que se realizaron 3 viajes
        $this->assertEquals(3, $tarjetaTest->consultarViajes());

        //Verifica que no pueda realizar mas viajes 
        $this->assertEquals(FALSE, $tarjetaTest->hacerViaje(120));

    }

    public function testCargasPendientes()
    {
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
        
        $tarjetaTest->cargarTarjeta(4000);
        $tarjetaTest->cargarTarjeta(2000);
        $tarjetaTest->cargarTarjeta(600);
        $this->assertEquals(6600, $tarjetaTest->consultarSaldo());
        
        $tarjetaTest->cargarTarjeta(600);
        $this->assertEquals(600, $tarjetaTest->consultarCargasPendientes());
        $tarjetaTest->cargarTarjeta(150);
        $this->assertEquals(750, $tarjetaTest->consultarCargasPendientes());
        $tarjetaTest->cargarTarjeta(200);
        $this->assertEquals(950, $tarjetaTest->consultarCargasPendientes());
        $tarjetaTest->cargarTarjeta(1300);
        $this->assertEquals(2250, $tarjetaTest->consultarCargasPendientes());

        //PROBAR QUE PASA UNA VEZ QUE VIAJAS
    }
    public function testCargarSaldoPendiente(){
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
        $colectivoTest = new Colectivo(144);
        
        $tarjetaTest->cargarTarjeta(4000);
        $tarjetaTest->cargarTarjeta(2000);
        $tarjetaTest->cargarTarjeta(600);
        //SALDO EN 6600

        $tarjetaTest->cargarTarjeta(600);
        $this->assertEquals(600, $tarjetaTest->consultarCargasPendientes());

        $this->assertEquals(6600, $tarjetaTest->consultarSaldo());
        $colectivoTest->pagarCon($tarjetaTest);
        //Saldo de la tarjeta deberia ser el mismo si pagamos y recargamos
        //las cargas pendientes
        $this->assertEquals(6600, $tarjetaTest->consultarSaldo());
        //tendria que haber reducido el saldoPendiente en 120
        $this->assertEquals(480, $tarjetaTest->consultarCargasPendientes());

    }

    public function testBoletoUsoFrecuente(){
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);
      

        //Realizamos 24 viajes de 150 pesos para confirmar que todos se hacen al mismo costo
        // Y cargamos el mismo costo 
        // Es decir al finalizar el for el saldo restante tiene que ser 0
        for ($i = 0; $i < 29; $i++) {
            $tarjetaTest->cargarTarjeta(150);
            $tarjetaTest->hacerViaje(150);
        }
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());
        //Confirmamos que se hayan realizado 29 viajes
        $this->assertEquals(29, $tarjetaTest->consultarViajes());
        
        //$tarjetaTest->cargarTarjeta((150));
        //Realizamos una carga de 800 y realizamos un viaje de 1000 por lo que 
        // El saldo tendria que quedar en 0
        $tarjetaTest->cargarTarjeta((800));
        $tarjetaTest->hacerViaje(1000);
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());
        $this->assertEquals(30, $tarjetaTest->consultarViajes());

        //Cargamos la tarjeta con el 80 porciento de descuento en un viaje de 1000 
        //por lo que la tarjeta deberia quedar en 0
        //
        for ($i = 0; $i < 50; $i++) {
            $tarjetaTest->cargarTarjeta(800);
            $tarjetaTest->hacerViaje(1000);
        }
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());

        //Realizamos una carga de 750 y realizamos un viaje de 1000 por lo que 
        // El saldo tendria que quedar en 0
        $tarjetaTest->cargarTarjeta(500);
        $tarjetaTest->cargarTarjeta(250);
        $tarjetaTest->hacerViaje(1000);
        $this->assertEquals(0, $tarjetaTest->consultarSaldo());
        $this->assertEquals(81, $tarjetaTest->consultarViajes());

        //Verificamos que cualquier viaje en adelante se le aplique el 25 porciento de descuento
        for ($i = 0; $i < 49; $i++) {
               
            $tarjetaTest->cargarTarjeta(500);
            $tarjetaTest->cargarTarjeta(250);
            $tarjetaTest->hacerViaje(1000);
         
            }
            $this->assertEquals(0, $tarjetaTest->consultarSaldo());
       
    }
    public function testReiniciarViajes(){
        $tiempoFalso= new TiempoFalso();
        $tarjetaTest = new Tarjeta(1,$tiempoFalso);

        $tarjetaTest->cargarTarjeta(500);
        $tarjetaTest->hacerViaje(120);
        $tarjetaTest->hacerViaje(120);
        $this->assertEquals(2, $tarjetaTest->consultarViajes());

        //Avanzamos un mes
        $tiempoFalso->avanzarDias(31);
        $tarjetaTest->hacerViaje(120);
        $this->assertEquals(1, $tarjetaTest->consultarViajes());
    }
}
?>