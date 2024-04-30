<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class CollectionHelpers
{
    public static function getSetFromCollection(Collection $collection): array
    {
        $set = array_unique($collection->toArray());

        return ArrayHelpers::removeNullsFromArray(array: $set);
    }
}
