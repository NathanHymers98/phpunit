<?php


namespace AppBundle\Factory;


use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{

    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {

        $this->lengthDeterminator = $lengthDeterminator;
    }

    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length); // Since we created the method below to create a dinosaur, everytime we want to create a new dinosaur it will be like this. (Passing the arguments that are in the original method)

    }

    // The method below allows us to create dinosaurs with random/preset values.
    public function growFromSpecification(string $specification) : Dinosaur // The ": Dinosaur" part at the end of the method is telling the program what this method is returning
    {
        // When a dinosaur is created and no values have been passed as arguments, these are the default values that they are given
        $codeName = 'InG-' . random_int(1, 99999); // $codeName will be used as genus, because they don't have an actual name
        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);
        $isCarnivorous = false;



        if (stripos($specification, 'carnivorous') !== false) { // Checking to see if the spec contains carnivorous.
            $isCarnivorous = true;// If it does, then set the value to true
        }

        $dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length); // Create a new dinosaur and the arguments will be the variables we created above.

        return $dinosaur;
    }

    private function createDinosaur(string $genus, bool $isCarnivorours, int $length): Dinosaur // This method will be responsible for creating new Dinosaur objects and in order to create a dinosaur it needs to have 3 arguments.
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorours); // Creating a new Dinosaur object and passing it the properties instead of values it should have so that they can be changed by other methods.

        $dinosaur->setLength($length);

        return $dinosaur; // Returning the created Dinosaur object, this is so that when another method calls this method and passes the correct arguments, they are given a Dinosaur object.

    }


}