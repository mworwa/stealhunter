<?php
/**
 * Created by PhpStorm.
 * User: marcinworwa
 * Date: 25.06.2018
 * Time: 20:19
 */

namespace AppBundle\Service\Sorting;


class Sorter
{
    private $array;
    private $sortStrategy;

    public function __construct(array $array, SortStrategy $sortStrategy)
    {
        $this->array = $array;
        $this->sortStrategy = $sortStrategy;
    }

    public function sort() {
       return $this->array = $this->sortStrategy->sort($this->array);
    }
}