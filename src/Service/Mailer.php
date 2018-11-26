<?php

namespace App\Service;

class Mailer {
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $templating;

    /**
     * MailerManager constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $templating
     */

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function createSend($mail, $tickets, $price, $datedubillet, $code) {
        $subject = 'Musée du Louvre - Confirmation';
        $from = 'billeterie@museedulouvre.fr';
        $to = $mail;
        $body = $this->templating->render('louvre/mail.html.twig', [
            'tickets' => $tickets,
            'price' => $price,
            'date' => $datedubillet,
            'code' => $code
        ]);
        $this->send($subject, $from, $to, $body);
    }

    public function send(string $subject, string $from, string $to, $body)
    {
        /** @var \Swift_Mime_SimpleMessage $mail */
        $mail = $this->mailer->createMessage();
        $mail->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body)
            ->setContentType('text/html');
        $this->mailer->send($mail);
    }
}