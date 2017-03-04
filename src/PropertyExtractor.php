<?php

/**
 * This file is part of Hydrator lib.
 * (c) 2017. Rostyslav Tymoshenko <krifollk@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Krifollk\Hydrator;

/**
 * Class PropertyExtractor
 *
 * @package Krifollk\Hydrator
 */
class PropertyExtractor implements ExtractorInterface
{
    /** @var PropertyResolverInterface */
    private $propertyResolver;

    /**
     * PropertyExtractor constructor.
     *
     * @param PropertyResolverInterface $propertyResolver
     */
    public function __construct(PropertyResolverInterface $propertyResolver = null)
    {
        $this->propertyResolver = $propertyResolver;
    }

    /**
     * @inheritdoc
     */
    public function extractProperty($object, string $property)
    {
        if ($this->propertyResolver !== null) {
            $property = $this->propertyResolver->resolve($property);
        }

        $closure = function (string $property) {
            return $this->{$property};
        };

        return $closure->call($object, $property);
    }

    /**
     * @inheritdoc
     */
    public function extractProperties($object, array $properties): array
    {
        if ($this->propertyResolver === null) {
            return $this->plainExtract($object, $properties);
        }

        return $this->extractWithResolver($object, $properties);
    }

    /**
     * Extract properties without using resolver
     *
     * @param object $object
     * @param array  $properties
     *
     * @return array
     */
    private function plainExtract($object, array $properties): array
    {
        $closure = function (array $properties) {
            $result = [];

            foreach ($properties as $property) {
                $result[$property] = $this->{$property};
            }

            return $result;
        };

        return $closure->call($object, $properties);
    }

    private function extractWithResolver($object, array $properties): array
    {
        $closure = function (array $properties, PropertyResolverInterface $propertyResolver) {
            $result = [];

            foreach ($properties as $property) {
                $result[$property] = $this->{$propertyResolver->resolve($property)};
            }

            return $result;
        };

        return $closure->call($object, $properties, $this->propertyResolver);
    }
}
