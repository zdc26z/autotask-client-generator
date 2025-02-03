<?php

namespace Anteris\Autotask\API;

use ReflectionClass;
use ReflectionProperty;
use Illuminate\Support\Collection;
use EventSauce\ObjectHydrator\DefinitionProvider;
use EventSauce\ObjectHydrator\KeyFormatterWithoutConversion;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;

class Entity
{
    public function all(): array()
    {
        $data = [];
        $class = new ReflectionClass(static::class);
        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach($properties as $property) {
            if($property->isStatic()) {
                continue;
            }

            $name = $property->getName();
            $data[$name] = $property->getValue($this);
        }

        return $data;
    }

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

    public function toArray(): array
    {
        return $this->parseArray($this->all());
    }

    protected function parseArray(array $array): array
    {
        foreach($array as $key => $value) {
            if($value instanceof Entity) {
                $array[$key] = $value->toArray();
                continue;
            }

            if(!is_array($value)) {
                continue;
            }

            $array[$key] = $this->parseArray($value);
        }

        return $array;
    }
}
