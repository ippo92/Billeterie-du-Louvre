<?php

namespace App\Controller;

use App\Form\OrdersType;
use App\Form\TicketsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tickets;
use App\Entity\Orders;
use App\Repository\TicketsRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LouvreController extends AbstractController
{
    /**
     * @Route("/louvre", name="louvre")
     */
    public function index()
    {
        return $this->render('louvre/index.html.twig', [
            'controller_name' => 'LouvreController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request)
    {
        $Orders = new Orders();
        $form = $this->createForm(OrdersType::class, $Orders);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $formData = $form->getData();
            $request->getSession()->set('orders', $formData);
            return $this->redirectToRoute('ticket');
            }


        $repo = $this->getDoctrine()->getRepository(Tickets::class);
        $tickets = $repo->findAll();
        return $this->render('louvre/home.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/ticket", name="ticket")
     */
    public function ticket(Request $request)
    {
        $data = $request->getSession()->get('orders');
        $number = $data->getNumberOfTickets();
        echo $number;
        for ($i=0; $i<$number ;$i++){
        $tickets[] = new Tickets();
        }
        $form = $this->createForm(CollectionType::class, $tickets, ['entry_type' => TicketsType::class, 'allow_add' => true] );
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $formData = $form->getData();
            $request->getSession()->set('tickets', $formData);
            return $this->redirectToRoute('order');
        }
        return $this->render('louvre/ticket.html.twig', [
            'number' => $number,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/order", name="order")
     */
    public function order(Request $request)
    {
        $data = $request->getSession()->get('orders');
        $tickets = $request->getSession()->get('tickets');
        dump($tickets);
        $number = $data->getNumberOfTickets();
        $price = 0;
        $datedubillet = $data->getDate();
        $datedenaissance = $tickets->getDateOfBirth();

        for ($i=0; $i<$number ;$i++){
            if ($tickets[$i]->getCategory() == "1") {
            $price += 10;
            }
        }
        for ($i=0; $i<$number ;$i++){
            $datacategory = $tickets[$i]->getCategory();
            if ($datacategory == "1"){
                $category[] = 'Oui';
            }
            else{
                $category[] = 'Non';
            }

        }return $this->render('louvre/order.html.twig', [
        'number' => $number,
        'price' => $price,
        'category' => $category,
        'ticket' => $tickets
    ]);
    }



}
