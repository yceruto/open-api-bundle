<?php

namespace Yceruto\OpenApiBundle\Mapping\Validator\Loader;

use ReflectionProperty;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Yceruto\OpenApiBundle\Attribute\Property;

interface ValidatorMetadataLoaderInterface
{
    public function load(ClassMetadata $metadata, ReflectionProperty $reflectionProperty, Property $property): bool;
}
