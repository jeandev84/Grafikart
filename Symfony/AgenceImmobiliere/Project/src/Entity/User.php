<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
*/
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     * Retourne toute la liste des roles
     * example: ROLE_ADMIN, ROLE_USER, ROLE_MODERATOR ..
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    /**
     * @inheritDoc
     * Retourne un salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     * Permet de supprimer des informations qui ont ete stockes dans l'entite
     * unset certaines properties
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    # L'interface \Serializable permet a l'utilisateur de s'authentifier par session
    /**
     * @inheritDoc
     * Convertit notre objet en chaine
    */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    /**
     * @inheritDoc
     * @param string $serialized (la chaine serialisee)
     * Convertit notre chaine ne object
     * allowed_classes : false (pour ne pas forcer les classes si elles sont dans cette serialization)
    */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
