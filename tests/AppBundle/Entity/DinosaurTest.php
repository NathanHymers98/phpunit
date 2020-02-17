<?php


namespace Tests\AppBundle\Entity;


use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Dinosaur;

class DinosaurTest extends TestCase
{
    public function testSettingLength()
    {
        $dinosaur = new Dinosaur(); // Always creating an new dinsoaur object at the start of each test function.

        $this->assertSame(0, $dinosaur->getLength()); // assertSame method is passed 2 arguments, the first is the expected value and the second is the actual value.

        $dinosaur->setLength(9);
        $this->assertSame(9, $dinosaur->getLength());
    }

    public function testDinosaurHasNotShrunk()
    {
        $dinosaur = new Dinosaur();
        $dinosaur->setLength(15);

        $this->assertGreaterThan(12, $dinosaur->getLength(), 'Did you do something to it'); // As with all assert tests, it takes an expected value and the actual value. This time it has a message afterwards, this shows when the test fails.
    }

    public function testReturnsFullSpecificationOfDinosaur()
    {
        $dinosaur = new Dinosaur();

        $this->assertSame(
            'The Unknown non-carnivours dinosaur is 0 meters long',
            $dinosaur->getSpecification()
        );
    }

    public function testReturnsFullSpecificationForTyranosaurus()
    {
        $dinosaur = new Dinosaur('Tyrannosaurus', true); // Creating a new dinosaur object with a name and a boolean value of true. This is used by the function that we want to test to make sure that we get the correct name and type of the dinosaur

        $dinosaur->setLength(12); // Setting it's length to 12
        $this->assertSame(
            'The Tyrannosaurus carnivours dinosaur is 12 meters long', // This is the expected result of the test.
            $dinosaur->getSpecification() // This is the actual result of the test which calls directly to the function that we want to test to make sure that it works. If the test is successful the function will return the expected value.
        );

    }
}

