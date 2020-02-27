<?php
namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class PropertySearchType
 * @package App\Form
 */
class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('minSurface', IntegerType::class, [
            'required' => false,
            'label' => false,
            'attr' => [
                'placeholder' => 'Surface minimale'
            ]
        ])
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget maximal'
                ]
            ])
            ->add('options', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ]);

        /*
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher'
            ])
        */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get', // on indique que ce formulaire sera en GET
            'csrf_protection' => false, // desactivation du token csrf
        ]);
    }


    /**
     * Methode permettant d'avoir des parametres d'URL plus propre
     * afin de ne pas ecrire :
     *  property_search[minSurface] sera remplacer par minSurface
     *  property_search[maxPrice] sera remplacer par maxPrice
     *  Au lieu de :
     *  ?property_search[minSurface]=3&property_search[maxPrice]=20000
     *
     *  On aura :
     *  ?minSurface=3&maxPrice=20000
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}