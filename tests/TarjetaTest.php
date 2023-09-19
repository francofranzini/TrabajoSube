<?php 

namespace TrabajoSube;
require_once 'src/Tarjeta.php';
/*require_once 'src/franquiciaCompleta.php';
require_once 'src/franquiciaParcial.php';
require_once 'src/Colectivo.php';
require_once 'src/Boleto.php';
*/
use PHPUnit\Framework\TestCase;


class tarjetaTest extends TestCase{
    
    public function testProbarTodoslosSaldos(){
        $cargasPosibles = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);

        foreach ($cargasPosibles as $carga) {
            $tarjetaTest = new Tarjeta;
            $tarjetaTest->cargarTarjeta($carga);
            $this->assertEquals($carga, $tarjetaTest->consultarSaldo());
        }
    }

    

    public function testCargarValoresNoValidos(){
        
        //Creamos una instancia de tarjeta para hacer pruebas
        $tarjetaTest = new Tarjeta;
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
        $tarjetaTest = new Tarjeta;
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
        $tarjetaTest = new Tarjeta;
        
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
}
?>