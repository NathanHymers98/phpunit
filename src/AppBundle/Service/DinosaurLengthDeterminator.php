<?php


namespace AppBundle\Service;

use AppBundle\Entity\Dinosaur;


class DinosaurLengthDeterminator
{
    public function getLengthFromSpecification(string $specification): int
    {
        // Creating an array with keys. For example, 'huge' is the key and the '=>' sign indicates what it holds, which in this case 'min' holds the constant HUGE (which is 30) and 'max' holds 100.
        // Overall this means that the min length cannot go lower than the const HUGE (30) and the max length cannot go higher than 100
        $availableLengths = [
            'huge' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'omg' => ['min' => Dinosaur::HUGE, 'max' => 100],
            '😱' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'large' => ['min' => Dinosaur::LARGE, 'max' => Dinosaur::HUGE - 1],
        ];
        $minLength = 1;
        $maxLength = Dinosaur::LARGE - 1;

        foreach (explode(' ', $specification) as $keyword) {
            $keyword = strtolower($keyword);

            if (array_key_exists($keyword, $availableLengths)) {
                $minLength = $availableLengths[$keyword]['min'];
                $maxLength = $availableLengths[$keyword]['max'];

                break;
            }
        }

        return random_int($minLength, $maxLength);
    }

}