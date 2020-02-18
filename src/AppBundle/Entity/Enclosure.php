<?php


namespace AppBundle\Entity;

use AppBundle\Exception\DinosaursAreRunningRampantException;
use AppBundle\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Adding annotations to the class to make it a Doctrine Entity
/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    // The annotation below signifies to the Doctrine database that the $dinosuars property has a ManyToOne relation ship with $enclosure
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
     */
    private $dinosaurs;

    // The annotaions below tell the program that this property is a collection of security objects, which will give us better auto completion
    /**
     * @var Collection|Security[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Security", mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;

    public function __construct(bool $withBasicSecurity = false)
    {
        $this->securities = new ArrayCollection();
        $this->dinosaurs = new ArrayCollection();

        if ($withBasicSecurity) { // If the argument passed when creating a new encloure object is true, then add security
            $this->addSecurity(new Security('Fence', true, $this)); // Creating a new Security object with the passed values it needs, which is a string for name, a bool for if the security is active, and the enclosure object which is $this because it is relating to itself
        }
    }

    /**
     * @return Collection
     */
    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur)
    {

        if (!$this->canAddDinosaur($dinosaur)) { // If the enclosure can't add a dino, then throw the NotABuffetException
            throw new NotABuffetException();
        }

        if (!$this->isSecurityActive()) {
            throw new DinosaursAreRunningRampantException('Are you craaazy?!?');
        }

        $this->dinosaurs[] = $dinosaur; // Adds a new dinosaur object to the dinosaurs array.
    }

    public function addSecurity(Security $security)
    {
        $this->securities[] = $security;
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) { // Looping through the $securites array as $security
            if ($security->getIsActive()) { // If security is active, then return true.
                return true;
            }
        }
        return false; // If it is not active then return false
    }

    public function getSecurities(): Collection
    {
        return $this->securities;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0 // If the ammount of dinos in the enclosure is exactly equal to 0 then it is ok to add more dinos to the enclosure
            || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous(); // Or check to see if the first dino that was added is carnivorous. (This simply relates to what order the code is in, if two dino objects have been created on 2 seperate lines, then first() will select the one that is first)
    }

}