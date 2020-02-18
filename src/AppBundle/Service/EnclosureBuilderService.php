<?php

namespace AppBundle\Service;

use AppBundle\Entity\Enclosure;
use AppBundle\Entity\Security;
use AppBundle\Factory\DinosaurFactory;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DinosaurFactory
     */
    private $dinosaurFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        DinosaurFactory $dinosaurFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->dinosaurFactory = $dinosaurFactory;
    }

    public function buildEnclosure(
        int $numberOfSecuritySystems = 1,
        int $numberOfDinosaurs = 3
    ): Enclosure
    {
        $enclosure = new Enclosure();

        $this->addSecuritySystems($numberOfSecuritySystems, $enclosure);

        $this->addDinosaurs($numberOfDinosaurs, $enclosure);

        $this->entityManager->persist($enclosure);
        $this->entityManager->flush();

        return $enclosure;
    }

    private function addSecuritySystems(int $numberOfSecuritySystems, Enclosure $enclosure)
    {
        $securityNames = ['Fence', 'Electric fence', 'Guard tower'];
        for ($i = 0; $i < $numberOfSecuritySystems; $i++) {
            $securityName = $securityNames[array_rand($securityNames)];
            $security = new Security($securityName, true, $enclosure);

            $enclosure->addSecurity($security);
        }
    }

    private function addDinosaurs(int $numberOfDinosaurs, Enclosure $enclosure)
    {
        for ($i = 0; $i < $numberOfDinosaurs; $i++) { // This for loop checks to see if the loop counter $i is less than $numberOfDinosaurs, it continues the loop as long as $i is less than or equal to $numberOfDinosaurs. $i++ increases the loop counter value by 1 for each iteration
            $lengths = ['small', 'large', 'huge'];
            $diets = ['herbivore', 'carnivorous'];
            // We should not mix herbivore and carnivorous together,
            // so use the same diet for every dinosaur.
            $diet = $diets[array_rand($diets)];

            $length = $lengths[array_rand($lengths)];
            $specification = "{$length} {$diet} dinosaur";
            $dinosaur = $this->dinosaurFactory->growFromSpecification($specification);

            $enclosure->addDinosaur($dinosaur);
        }


    }
}
