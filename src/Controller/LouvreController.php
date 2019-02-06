<?php

namespace App\Controller;

use App\Form\OrdersType;
use App\Form\TicketsType;
use App\Service\Mailer;
use App\Service\Payment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tickets;
use App\Entity\Orders;
use App\Service\Price;
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
        if($form->isSubmitted() && $form->isValid()){
            $formData = $form->getData();
            $repo = $this->getDoctrine()->getRepository(Orders::class);
            $date = new \DateTime();
            $date = date_format($date, 'd-m-Y');
            $count = count($repo->findBy(['date' => new \DateTime($date)]));
            if ($count < 999) {
                $request->getSession()->set('orders', $formData);
                return $this->redirectToRoute('ticket');
            }
            else {
                $this->addFlash(
                    'danger',
                    $message = "Plus de 1000 tickets ont deja été réservés pour ce jour. Merci de choisir une autre date de visite"
                );
                return $this->render('louvre/home.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        }
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
        for ($i=0; $i<$number ;$i++){
        $tickets[] = new Tickets();
        }
        $form = $this->createForm(CollectionType::class, $tickets, ['entry_type' => TicketsType::class, 'allow_add' => true] );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
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
    public function order(Request $request, Price $priceservice, Payment $payment, ObjectManager $manager, Mailer $mailer)
    {
        $data = $request->getSession()->get('orders');
        $tickets = $request->getSession()->get('tickets');
        $number = $data->getNumberOfTickets();
        $mail = $data->getMail();
        $datedubillet = $data->getDate();
        for ($i=0; $i<$number ;$i++){
            if($tickets[$i]->getCategory() == ""){
                $tickets[$i]->setCategory("tarif normal");
            }
            if($tickets[$i]->getCategory() == "1"){
                $tickets[$i]->setCategory("tarif réduit");
            }
        }
        $price = $priceservice->getTicketsPrice($data, $tickets, $datedubillet);


        if ($request->isMethod('POST')) {
            $token = $request->request->get('stripeToken');
            $payment->Pay($token,$price,$mail);
            $code = substr(md5(uniqid(rand(), true)), 16, 16);
            $mailer->createSend($mail, $tickets, $price, $datedubillet, $code);
            $data->setBookingCode($code);
            if($data->getType() == ""){
                $data->setType("demi-journée");
            }
            if($data->getType() == "1"){
                $data->setType("journée");
            }
            $manager->persist($data);
            $manager->flush();
            for($i=0; $i<$number ;$i++){
                $tickets[$i]->setOrders($data);
                $manager->persist($tickets[$i]);
            }
            $manager->flush();
            return $this->redirectToRoute('success');
        }

        return $this->render('louvre/order.html.twig', [
        'number' => $number,
        'mail' => $mail,
        'price' => $price,
        'tickets' => $tickets
    ]);
    }
    /**
     * @Route("/success", name="success")
     */
    public function success()
    {
        return $this->render('louvre/success.html.twig');
    }



}