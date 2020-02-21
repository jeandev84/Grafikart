<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PropertyController
 * @package App\Controller
*/
class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="property.index")
    */
    public function index(): Response
    {
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
}
