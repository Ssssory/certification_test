<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class RandomizeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('randomize', [$this, 'randomizeFilter']),
        ];
    }

    public function randomizeFilter($input)
    {
        // Check if the input is a Doctrine PersistentCollection
        if ($input instanceof \Doctrine\ORM\PersistentCollection) {
            // Convert the PersistentCollection to an array
            $array = $input->toArray();

            // Randomly shuffle the array
            shuffle($array);

            // Return the shuffled array as a new PersistentCollection
            return $array;
        }

        return $input;
    }
}
