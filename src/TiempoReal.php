<?php
namespace TrabajoSube;


class TiempoReal implements TiempoInterface 
{
    public function time(){
        return time();
    }
    public function dia(){
        return date('l', time());
    }

    public function hora(){
        return date('G', time());
    }
}


?>