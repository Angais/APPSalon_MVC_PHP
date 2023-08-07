<?php
namespace Model;

class Servicio extends ActiveRecord{
    protected static $tabla = "servicios";
    protected static $columnasDB = ["id", "nombre", "precio"];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = []){
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->precio = $args["precio"] ?? "";
    }

    public function validar(){
        if(!$this->nombre){
            self::$alertas["error"][] = "Añada un nombre";
        }
        if(!$this->precio){
            self::$alertas["error"][] = "Añada un precio";
        }
        if(!is_numeric($this->precio)){
            self::$alertas["error"][] = "El precio debe ser un número";
        }

        return self::$alertas;
    }
}