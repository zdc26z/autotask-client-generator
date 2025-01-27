<?php

namespace Anteris\Autotask\Generator\Responses\EntityFields;

use Attribute;
use Illuminate\Support\Collection;
use Anteris\Autotask\Generator\Helpers\Str;
use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\PropertyCaster;
use EventSauce\ObjectHydrator\DefinitionProvider;
use EventSauce\ObjectHydrator\KeyFormatterWithoutConversion;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;

/**
 * Represents an entity field response from Autotask.
 */
class EntityFieldDTO
{
    /**
     * Overrides the default construct to fix some problems.
     */
    public function __construct(
        #[CastName]
        public string $name,
        #[CastDataType]
        public string $dataType,
        public int $length,
        public bool $isRequired,
        public bool $isReadOnly,
        public bool $isQueryable,
        public bool $isReference,
        public string $referenceEntityType,
        public bool $isPickList,
        public ?array $picklistValues,
        public ?string $picklistParentValueField,
        public bool $isSupportedWebhookField,
    )
    {
        if('ContractID' === $this->name) {
            $this->dataType = 'int';
        }

        if('null' === $this->dataType) {
            $this->isRequired = false;
        }
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
            $field = $mapper->hydrateObject(static::class, $item);
            $collection->push( $field );
        }

        return $collection;
    }
}

#[Attribute(Attribute::TARGET_PARAMETER)]
class CastName implements PropertyCaster
{
    public function __construct() {}

    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        $weirdWords = [
            'GLCode'    => 'glCode',
            'MSRP'      => 'msrp',
            'RMM'       => 'rmm',
            'SGDA'      => 'sgda',
            'SIC'       => 'sic',
            'SKU'       => 'sku',
        ];

        foreach ($weirdWords as $original => $fixed) {
            if($original === $value) {
                $value = $fixed;
                continue;
            }

            if(substr($value, 0, strlen($original)) !== $original) {
                continue;
            }

            $value = Str::replaceFirst(
                $original,
                $fixed,
                $value
            );
        }

        return Str::camel($value);
    }
}

#[Attribute(Attribute::TARGET_PARAMETER)]
class CastDataType implements PropertyCaster
{
    public function __construct()
    {}

    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        switch($value) {
            case 'datetime':
                return '?Carbon';
            case 'integer':
                return '?int';
            case 'boolean':
                return '?bool';
            case 'byte[]':
            case 'short':
                return 'mixed';
            case 'double':
            case 'decimal':
            case 'long':
                return '?float';
            default:
                return '?' . $value;
        }
    }
}
