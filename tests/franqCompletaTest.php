<?php 

namespace TrabajoSube;
//require 'src/Tarjeta.php';
require 'src/franquiciaCompleta.php';


use PHPUnit\Framework\TestCase;

class franqCompletaTest extends TestCase{

    public function testProbarViaje(){
        $tarjetaTest = new franquiciaCompleta;
        //Verificamos si puede viajar 
        $this->assertEquals(TRUE, $tarjetaTest->hacerViaje(120));

        }
}
?>