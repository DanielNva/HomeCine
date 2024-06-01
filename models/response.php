

<?php
class Response {
    public $mensaje;
    public $codigo;
    public $exito;

    public function __construct($mensaje, $codigo, $exito) {
        $this->mensaje = $mensaje;
        $this->codigo = $codigo;
        $this->exito = $exito;
    }
}
?>