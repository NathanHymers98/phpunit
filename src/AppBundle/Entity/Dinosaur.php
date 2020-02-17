<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dinosaurs")
 */
class Dinosaur
{
    const LARGE = 20; // Creating a constant variable called 'LARGE' that is always equal to 20

    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;

    /**
     * @ORM\Column(type="string")
     */
    private $genus;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCarnivorus;

    public function __construct(string $genus = 'Unknown', bool $isCarnivorous = false) // Whenever a new Dinosaur object is made, it needs to be passed it's name (genus) and a boolean value which determines if it is carnivours or not
    {
        $this->genus = $genus;
        $this->isCarnivorus = $isCarnivorous;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length)
    {
        $this->length = $length;
    }

    public function getSpecification() // This method returns a sprintf with a string which replaces the %s's and the one %d with the data given.
    {
        return sprintf(
            'The %s %scarnivours dinosaur is %d meters long',
            $this->genus, // This gets the name of the dinosaur and puts it into the first %s, in the case of this test it would be Tyrannosurus
            $this->isCarnivorus ? '' : 'non-', // This checks to see if when the dinosaur object is created if it is passed a boolean value of true or false. If true then it will display nothing because the string above already has that value.
                                                            // However if the boolean value is false, then it will add 'non-' where the second %s is which will make it say 'non-carnivours'
            $this->length // This sets the %d to the length of the dinosaur object that has been created.
        );
    }

    public function getGenus(): string
    {
        return $this->genus;
    }

    public function isCarnivorous()
    {
        return $this->isCarnivorus;
    }

}
