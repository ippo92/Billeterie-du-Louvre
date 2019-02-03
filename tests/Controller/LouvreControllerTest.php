<?php


namespace App\Tests\Controller;


use App\Controller\LouvreController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class LouvreControllerTest extends TestCase
{
    public function testHome() {

        $request = new Request();
        $home = new LouvreController();
        $home = $home->home(Request::create("/", 'GET'));
    }

}