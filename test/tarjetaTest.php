<?php
namespace Poli\Tarjeta;

class TarjetaTest extends \PHPUnit_Framework_TestCase {

  protected $tarjeta,$colectivo1;	

  public function setup(){
			$this->tarjeta = new Baja();
			$this->colectivo1 = new Colectivo("143 Rojo", "Rosario Bus");
			$this->colectivo2 = new Colectivo("35/9 Rojo", "Rosario Bus");
			$this->colectivo3 = new Colectivo("133 Verde", "Verde");
  }	

  public function testRecargar() {
    $this->tarjeta->recargar(272);
    $this->assertEquals($this->tarjeta->saldo(), 320, "Cuando cargo 272 deberia tener finalmente 320");
    $this->tarjeta = new Baja();
    $this->tarjeta->recargar(273);
    $this->assertEquals($this->tarjeta->saldo(), 273, "Cuando cargo 273 deberia tener finalmente 273");
  }

 public function testPagar() {
  	$this->tarjeta= new Baja();
	$this->tarjeta->recargar(272);
  	$this->tarjeta->pagar($this->colectivo1, "2016/09/29 11:05");
	$this->assertEquals($this->tarjeta->saldo(), 312, "Cuando recargo 272 y pago un colectivo deberia tener finalmente 312");	
	$this->tarjeta->pagar($this->colectivo2, "2016/09/29 11:15");
	$this->assertEquals($this->tarjeta->saldo(), 309.5, "Cuando pago un colectivo con transbordo deberia tener finalmente 309.5");
	$this->tarjeta->pagar($this->colectivo3, "2016/09/29 20:00");
	$this->assertEquals($this->tarjeta->saldo(), 301.5, "Cuando pago un colectivo sin transbordo deberia tener finalmente 301.5");  	
  }
}

?>
