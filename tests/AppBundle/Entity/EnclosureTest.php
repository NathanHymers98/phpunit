<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Dinosaur;
use AppBundle\Exception\NotABuffetException;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Enclosure;
use AppBundle\Exception\DinosaursAreRunningRampantException;


class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaursByDefault()
    {
        $enclosure = new Enclosure(); // Creating a new enclosure object

        $this->assertEmpty($enclosure->getDinosaurs()); // Asserting that the newly created enclosure is empty
    }

    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur()); // Adding 2 dinos to the created enclosure
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaurs()); // Asserting that the enclosure has 2 dinos
    }

    public function testItDoesNotAllowCarnivorousDinosToMixWithHerbivores()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur()); // By default Dinosaurs are non-carnivorous

        $this->expectException(NotABuffetException::class);

        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true)); // Creating a new dino with a name and bool value 'true' so that it is carnivorous
    }

    /**
     * @expectedException \AppBundle\Exception\NotABuffetException
     */
    public function testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));

        $enclosure->addDinosaur(new Dinosaur());
    }

    public function testItDoesNotAllowToAddDinosToUnsecureEnclosures()
    {
        $enclosure = new Enclosure();

        $this->expectException(DinosaursAreRunningRampantException::class);
        $this->expectExceptionMessage('Are you craaazy?!?');

        $enclosure->addDinosaur(new Dinosaur());
    }
}