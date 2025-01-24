<?php

namespace Anteris\Autotask\API;

use Illuminate\Support\Collection;
use EventSauce\ObjectHydrator\DefinitionProvider;
use EventSauce\ObjectHydrator\KeyFormatterWithoutConversion;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;

class Entity
{
    public static function arrayOf(array $items): Collection
    {
        $mapper = new ObjectMapperUsingReflection(
            new DefinitionProvider(
                keyFormatter: new KeyFormatterWithoutConversion(),
            ),
        );

        $collection = Collection::empty();
        foreach($items as $item) {
            $collection->push( $mapper->hydrateObject(static::class, $item) );
        }

        return $collection;
    }
}
