<?php
namespace App\Form;

#use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class PropertyType
 * @package App\Form
*/
class PropertyType extends AbstractType
{

    /**
     * Permet de contruire le formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title') // Titre
            ->add('description') // Description
            ->add('surface') // Surface
            ->add('rooms') // Pieces
            ->add('bedrooms') // Chambres
            ->add('floor') // Etage
            ->add('price') // prix
            ->add('heat', ChoiceType::class, [ // select field ( Chauffage )
                'choices' =>  $this->getChoices()
            ])
            // ajout de champ select afin d'associe une 'Property' a une 'Option'
            /*
            ->add('options', EntityType::class, [
                'class' => '', //Option::class, // class cible
                'choice_label' => 'name', // Propriete utilise pour le label ( on utilise le 'name')
                'multiple' => true, // On autorise plusieurs options (Option)zz a etre selectionnes
            ])
            */
            ->add('city', null, [ // Ville
                'label' => 'Ville'  // redefinir le label
            ])
            ->add('address') // Addresse
            ->add('postal_code') // Code postal
            ->add('sold'); // Vendu
    }

    /**
     * Permet de definir les options du formulaire de facon global
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms' // ajout de system de traduction
        ]);
    }


    /**
     * @return array
    */
    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach($choices as $k => $v)
        {
            # inversion de cle $v comme cle et $k comme valeur
            $output[$v] = $k;
        }
        return $output;
    }

    /*
    private function formBuilding(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat')
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('address')
            ->add('postal_code')
            ->add('sold');
            // ->add('created_at'); En commentant cette ligne alors elle disparaitra
    }
    */
}