<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Class UserFixtures
 * @package App\DataFixtures
*/
class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
   */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     * Apres remplissage de load,
     * On lance la commande suivante pour changer les fixtures en base de donnees :
     *  php bin/console doctrine:fixtures:load
    */
    public function load(ObjectManager $manager)
    {
        # mot de passe 'demo'
        $user = new User(); // UserInterface
        $user->setUsername('demo');
        $user->setPassword(
            $this->encoder->encodePassword($user, 'demo')
        );

        $manager->persist($user);
        $manager->flush();
    }
}
