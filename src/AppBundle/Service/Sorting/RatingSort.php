<?php
/**
 * Created by PhpStorm.
 * User: marcinworwa
 * Date: 25.06.2018
 * Time: 20:13
 */

namespace AppBundle\Service\Sorting;


class RatingSort implements SortStrategy
{
    public function sort(array $array)
    {
        usort($array, function($a, $b)
        {
            return $a->getRating() < $b->getRating();
        });

        return $array;
    }

}