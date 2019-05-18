<?php

namespace App\Controller;

use App\Entity\Departement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Contact;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {

        $em = $this->getDoctrine()->getManager();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $departement = $contact->getIdepartement();
            $message = (new \Swift_Message('Nouveau Contact'))
                ->setFrom('no-reply@noreply.com')
                ->setTo($departement->getEmaildep())
                ->setBody($this->renderView('messages/message.html.twig', [
                    'firstname' => $contact->getFirstname(),
                    'lastname' => $contact->getLastname(),
                    'message' => $contact->getMessage(),
                    'email' => $contact->getEmail()
                ]), 'text/html');

            $mailer->send($message);

            $em->flush();


            $this->addFlash('success', 'Contact enregistré et message bien envoyé!');
            return $this->redirectToRoute('contact');

        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
