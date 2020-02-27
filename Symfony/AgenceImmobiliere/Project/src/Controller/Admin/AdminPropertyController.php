<?php
namespace App\Controller\Admin;


#use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * Class AdminPropertyController
 * @package App\Controller\Admin
 */
class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;


    /**
     * AdminPropertyController constructor.
     * @param PropertyRepository $repository
     * @param ObjectManager $em
     */
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        # recuperation de toutes les biens
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }


    /**
     * @Route("/admin/property/create", name="admin.property.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $property = new Property();

        # On cree notre formulaire ( Formulaire )
        $form = $this->createForm(PropertyType::class, $property);


        # On demande a notre formulaire de gerer la requette
        $form->handleRequest($request);


        # On verifie si le formulaire a ete envoye et si les donnees sont valides
        if($form->isSubmitted() && $form->isValid())
        {
            # persite sur notre nouvelle entity
            $this->em->persist($property);

            # on va sauvegarder les donnees
            $this->em->flush();

            # Ajouter un flash
            $this->addFlash('success', 'Bien cree avec succes');

            # redirige l'utilisateur vers la route admin.property.index
            return $this->redirectToRoute('admin.property.index');
        }

        # Rendre la vue
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * createForm peut prendre en parametre la classe Type et les donnees(Entity ou array)
     */
    public function edit(Property $property, Request $request)
    {

        /*
         Ajout d'un bien ( En utilisant les methodes de relations )
         $option = new Option();
         $property->addOption($option);
        */


        # On cree notre formulaire ( Formulaire )
        $form = $this->createForm(PropertyType::class, $property);

        # On demande a notre formulaire de gerer la requette
        $form->handleRequest($request);


        # On verifie si le formulaire a ete envoye et si les donnees sont valides
        if($form->isSubmitted() && $form->isValid())
        {
            # on va sauvegarder les donnees
            $this->em->flush();

            # Ajouter un flash
            $this->addFlash('success', 'Bien modifie avec succes');


            # redirige l'utilisateur vers la route admin.property.index
            return $this->redirectToRoute('admin.property.index');
        }


        # retourne une reponse et les differents parametres
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, Request $request)
    {
        # On verifie si le token est valide
        if($this->isCsrfTokenValid('delete'. $property->getId(), $request->get('_token')))
        {
            # On retire l'objet qu'on veut
            $this->em->remove($property);

            # On sauvegarde les changements
            $this->em->flush();


            # Ajouter un flash
            $this->addFlash('success', 'Bien supprime avec succes');


            /* return new Response('Suppression'); */
        }

        # Redirection vers la page qui permet de lister les biens
        return $this->redirectToRoute('admin.property.index');
    }
}