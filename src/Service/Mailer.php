<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use symphony\Component\Mine\Address;

class Mailer
{  
     private $mailer;
     public function __construct(MailerInterface $mailer) 
    { 
        $this->mailer = $mailer;
    } 

        public function sendEmail() 

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
              $this-mailer->send($email);
         }
        
}