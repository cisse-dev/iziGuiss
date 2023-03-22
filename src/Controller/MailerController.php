<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;


class MailerController extends AbstractController
{  
    #[Route('/email', name: 'email')]

    public function sendEmail(MailerInterface $mailer , Request $request) : Response
     
    { 
            $email = (new Email())
            // email address as a simple string
            ->from('fabien@example.com')

            // email address as an object
            ->from(new Address('fabien@example.com'))

            // defining the email address and name as an object
            // (email clients will display the name)
            ->from(new Address('fabien@example.com', 'Fabien'))

            // defining the email address and name as a string
            // (the format must match: 'Name <email@example.com>')
            ->from(Address::create('Fabien Potencier <fabien@example.com>'));



   

    // ...

    }
}  
       
       
