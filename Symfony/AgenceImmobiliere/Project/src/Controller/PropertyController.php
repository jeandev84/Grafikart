<?php
namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PropertyController
 * @package App\Controller
*/
class PropertyController extends AbstractController
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
     * PropertyController constructor.
     * @param PropertyRepository $repository
     * @param ObjectManager $em
   */
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/biens", name="property.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        # Creer une entite qui va representer notre recherche
        $search = new PropertySearch();

        # Creer un formulaire
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);


        # Mise en place d'une pagination
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        # Affiche la vue et on passes les differents parametres
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param string $slug
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301); // redirection permanente
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }

    /*
    public function indexExample(PropertyRepository $repository): Response
    {
        dump($repository);

        $property = new Property();
        $property->setTitle('Mon premier bien')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription('Une petite description')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1) // 1 equivaut a => electric Property::HEAT
            ->setCity('Montpellier')
            ->setAddress('15 Boulevard Gambetta')
            ->setPostalCode('34000')
            //->setCreatedAt(new \DateTime())
        ;

        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();


        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    public function index(): Response
    {
        # recuperation d'une seule propriete
        $property = $this->repository->find(1);
        dump($property);

        # recuperation de toutes les proprietes
        $properties = $this->repository->findAll();
        dump($properties);

        # recuperation de toutes les proprietes se trouvant au 4ieme etage
        # or Example: findBy(['sold' => true]);
        $propertiesOnFourthFloor = $this->repository->findBy(['floor' => 4]);

        # recuperation d'une propriete se trouvant au 4-ieme etage
        $propertyOnFourthFloor = $this->repository->findOneBy(['floor' => 4]);
        dump($propertyOnFourthFloor);


        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();


        return $this->render('property/index.html.twig', [
        'current_menu' => 'properties'
        ]);
     }

      public function flushSold()
      {
        $property = $this->repository->findAllVisible();
        dump($property);
        $property[0]->setSold(true);
        $this->em->flush();
       }
    */
}
