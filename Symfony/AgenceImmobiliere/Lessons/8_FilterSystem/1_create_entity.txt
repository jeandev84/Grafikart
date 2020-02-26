<?php
namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class PropertySearch [ Classe permettant de faire une recherche ]
 * @package App\Entity
 * Generate getters and setters ( Alt + Insert ) ou click droit Generate ( Getters and Setters)
 * https://www.jetbrains.com/help/phpstorm/generating-code.html
 */
class PropertySearch
{

    /**
     * @var int|null
     */
    private $maxPrice;


    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     * signifit qu'on aura au minimum 10 m2 et au maximum 400 m2
     */
    private $minSurface;


    /**
     * @var ArrayCollection
     */
    private $options;


    /**
     * PropertySearch constructor.
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
    }


    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     */
    public function setMaxPrice(int $maxPrice)
    {
        $this->maxPrice = $maxPrice;
    }

    /**
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param int|null $minSurface
     */
    public function setMinSurface(int $minSurface)
    {
        $this->minSurface = $minSurface;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setOptions(ArrayCollection $options)
    {
        $this->options = $options;
    }


}