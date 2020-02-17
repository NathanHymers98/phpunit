<?php


namespace Tests\AppBundle\Factory;

use AppBundle\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;
use AppBundle\Factory\DinosaurFactory;


class DinosaurFactoryTest extends TestCase
{
    /**
     * @var DinosaurFactory
     */
    private $factory; // Creating a new variable with an annotation that tells my IDE that it is going to be an object of DinosaurFactory

    public function setUp() : void// If we have a method called exactly "setUp" PHP Unit will automatically call it before each test.
    {
        $this->factory = new DinosaurFactory();
    }

    public function testItGrowsAVelciraptor()
    {
         // Creating a new Dinosaur factory object
        $dinosaur = $this->factory->growVelociraptor(5); // Assigning the variable $dinosaur to create a new DinosaurFactory object by calling the factory property inside this class, then pointing to the method we want to test which is inside the class Dinosaur factory
                                                                // Which is why we need to create the object in order to access it.

        $this->assertInstanceOf(Dinosaur::class, $dinosaur); // Asserting that there is an instance (object) of the Dinsosaur class as the expected result and passing the $dinosaur variable. This makes sure that the $dinosaur variable is holding an object of the Dinosaur class.
        $this->assertInternalType('string', $dinosaur->getGenus()); // Checks to see if thing we get back is of the string type, then passing it the method that does this
        $this->assertSame('Velociraptor', $dinosaur->getGenus()); // Making sure that if we get a string back, that the string is the name of the dinosaur, then passing it the method that does this
        $this->assertSame(5, $dinosaur->getLength()); // Making sure that we get a 5 back for the length, again we then pass it the method that gets the length of the dinosaur.

    }

    public function testItGrowsATriceratops()
    {
        $this->markTestIncomplete('Waiting for conformation'); // By using this method and passing a custom message, it marks that this in an incomplete test and doesn't flag it up as an failed test and gives us the message to serve as a reminder.
    }

    public function testItGrowsABabyVelociratpr()
    {
        if (!class_exists('Nanny')) { // If a class called 'Nanny' doesn't exist, then skip this test and give a helpful message.
            $this->markTestSkipped('There is nobody to watch the baby raptor');
        }

        $dinosaur = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLength());
    }

    // Adding the annotation below to make sure it runs the test as many times as it needs to go through all the test cases
    /**
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsADinosaurFromASpecification(string $spec, bool $expectedIsLarge, bool $expectedIsCarnivorous) // Passing 3 arguments because these are going to be the values of the array
    {
        $dinosuar = $this->factory->growFromSpecification(); // Creating a dinosuar object that has a specification

        if ($expectedIsLarge) { // If the dinosaur is large, then execute the code below
            $this->assertGreaterThanOrEqual(Dinosaur::LARGE, $dinosuar->getLength()); // Asserting that the Dinosuar's length is greater than or equal to the constant variable LARGE (which is 20)
        }else{
            $this->assertLessThan(Dinosaur::LARGE, $dinosuar->getLength()); // If the dinosaur is not large, then execute this code instead which asserts that the dinosaur is less than value of LARGE (20)
            }

        $this->assertSame($expectedIsCarnivorous, $dinosuar->isCarnivorous(), 'Diets do not match'); // Asserting that the dinosuar object is carnivorous by using the variable $expectedIsCarnivorous and if it is not, then show the custom failure message
    }

    public function getSpecificationTests() // This function doesn't start with the word test because it isn't supposed to be a test, it's to provide the different test cases that we want to try.
                                            // When this function is called it will run the test that it is being called in the same amount of times as there are test cases. So in this case 3 times because there is 3 test cases
    {
        return [ // returning an array
            // specification is large, is carnivorous
            ['large carnivorous dinosaur', true, true], // passing true twice because we expect the dinosaur to be large and carnivorous. This will be the first test case, which is to create a large carnivourous dinosaur
            ['give me all the cookies', false, false], // Adding another item to the array, which is false in both because it is not large and it is not carnivorous
            ['large herbivore', true, false], // This test case is true and false. The first value is true because it us large, the second is false because it is not a carnivore

        ];
    }
}