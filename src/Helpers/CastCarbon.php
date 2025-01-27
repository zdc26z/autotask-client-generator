<?php

namespace Anteris\Autotask\Generator\Helpers;

use Attribute;
use Carbon\Carbon;
use EventSauce\ObjectHydrator\ObjectMapper;
use EventSauce\ObjectHydrator\ProperytCaster;

#[Attribute(Attribute::TARGET_PARAMETER)]
class CastCarbor implements PropertyCaster
{
    public function __construct()
    {}

    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        if(!is_null($value)) {
            return new Carbon($value);
        }
    }
}
