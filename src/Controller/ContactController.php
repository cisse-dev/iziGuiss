<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Mailer;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $repoContact, Request $request,Mailer $mailer,
    EntityManagerInterface $manager): Response
    {   
        $contact = $repoContact->findAll();
        
        $contact = new Contact;
         $form = $this->createForm(ContactType::class, $contact );

         $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($contact);
            $manager->flush(); 
            
            $this->addFlash(
            'success',
            'Votre demande a été envoyé avec succés !');  
            
        
        
        };
 

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'categories' => $contact,
            'formContact' => $form->createView()

            
        ]);
    }
}
