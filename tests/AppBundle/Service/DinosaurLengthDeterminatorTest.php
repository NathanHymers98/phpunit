<?php


namespace Tests\AppBundle\Service;


use AppBundle\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurLengthDeterminatorTest extends TestCase
{
    /**
     * @dataProvider getSpecLengthTests
     */
    public function testItReturnsCorrectLengthRange($spec, $minExpectedSize, $maxExpectedSize)
    {
        $determinator = new DinosaurLengthDeterminator();
        $actualSize = $determinator->getLengthFromSpecification($spec);

        $this->assertGreaterThanOrEqual($minExpectedSize, $actualSize); // This asserts that $actualSize is greater than or equal to $minExpectedSize
        $this->assertLessThanOrEqual($maxExpectedSize, $actualSize); // This asserts that $actualSize is less than or equal to $maxExpectedSize
    }

    public function getSpecLengthTests()
    {
        return [ // returning an array
            // specification is min length, max length
            ['large carnivorous dinosaur', Dinosaur::LARGE, Dinosaur::HUGE -1],
            ['give me all the cookies', 0, Dinosaur::LARGE -1],
            ['large herbivore', Dinosaur::LARGE, Dinosaur::HUGE -1],
            ['huge dinosaur', Dinosaur::HUGE, 100],
            ['huge dino', Dinosaur::HUGE, 100],
            ['huge', Dinosaur::HUGE, 100],
            ['OMG', Dinosaur::HUGE, 100],

        ];
    }
}