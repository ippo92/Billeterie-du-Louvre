<?php


namespace App\Tests\Entity;


use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    public function testType()
    {
        $order = $this->getMockForAbstractClass('App\Entity\Orders');
        $order->setType('journée');
        $this->assertNotNull($order->getType());
        $this->assertEquals('journée', $order->getType());
    }
    public function testNumbersOfTickets()
    {
        $order = $this->getMockForAbstractClass('App\Entity\Orders');
        $order->setNumberOfTickets(3);
        $this->assertNotNull($order->getNumberOfTickets());
        $this->assertEquals(3, $order->getNumberOfTickets());
    }
    public function testMail()
    {
        $order = $this->getMockForAbstractClass('App\Entity\Orders');
        $order->setMail('mohasalim.gourari@gmail.com');
        $this->assertNotNull($order->getMail());
        $this->assertEquals('mohasalim.gourari@gmail.com', $order->getMail());
    }

}