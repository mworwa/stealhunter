<?php
/**
 * Created by PhpStorm.
 * User: marcinworwa
 * Date: 25.06.2018
 * Time: 20:23
 */

namespace AppBundle\Service\Sorting;


class SorterFactory
{
    public function create(array $array, string $sortStrategy)
    {
        switch ($sortStrategy) {
            case 'rating':
                $sort = new RatingSort();
                break;
            default:
                throw new \RuntimeException('Unknown sorting strategy');
        }
        return new Sorter($array, $sort);
    }
}