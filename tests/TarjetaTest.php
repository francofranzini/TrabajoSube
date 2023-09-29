<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;


class tarjetaTest extends TestCase{
    
    public function testProbarTodoslosSaldos(){
        $cargasPosibles = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);

        foreach ($cargasPosibles as $carga) {
            $tiempoReal = new TiempoReal();
            $tarjetaTest = new Tarjeta(1,$tiempoReal);
            $tarjetaTest->cargarTarjeta($carga);
            $this->assertEquals($carga, $tarjetaTest->consultarSaldo());
        }
    }

    

    public function testCargarValoresNoValidos(){
        
        //Creamos una instancia de tarjeta para hacer pruebas
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new Tarjeta(1,$tiempoReal);
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
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new Tarjeta(1,$tiempoReal);
        $tarjetaTest->cargarTarjeta(600);
        $tarjetaTest->cargarTarjeta(2000);
        $tarjetaTest->cargarTarjeta(4000);

        //Verificamos que se haya cargado correctamente:
        $this->assertEquals(6600, $tarjetaTest->consultarSaldo());

        //Intentamos cargar en el excedente y verificamos que siga igual
        $tarjetaTest->cargarTarjeta(600);
        $this->assertEquals(6600, $tarjetaTest->consultarSaldo());
        
    }

    public function testViajePlus()
    {
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new Tarjeta(1,$tiempoReal);
        
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
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new Tarjeta(1,$tiempoReal);
        
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
        $tiempoReal = new TiempoReal();
        $tarjetaTest = new Tarjeta(1,$tiempoReal);
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
}
?>