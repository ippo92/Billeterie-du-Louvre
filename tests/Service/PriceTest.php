<?php


namespace App\Tests\Service;


use App\Entity\Orders;
use App\Entity\Tickets;
use App\Service\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testGetTicketsPrice() {
        $order = new Orders();
        $order->setNumberOfTickets(1);
        $order->setDate(new \DateTime('30-01-2019'));
        $datedubillet = $order->getDate();
        $ticket = new Tickets();
        $tickets[] = $ticket;
        $ticket->setDateOfBirth(new \DateTime('21-01-1998'));
        $ticket->setCategory('tarif normal');
        $client = new Price();
        $price = $client->getTicketsPrice($order, $tickets,$datedubillet);
        $this->assertEquals(16, $price);
    }

}