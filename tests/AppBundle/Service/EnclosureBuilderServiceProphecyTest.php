<?php


namespace Tests\AppBundle\Service;


use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\EnclosureBuilderService;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Enclosure;
use Doctrine\ORM\EntityManagerInterface;
use Prophecy\Argument;

class EnclosureBuilderServiceProphecyTest extends TestCase // This class does the same as EnclosureBuilderServiceTest but uses Prophecy
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->prophesize(EntityManagerInterface::class);

        $em->persist(Argument::type(Enclosure::class))
        ->shouldBeCalledTimes(1);

        $em->flush()->shouldBeCalled(); // Checking to see if flush is called by using the prophecy method shouldbeCalled()

        $dinoFactory = $this->prophesize(DinosaurFactory::class); // Creating a new DinosaurFactory mock object

        $dinoFactory
            ->growFromSpecification(Argument::type('string')) // Checks to make sure that the method growFromSpecification is passed an argument which has a type of string
            ->shouldbeCalled(2) // Checks to see if the method is called 2 times
            ->willReturn(new Dinosaur()); // Checks to see if the method returns a new Dinosaur object

        $builder = new EnclosureBuilderService( // Creating a new EnclosureBuilderService object called $builder. Since the original class needs to be passed two arguments which are also services, I have created mocks of the services it needs and passed them as arguments
            $em->reveal(), // When we finally pass the mock object, we need to call reveal()
            $dinoFactory->reveal()
        );
        $enclosure = $builder->buildEnclosure(1, 2); // The arguments passed equal to how many security system and Dinos are used. In this case there is 1 security system and 2 dinos

        $this->assertCount(1, $enclosure->getSecurities()); // Asserting that 1 matches the count of system securitites in the enclosure
        $this->assertCount(2, $enclosure->getDinosaurs()); // Asserting that 2 matches the count of dinos in the enclosure
    }
}