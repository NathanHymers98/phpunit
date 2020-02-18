<?php


namespace Tests\AppBundle\Service;


use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Enclosure;


class EnclosureBuilderServiceTest extends TestCase
{
    public function testItBuildsPersistsEnclosure()
    {
        $em = $this->createMock(EntityManagerinterface::class);

        $em->expects($this->once()) // This is making sure that the entityManager method 'persist' is only called once.
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class));

        $em->expects($this->once())
            ->method('flush'); //  Making sure that the method 'flush' is only called once

        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $dinoFactory->expects($this->exactly(2))
            ->method('growFromSpecification')
            ->willReturn(new Dinosaur())
            ->with($this->isType('string'));

        $builder = new EnclosureBuilderService($em, $dinoFactory); // Creating a new EnclosureBuilderService object called $builder. Since the original class needs to be passed two arguments which are also services, I have created mocks of the services it needs and passed them as arguments
        $enclosure = $builder->buildEnclosure(1, 2); // The arguments passed equal to how many security system and Dinos are used. In this case there is 1 security system and 2 dinos

        $this->assertCount(1, $enclosure->getSecurities()); // Asserting that 1 matches the count of system securitites in the enclosure
        $this->assertCount(2, $enclosure->getDinosaurs()); // Asserting that 2 matches the count of dinos in the enclosure
    }

}