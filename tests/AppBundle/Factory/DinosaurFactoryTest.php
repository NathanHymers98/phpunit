<?php


namespace Tests\AppBundle\Factory;

use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\TestCase;
use AppBundle\Factory\DinosaurFactory;
use PHPUnit\Framework\MockObject\MockObject;

class DinosaurFactoryTest extends TestCase
{
    /**
     * @var DinosaurFactory
     */
    private $factory; // Creating a new variable with an annotation that tells my IDE that it is going to be an object of DinosaurFactory

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $lengthDeterminator;

    public function setUp(): void// If we have a method called exactly "setUp" PHP Unit will automatically call it before each test.
    {
        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class); // Creating a mock object of the class DinosaurLengthDeterminator
        $this->factory = new DinosaurFactory($this->lengthDeterminator);
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
    public function testItGrowsADinosaurFromASpecification(string $spec, bool $expectedIsCarnivorous) // Passing 2 arguments because these are going to be the values of the array
    {
        $this->lengthDeterminator->expects($this->once()) // The follow method must be called exactly once
            ->method('getLengthFromSpecification') // This is the name of the method that we want to call and want to control while using the mock object lengthDeterminator.
            ->with($spec) // if the real method expects 3 arguments, then we will pass these arguments with the with() function
            ->willReturn(20); // This is the value that the mock objects method will return, instead of doing the real logic

        $dinosuar = $this->factory->growFromSpecification($spec); // Creating a dinosuar object that has a specification

        $this->assertSame($expectedIsCarnivorous, $dinosuar->isCarnivorous(), 'Diets do not match'); // Asserting that the dinosuar object is carnivorous by using the variable $expectedIsCarnivorous and if it is not, then show the custom failure message
        $this->assertSame(20, $dinosuar->getLength());
    }

    public function getSpecificationTests() // This function doesn't start with the word test because it isn't supposed to be a test, it's to provide the different test cases that we want to try.
        // When this function is called it will run the test that it is being called in the same amount of times as there are test cases. So in this case 3 times because there is 3 test cases
    {
        return [ // returning an array
            //Key: specification, is carnivorous
            ['large carnivorous dinosaur', true],
            ['give me all the cookies', false],
            ['large herbivore', false],

        ];
    }

//    // This annotation below tells our program that this test method should use the method below it as a data provider.
//    /**
//     * @dataProvider getHugeDinosaurSpecTests
//     */
//    public function testItGrowsAHugeDinosaur(string $specification)
//    {
//        $dinosaur = $this->factory->growFromSpecification($specification); // Creating a dinosaur from the specification.
//
//        $this->assertGreaterThanOrEqual(Dinosaur::HUGE, $dinosaur->getLength()); // Using the const HUGE and comparing it to the length of the dinosaur.
//    }
//
//    public function getHugeDinosaurSpecTests() // Creating a data provider for the huge dinosaur test above.
//    {
//        return [
//            ['huge dinosaur'],
//            ['huge dino'],
//            ['huge'],
//            ['OMG'],
//        ];
//    }
}
