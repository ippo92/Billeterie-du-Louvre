<?php


namespace App\Tests\Entity;


use PHPUnit\Framework\TestCase;

class TicketsTest extends TestCase
{
    public function testCountry()
    {
        $order = $this->getMockForAbstractClass('App\Entity\Tickets');
        $order->setCountry('France');
        $this->assertNotNull($order->getCountry());
        $this->assertEquals('France', $order->getCountry());
    }
    public function testFirstName()
    {
        $order = $this->getMockForAbstractClass('App\Entity\Tickets');
        $order->setFirstName('mohamed');
        $this->assertNotNull($order->getFirstName());
        $this->assertEquals('mohamed', $order->getFirstName());
    }
    public function testCategory()
    {
        $order = $this->getMockForAbstractClass('App\Entity\Tickets');
        $order->setCategory('tarif normal');
        $this->assertNotNull($order->getCategory());
        $this->assertEquals('tarif normal', $order->getCategory());
    }
}