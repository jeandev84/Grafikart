<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * Class permettant de s'authentifier
 * Class SecurityController
 * @package App\Controller
*/
class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils [ Utilites d'authentification ]
     * @return Response
     *
     * $ php bin/console config:dump-reference
     * $ php bin/console config:dump-reference LeNomDuComposantADebuger
     * $ php bin/console config:dump-reference security
     */
     public function login(AuthenticationUtils $authenticationUtils)
     {
         /* Obtenir les erreurs d'authentification */
         $error = $authenticationUtils->getLastAuthenticationError();

         /* Obtenir le dernier nom taper par l'utilisateur */
         $lastUsername = $authenticationUtils->getLastUsername();

         return $this->render('security/login.html.twig', [
             'last_username' => $lastUsername,
             'error' => $error
         ]);
     }

     /*
     Route("/logout", name="logout")
     public function logout()
     {

     }
     */
}