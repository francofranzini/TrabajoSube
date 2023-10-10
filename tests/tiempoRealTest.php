<?php 

namespace TrabajoSube;


use PHPUnit\Framework\TestCase;

class tiempoRealTest extends TestCase{
    public function testTiempoReal(){
        $tiempoReal = new TiempoReal;
        $tiempo = $tiempoReal->time();
        $dia = $tiempoReal->dia();
        $hora = $tiempoReal->hora();
        $this->assertEquals(date('l', time()), $dia);
    }

    
}