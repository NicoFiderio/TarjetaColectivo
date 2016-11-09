<?php
namespace Poli\Tarjeta;

class TarjetaTest extends \PHPUnit_Framework_TestCase {

  protected $tarjeta,$bici,$colectivo1,$colectivo2;	

  public function setup(){
			$this->tarjeta = new Baja();
			$this->colectivo1 = new Colectivo("143 Rojo", "Rosario Bus");
			$this->colectivo2 = new Colectivo("35/9 Rojo", "Rosario Bus");
	  		$this->bici=new Bicicleta(123);
  }	

  public function testRecargar() {
	$this->tarjeta->recargar(272);
	$this->assertEquals($this->tarjeta->saldo(), 320, "Cuando cargo 272 deberia tener finalmente 320");
	$this->tarjeta = new Baja();
	$this->tarjeta->recargar(273);
	$this->assertEquals($this->tarjeta->saldo(), 273, "Cuando cargo 273 deberia tener finalmente 273");
  }

 public function testPagarConTransbordo() {
  	$this->tarjeta= new Baja();
	$this->tarjeta->recargar(100);
  	$this->tarjeta->pagar($this->colectivo1, "2016/09/29 11:05");
	$this->assertEquals($this->tarjeta->saldo(), 92, "Cuando recargo 100 y pago un colectivo deberia tener finalmente 92");	
	$this->tarjeta->pagar($this->colectivo2, "2016/09/29 11:50");
	$this->assertEquals($this->tarjeta->saldo(), 89.5, "Cuando pago un colectivo con transbordo deberia tener finalmente 89.5");  	
  }
 public function testPagarSinSaldoEnLaTarjeta(){
	$this->tarjeta->pagar($this->bici,"2016/09/29 12:00");
	$this->assertEquals($this->tarjeta->saldo(), 0, "Si pago una bicicleta sin saldo me tiene que rechazar el pago");
	$this->tarjeta->pagar($this->colectivo1,"2016/09/29 06:00");
	$this->tarjeta->pagar($this->colectivo2,"2016/09/29 08:00");
	$this->tarjeta->pagar($this->colectivo1,"2016/09/29 10:00");
	$this->assertEquals($this->tarjeta->viajePLus(), 2, "Si marco en 3 colectivos sin tener saldo deberia poder pagar nada mas los dos primeros");
	$this->tarjeta->recargar(20);
	$this->assertEquals($this->tarjeta->saldo(), 4, "Si cargo 20 y habia usado dos viajes plus deberia tener cobrarme los dos plus y tener finalmente 4");
 }
public function testPagarSinTransbordo() {
  	$this->tarjeta->recargar(100);
  	$this->tarjeta->pagar($this->colectivo1, "2016/09/29 15:50");
   	$this->tarjeta->pagar($this->colectivo2, "2016/09/29 17:30");
  	$this->assertEquals($this->tarjeta->saldo(), 84, "Si tengo 100 y pago dos colectivos sin transbordo deberia tener finalmente 84");
 
  }
public function testPagarSinTransbordoMismoColectivo() {
  	$this->tarjeta->recargar(100);
  	$this->tarjeta->pagar($this->colectivo1, "2016/09/29 16:20");
  	$this->tarjeta->pagar($this->colectivo1, "2016/09/29 17:00");
  	$this->assertEquals($this->tarjeta->saldo(), 304, "Si tengo 312 y pago un colectivo sin transbordo ya que es el mismo deberia tener finalmente 304");
}

?>
