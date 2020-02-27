<?php
namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

/**
 * Class ContactNotification
 * @package App\Notification
*/
class ContactNotification
{
    /**
     * @var \Swift_Mailer
    */
    private $mailer;


    /**
     * @var Environment
     */
    private $renderer;

    /**
     * ContactNotification constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
     public function __construct(\Swift_Mailer $mailer, Environment $renderer)
     {
         $this->mailer = $mailer;
         $this->renderer = $renderer;
     }

    /**
     * Envoie de message
     * @param Contact $contact
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
    */
     public function notify(Contact $contact)
     {
         $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
                    ->setFrom('noreply@agence.fr') # example : $contact->getEmail()
                    ->setTo('contact@agence.fr') # a qui est destine l'email
                    ->setReplyTo($contact->getEmail())
                    ->setBody(
                        $this->renderer->render('emails/contact.html.twig', [
                            'contact' => $contact
                      ])
                    ,'text/html');

         $this->mailer->send($message);
     }
}