<?php
/**
 * Created by PhpStorm.
 * User: marcinworwa
 * Date: 25.06.2018
 * Time: 20:12
 */

namespace AppBundle\Service\Sorting;


interface SortStrategy
{
    public function sort(array $array);
}